<?php
namespace common\components\queue;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use yii\base\Component;

/**
 * RabbitMQ Server Interface
 * @author Vinh Banh <apacheservices68@gmail.com>
 * @package common\components\queue
 * @version 1.0
 */
class RabbitMQ extends Component
{

    /**
     * @var bool
     */
    public $enable = false;
    /**
     * @var array
     */
    public $server = [
        'host' => 'rabbitmq',
        'port' => 5672,
        'user' => 'zet',
        'pass' => 'qwe123',
        'vhost' => '/',
    ];

    /**
     * @var AMQPStreamConnection
     */
    private $_currentConnection = false;
    /**
     * @var bool
     */
    private $isConnected = false;

    /**
     *
     */
    public function init()
    {
        parent::init();

        if ($this->_currentConnection === false) {
            $this->_currentConnection = $this->initiateConnection();
        }
        $this->isConnected = true;
    }

    /**
     * @return bool
     */
    public function isConnected()
    {
        return $this->isConnected;
    }


    /**
     * @return AMQPStreamConnection
     */
    private function initiateConnection()
    {
        // init new amqp connection
        try {
            return new AMQPStreamConnection(
                $this->server['host'],
                $this->server['port'],
                $this->server['user'],
                $this->server['pass'],
                $this->server['vhost']
                #false, 'AMQPLAIN', null, 'en_US', 3, 3, null, false, 1
            );

        } catch (\Exception $ex) {
            // write log
            echo "Connection fail. Please check rabbitmq-server is running.";
            echo  $ex->getMessage();
        }
    }

    /**
     * @param $message
     * @param $exchange
     * @param string $key
     * @param bool $print
     */
    public function pub($message, $exchange, $key = 'all', $print = true)
    {
        // init connection
        $connection = $this->initiateConnection();

        // init channel
        $channel = $connection->channel();

        /*
            declare exchange
            name: $exchange
            type: topic
            passive: false
            durable: true // the exchange will survive server restarts
            auto_delete: false //the exchange won't be deleted once the channel is closed.
        */
        // $channel->exchange_declare($exchange, 'topic', false, false, false);

        $msg = new AMQPMessage($message, ['delivery_mode' => 2]);

        $channel->basic_publish($msg, $exchange, $key);
        if($print){
            echo " [*] " . date('d/m/Y H:i:s', time()) . " \n";
            echo " [*] Sent ", $key, ': ', $message, " \n";
        }
        $channel->close();
        $connection->close();
    }

    /**
     * @param $exchange
     * @param string $key
     * @param bool $callback
     */
    public function sub($exchange, $key = 'all', $callback = false)
    {
        // init connection
        $connection = $this->_currentConnection;
        // init channel
        $channel = $connection->channel();
        /*
            declare exchange
            name: $exchange
            type: topic
            passive: false
            durable: true // the exchange will survive server restarts
            auto_delete: false //the exchange won't be deleted once the channel is closed.
        */
        $channel->exchange_declare($exchange, 'topic', false, true, false);

        /*
            auto generate queue
            name: $queue
            passive: false
            durable: true // the queue will survive server restarts
            exclusive: false // the queue can be accessed in other channels
            auto_delete: false //the queue won't be deleted once the channel is closed.
        */
//        list($queue_name, ,) = $channel->queue_declare("", false, true, false, false);
        $queue_name = 'Queue.for.'.$key;
        $channel->queue_declare($queue_name, false, true, false, false);

        $channel->queue_bind($queue_name, $exchange, $key.'.#');
        echo " [*] " . date('d/m/Y H:i:s', time()) . " \n";
        echo ' [*] Waiting for processing. To exit press CTRL+C', " \n";

        // init callback function
        if ($callback == false)
            $callback = function ($msg) {
                echo ' [x] ', $msg->delivery_info['routing_key'], ': ', $msg->body, "\n";
                echo "Done \n";
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
            };

        /*
            queue_name:
            consumer_tag: Consumer identifier
            no_local: Don't receive messages published by this consumer.
            no_ack: Tells the server if the consumer will acknowledge the messages.
            exclusive: Request exclusive consumer access, meaning only this consumer can access the queue
            nowait:
            callback: A PHP Callback
        */
        $channel->basic_qos(null, 1, null);
        /*
        Message acknowledgments are turned off by default.
        It's time to turn them on by setting the fourth parameter to basic_consume to false (true means no ack)
        and send a proper acknowledgment from the worker,
        once we're done with a task.
        */
        $channel->basic_consume($queue_name, '', false, false, false, false, $callback);

        while (count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }

    /**
     * @param $exchange
     * @param string $key
     * @param bool $callback
     */
    public function subImportArticle($exchange, $key = 'all', $callback = false)
    {
        // init connection
        $connection = $this->_currentConnection;
        // init channel
        $channel = $connection->channel();
        /*
            declare exchange
            name: $exchange
            type: topic
            passive: false
            durable: true // the exchange will survive server restarts
            auto_delete: false //the exchange won't be deleted once the channel is closed.
        */
        $channel->exchange_declare($exchange, 'direct', false, true, false);

        /*
            auto generate queue
            name: $queue
            passive: false
            durable: true // the queue will survive server restarts
            exclusive: false // the queue can be accessed in other channels
            auto_delete: false //the queue won't be deleted once the channel is closed.
        */
//        list($queue_name, ,) = $channel->queue_declare("", false, true, false, false);
        $queue_name = 'Queue.for.'.$key;
        $channel->queue_declare($queue_name, false, true, false, false);

        $channel->queue_bind($queue_name, $exchange, $key);
        echo " [*] " . date('d/m/Y H:i:s', time()) . " \n";
        echo ' [*] Waiting for processing. To exit press CTRL+C', " \n";

        // init callback function
        if ($callback == false)
            $callback = function ($msg) {
                echo ' [x] ', $msg->delivery_info['routing_key'], ': ', $msg->body, "\n";
            };

        /*
            queue_name:
            consumer_tag: Consumer identifier
            no_local: Don't receive messages published by this consumer.
            no_ack: Tells the server if the consumer will acknowledge the messages.
            exclusive: Request exclusive consumer access, meaning only this consumer can access the queue
            nowait:
            callback: A PHP Callback
        */
        $channel->basic_qos(null, 1, null);
        $channel->basic_consume($queue_name, '', false, true, false, false, $callback);

        while (count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }
}
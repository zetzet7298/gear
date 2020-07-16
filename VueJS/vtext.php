<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <div id="myApp">
        <h2 v-text="message + ' noi chuoi'">addsa</h2>
        <h2>{{topic + " noi chuoi"}}</h2>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
    var myApp = new Vue({
        el:'#myApp',
        data:{
            message:'Hello World',
            topic:'learn vue'
        }
    })
</script>
</body>
</html>
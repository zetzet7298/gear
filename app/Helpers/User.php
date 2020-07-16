<?php


namespace App\Helpers;
use Illuminate\Support\Facades\DB;

class User
{
    public static function getUserName($user_id){
        $user = DB::table('user')->where('username','like',$user_id)->first();
        return (isset($user->HoTen)?$user->HoTen:'');
    }
}
<?php
class message{
    
    static $message;
    
    public static function add($message){
        self::$message = self::$message."<br>".$message;
    }

    public static function get(){
        return self::$message;
    }
}
?>
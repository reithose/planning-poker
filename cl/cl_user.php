<?php
class user{
    
    var $id;
    
    function newUser($userName, $master){
        $user = R::dispense('user');
        $user->userName = $userName;
        $user->created =  date("Y-m-d H:i:s"); 
        $user->active = 1;
        if($master){
            $user->master = 1;
            $_SESSION["master"] = 1;
        }
        $userId = R::store($user);
        $_SESSION["userId"] = $userId;
        $_SESSION["userName"] = $userName;
        $_SESSION["votedRound"] = 0;
        return $user;
    }
    
    function joinSession($sessionObject, $userId){
        $_SESSION["sessionId"] = $sessionObject->sessionId;
        $_SESSION["sId"] = $sessionObject->id;
        
        $user = R::load('user', $userId);
        $user->pokerSession = $sessionObject;
        R::store($user);
    }
    
    function vote($points){
        $user = R::load('user', $_SESSION["userId"]);
        $session = R::load('session', $_SESSION["sId"]);
        
        if($session->round > $_SESSION["votedRound"]){
            $vote = R::dispense('vote'); 
            $vote->points = $points;
            $vote->created =  date("Y-m-d H:i:s");
            $vote->round = $session->round;
            $vote->session = $session;
            $vote->user = $user;
            R::store($vote);
            
            $_SESSION["votedRound"] = $session->round;
        }
    }
    
    function logOut($userId){
        $user = R::load('user', $userId);
        $user->active = "";
        R::store($user);
        if($userId == $_SESSION["userId"]){//Als de gebruiker zichzelf uitlogt, ook de sessie weggooien
            session_destroy();
            $_SESSION = array();
        }
        
    }

}
?>
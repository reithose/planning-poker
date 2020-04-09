<?php
class pokerSession{
    
    var $sessionId;
    var $sessionObject;
    var $votesArray;
    
    function get($sId){
        $this->sessionObject = R::load('session', $sId);
        return $this->sessionObject;
    }
    
    function generateNewSessionId(){
        $tempId = substr(md5(microtime().rand(1, 10000000)), 0, 6);
       
       $existingSession = R::findOne('session', 'sessionId = ?', array($tempId));
        while($existingSession){
            $existingSession = R::findOne('session', 'sessionId = ?', array($tempId));
        }
        $this->sessionId = $tempId;
        return $this->sessionId;
    }
 
    function search($sessionId){
        $existingSession = R::findOne('session', 'sessionId = ?', array($sessionId));
        if($existingSession)
            return $existingSession;
        else
            return false;
    }
    
    function newSession($masterName){
        
        $session = R::dispense('session');
        $session->sessionId = $this->generateNewSessionId();
        $session->created = date("Y-m-d H:i:s");
        $session->round = 0;
        R::store($session);

        $user = new user;
        $master = $user->newUser($masterName, 1);
        $user->joinSession($session, $master->id);
        
        $_SESSION["sessionId"] =  $this->sessionId;
    }
    
    function startNextRound($sessionId){
        $session = $this->search($sessionId);
        $session->round = $session->round+1;
        R::store($session);
    }
    
    function getVotes($sId){  
        $query = "
            SELECT userName, user.id as userId, session.id, master, r1.points as r1, r2.points as r2, r3.points as r3
            FROM user
            join session on
            session.id = user.pokerSession_id
            
            left join vote r1 on
            r1.user_id = user.id
            AND r1.round = ".($this->sessionObject->round - 2)."
            
            left join vote r2 on
            r2.user_id = user.id
            AND r2.round = ".($this->sessionObject->round - 1)."
            
            left join vote r3 on
            r3.user_id = user.id
            AND r3.round = ".$this->sessionObject->round."
            
            WHERE user.active = 1 AND session.id = ".$sId;
           	$this->votesArray = R::getAll($query);
            return $this->votesArray;
    
    }
    
    function getMinMax($sId, $round){//Geeft de minimale en maximale uitslagen terug van een bepaalde sessie en ronde
        $query = "SELECT min(points) as min, max(points) as max FROM vote WHERE round = ".$round." AND session_id = ".$sId." GROUP BY session_id";
        //echo $query;
       return R::getAll($query);
    }
    
    function refreshVotes(){//Functie geeft 0 terug als de stemmen niet opnieuw ververst hoeven te worden (30s lang ververst of iedereen heeft gestemd)
    	if(!$_SESSION["firstRefresh"])
    		$_SESSION["firstRefresh"] = microtime(true);
    		
    	foreach($this->votesArray as $key => $value){
			if(isset($this->votesArray[$key]["r3"]))
				$r3Votes++;	
		}
		
		if(count($this->votesArray) == $r3Votes || (microtime(true) - $_SESSION["firstRefresh"]) > 30){
			$_SESSION["firstRefresh"] = "";
			return 0;
		}
		else{
			return 1;

		}
    }
}
?>
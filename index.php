<?php
session_start();

include("include.php");

//Uitloggen
if($_GET["a"] == "logout" && ($_GET["userId"] == $_SESSION["userId"] || $_SESSION["master"] == 1)){
    $u = new user;
    $u->logOut($_GET["userId"]);
}

//Nieuwe ronde starten (alleen master)
if($_GET["a"] == "nextRound" && $_SESSION["master"]){
    //echo"nieuwe ronde!!";
    $s = new pokerSession;
    $s->startNextRound($_SESSION["sessionId"]);  
    header("location: index.php"); 
}


//Inloggen
if($_POST["userName"]){//Gebruiker wil deelnemen
    if($_POST["sessionId"]){//..aan een bestaande sessie
        $ps = new pokerSession;
        $foundSession = $ps->search($_POST["sessionId"]);//Kijken of sessie bestaat
        if($foundSession){//Als hij bestaat, joinen
            $u = new user;
            $currUser = $u->newUser($_POST["userName"], false);
            $u->joinSession($foundSession, $currUser->id);
        }
        else
            message::add("Sessie met id ".$_POST["sessionId"]." niet gevonden");
    }
    else{//aan een nieuwe sessie
        $s = new pokerSession;
        $s->newSession($_POST["userName"]);
    }
}


echo"
<!DOCTYPE html>
<head>
    <meta charset='UTF-8'>
    <title>Planning Poker</title>
    <link href='css/main.css' rel='stylesheet' type='text/css'>

    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js'></script>
    <script type='text/javascript' src='js/script.js'></script>

    <meta name='viewport' content='width=device-width, initial-scale = 1.0, maximum-scale = 1.0'/>
    <meta name='apple-mobile-web-app-capable' content='yes' />

</head>
<body>
    <div class='header'><a href='index.php'><h1>Planning poker</h1></a></div>
    <div class='main'>";
$message = message::get();
if($message)
    echo"<div class='error'".$message."</div><br><br>";
    
    
if(!$_SESSION["userName"])
    include("login.php");
else{  
    if($_GET["p"] == "vote") 
        include("vote.php");
    elseif($_GET["p"] == "share") 
        include("share.php");
    else
        include("main.php");
}

echo"
        </div>
    </body>
</html>";







?>
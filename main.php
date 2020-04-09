<?php
session_start();

//Stemmen
if($_GET["a"] == "vote"){
	include_once("include.php");
    $u = new user;
    $u->vote($_GET["v"]);
}


$ps = new pokerSession;
$session = $ps->get($_SESSION["sId"]);

echo"
<div class='roundInfo smallText'>
    <table class='center'>
        <tr>
            <th>Naam</th>
            <th>Sessie id</th> 
            <th>Stemronde</th>
        </tr>
        <tr>
            <td class='center'>".$_SESSION["userName"]."</td>
            <td class='center'>".$_SESSION["sessionId"]."</td>
            <td class='center'>".$session->round."</td>
        </tr>
    
    </table>
</div>
<div class='roundStatus divPad bgGray'>";
if($session->round > $_SESSION["votedRound"])
    echo"nieuwe ronde gestart<br><a id='voteButton' class='knop' href='#'>stemmen</a>";
else{
    echo"nieuwe ronde nog niet gestart";    
    if($_SESSION["master"])
        echo"<br><a class='knop' href='index.php?a=nextRound'>nieuwe ronde starten</a>";

       echo"<br><a class='knop' href='index.php'>refresh</a>"; 
}

echo"
</div>
<div id='votes' class='votes divPad bgGray'>
<script>
	connect();
</script>
</div>
<div class='actions'>
    <a href='index.php?p=share'>inlog gegevens</a> - <a target='_blank' href='handleiding.html'>handleiding</a> - <a href='index.php?a=logout&userId=".$_SESSION["userId"]."'>log uit</a>
</div>";

?>
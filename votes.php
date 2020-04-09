<?php
session_start();



include("include.php");

$ps = new pokerSession;
$session = $ps->get($_SESSION["sId"]);
$votes = $ps->getVotes($_SESSION["sId"]);
$minMax = $ps->getMinMax($_SESSION["sId"], $session->round);


$content.= "
<table>
    <tr>
        <th colspan='2'>Uitslagen ronde</th>";
        if($session->round > 2)
            $content.="<th class='votesCell'>".($session->round - 2)."</th>";
        if($session->round > 1)
            $content.="<th class='votesCell'>".($session->round - 1)."</th>";
        if($session->round > 0)
            $content.="<th class='votesCell currRoundCell'>".$session->round."</th>";

$content.="</tr>";

foreach($votes as $key => $value){
$content.="
    <tr class='hiRow'>
        <td class='minMax center'>";
        if($session->round > 0 && $session->round == $_SESSION["votedRound"]){//Als er gestemd is...
            if($votes[$key]["r3"] == $minMax[0]["min"] && $votes[$key]["r3"] != $minMax[0]["max"])//En de waarde is gelijk aan de minimum waarde van de ronde
               $content.= " &darr;";
            if($votes[$key]["r3"] == $minMax[0]["max"] && $votes[$key]["r3"] != $minMax[0]["min"])//En de waarde is gelijk aan de maximale waarde van de ronde
               $content.= " &uarr;";
            
        }
        
        $content.= "</td>
        			<td>".$votes[$key]["userName"];

        if($votes[$key]["master"])//o tonen achter scrummaster
            $content.= " o";
        
        if($_SESSION["master"])//Delete knop tonen als gebruiker scrummmaster is
            $content.= " <a href='index.php?a=logout&userId=".$votes[$key]["userId"]."'>x</a>";
            
        $content.="</td>";
        if($session->round > 2)
            if(isset($votes[$key]["r1"]))
                $content.="<td class='votesCell center'>".$votes[$key]["r1"]."</td>";//Als er punten zijn, punten tonen
            else
                $content.="<td class='emptyCell center'></td>";//Anders andere style
        if($session->round > 1)
            if(isset($votes[$key]["r2"]))
                $content.="<td class='votesCell center'>".$votes[$key]["r2"]."</td>";
            else
                $content.="<td class='emptyCell center'></td>";
        if($session->round > 0)
            if($session->round == $_SESSION["votedRound"] && isset($votes[$key]["r3"]))    
                //if($votes[$key]["r3"])
                    $content.="<td class='votesCell currRoundCell center'>".$votes[$key]["r3"]."</td>";
                else
                    $content.="<td class='emptyCell center'></td>";

$content.="</tr>";
}
      
$content.="</table>";

echo json_encode(array("content" => $content, "refresh" => $ps->refreshVotes()));


?>
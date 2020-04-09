
<form action='index.php' method='post'>
<table>
    <tr>
        <td>gebruikersnaam</td>
        <td><input name='userName'></td>
    </tr>
    <tr>
        <td>planningsessie</td>
        <td><input type='radio' name='newSession' id='newSession' value='nieuw' checked>starten</td>
    </tr>  
    <tr>
        <td>&nbsp;</td>
        <td><input type='radio' name='newSession' id='existingSession' value='deelnemen'>deelnemen</td>
    </tr>   
    <tr id='sessionIdField'>
        <td>sessie id</td>
        <td><input id='sessionId' name='sessionId' value='<?php echo $_GET["sessionIdPrefill"]; ?>'></td>
    </tr>    
    <tr class='left'>
        <td>&nbsp;</td>
        <td><input class='knop' type='submit' value='login'></td>
    </tr>
</table>
</form>
<br><br>Planning poker is een webapplicatie die door teams kan worden gebruikt om de relatieve zwaarte van onderdelen binnen een project in te schatten.<br><br>
<a target='_blank' href='handleiding.html'>handleiding</a> ";




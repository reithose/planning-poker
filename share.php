<?php
$link = $domain."/index.php?sessionIdPrefill=".$_SESSION["sessionId"];
$url = urlencode($link);
echo "
Ga naar:<br>
<a href='".$link."'>".$link."</a><br><br><br>
sessie id<br><h2>".$_SESSION["sessionId"]."</h2>
<br><br>
<img src='http://qr.kaywa.com/?s=6&d=".$url."' alt='QRCode'/><br><br>
<a href='index.php'>home</a>";
?>
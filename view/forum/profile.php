<?php
$email = $result["data"]["email"];
$username = $result["data"]["username"];
$creationDate = $result["data"]["creationDate"];
?>
<h1>Your infos</h1>

<p>Username : <?=$username?></p>

<p>Email : <?=$email?></p>

<p>You joined the forum on <?=$creationDate->format("d/m/Y, H:i:s")?></p>

<p>
    <button>Change your credentials</button>
    <button>Change your password</button>
    <button>Delete your account</button>
</p>
<?php
$email = $result["data"]["email"];
$username = $result["data"]["username"];
$creationDate = $result["data"]["creationDate"];
$kickDate = $result["data"]["kickDate"];
?>
<h1>Your infos</h1>

<p>Username : <?=$username?></p>

<p>Email : <?=$email?></p>

<p>You joined the forum on <?=$creationDate?></p>
<?php if (App\SESSION::isBanned()) echo "You have been banned on ".var_dump($_SESSION["user"]); ?>
<?php if (App\SESSION::isKicked()) echo "You have been kicked until ".$kickDate; ?>
<p>
    <button>Change your password</button>
    <button>Delete your account</button>
    <a href="index.php?ctrl=security&action=deleteaccount">Delete your account</a>
    <a href="index.php?ctrl=security&action=changecredentials"> Change credentials </a>
</p>
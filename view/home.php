<?php
    $metaDescription = $result["metaDescription"];
?>

<?= isset($success) && $success == 1 ? "Register is complete" : "" ?>

<h1>BIENVENUE SUR LE FORUM</h1>

<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit ut nemo quia voluptas numquam, itaque ipsa soluta ratione eum temporibus aliquid, facere rerum in laborum debitis labore aliquam ullam cumque.</p>

<?= isset($success) && $success == 1 ? "Register is complete" : "" ?>

<p>
    <a href="index.php?ctrl=security&action=displayLoginForm">Se connecter</a>
    <span>&nbsp;-&nbsp;</span>
    <a href="index.php?ctrl=security&action=displayRegisterForm">S'inscrire</a>
</p>

<?php if (isset($_SESSION["sucess"])) unset($_SESSION["sucess"]) ?>

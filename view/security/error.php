<p>An error has occured</p>
<?php
foreach ($_SESSION["errors"] as $error) 
{
    ?>
    
    <ul>
        <li><?= $error ?></li>
    </ul>
<?php
}
//cleaning session errors 
unset($_SESSION["errors"]);
?>
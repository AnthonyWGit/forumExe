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
if (isset($_SESSION["errors"])) unset($_SESSION["errors"]);
?>
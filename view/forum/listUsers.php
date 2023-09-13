<?php

$users = $result["data"]['users'];
    
?>

<h1>Users list</h1>

<?php
foreach($users as $user )
{

    ?>
    <p>
        <?=$user->getUsername()?>
        <?=$user->getRegisterDate()?>
    </p>
    <?php
}


  

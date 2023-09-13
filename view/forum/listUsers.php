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
        </br>
        <a href = "index.php?ctrl=admin&action=postsCreated&id=<?=$user->getId()?> ">See posts</a> &nbsp;
        <a href = "index.php?ctrl=admin&action=topicsCreated&id=<?=$user->getId()?> ">See topics</a>&nbsp;Mute&nbsp;Ban

    </p>
    <?php
}
?>

  

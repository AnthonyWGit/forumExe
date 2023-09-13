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
        <a href = "index.php?ctrl=admin&action=topicsCreated&id=<?=$user->getId()?> ">See topics</a>&nbsp;Mute&nbsp;
        <?= ($user->getState() == 'free') ? '<a href ="index.php?ctrl=admin&action=ban&id='.$user->getId().'">Ban</a>': '' ?>
        <?= ($user->getState() == 'banned') ? '<a href ="index.php?ctrl=admin&action=unban&id='.$user->getId().'">Unban</a>': '' ?>
        <?= ($user->getRole() == 'mod' && $user->getRole() != 'admin') ? '<a href ="index.php?ctrl=admin&action=demote&id='.$user->getId().'">Demote to member</a>': '' ?>
        <?= ($user->getRole() != 'mod' && $user->getRole() != 'admin') ? '<a href ="index.php?ctrl=admin&action=promote&id='.$user->getId().'">Promote to moderator</a>': '' ?>
    </p>
    <?php
}
?>


<script>
    function Myfunction()
    {
        
    }
</script>

  

<?php

$topics = $result["data"]['topics'];

?>

<h1>liste topics</h1>

<?php
if ($topics == null)
{
    ?>

        <p>This category does not contain any topics for now.</p>
        <p>Create the first one ! </p>

    <?php
}
else
{
    foreach($topics as $topic )
    {

        ?>
        <p>
            <a href="index.php?ctrl=post&action=listPosts&id=<?=$topic->getId()?>"><?=$topic->getTitle()?></a> <?=$topic->getUser()->getUsername()?>
            <?= (isset($_SESSION["user"]) && (App\SESSION::isAdmin() || App\session::isMod())) ? '<a href="index.php?ctrl=topic&action=deleteTopic&id='.$topic->getId().'"> X  </a>' : ''?>
            <?= (isset($_SESSION["user"]) && (App\SESSION::isAdmin() || App\SESSION::isMod()) && $topic->getLock() == 0) ? '<a href="index.php?ctrl=topic&action=lockTopic&id='.$topic->getId().'">Lock</a>' : ''?> 
            <?= (isset($_SESSION["user"]) && (App\SESSION::isAdmin() || App\SESSION::isMod())  && $topic->getLock() == 1) ? '<a href="index.php?ctrl=topic&action=unlockTopic&id='.$topic->getId().'">Unlock</a>' : ''?>
        </p> 
        <?php
    }    
}
?>
<h2 id="new_topic"> New topic Creation </h2>

<div class="topicForm">
<form id="topic_form" method="post" action="index.php?ctrl=topic&action=newTopic&id=<?=$_GET["id"]?>">

    <label for="topicTitle">Topic tile </label>
    <input type="text" id="topic_title" name="title"/>    

    <label for="firstPost">First Post</label> 
    <textarea id="topic_firstPost" name="content"></textarea>

    <input type="submit" id="topic_validate" value="New Topic"/>
</form>
</div>

  

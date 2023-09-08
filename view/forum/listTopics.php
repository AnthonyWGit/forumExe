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
        <p><a href="index.php?ctrl=post&action=postsList&id=<?=$topic->getId()?>"><?=$topic->getTitle()?></a></p>
        <?php
    }    
}
?>

<h2 id="new_topic"> New topic Creation </h2>

<div class="topicForm">
<form id="topic_form" method="post" action="index.php?ctrl=topic&action=newTopic">

    <label for="topicTitle">Topic tile </label>
    <input type="text" id="topic_title"/>    

    <label for="firstPost">First Post</label> 
    <textarea id="topic_firstPost"></textarea>

    <input type="submit" id="topic_validate" value="New Topic"/>
</form>
</div>

  

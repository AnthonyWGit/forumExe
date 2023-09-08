<?php

$posts = $result["data"]["posts"]; //$posts contains generator objects. Preperties of those can only be accessed by doing iterations over them
$topic = $posts->current()->getTopic(); //current() allows us to access properties of the current objet. 
//We use it before foreaching so we will always access properties of the first object
//In this forum a topic will always have a post otherwise it doesn't exist so no problem
?>
<?php
echo $topic->getTitle();
foreach($posts as $post)
{
?>
    <p>

        <?= $post->getTopic()->getTitle() ?>
        <?= $post->getUser()->getUsername()?>
    </p>
    <p>
        <?= $post->getContent() ?>
    </p>
    <?php
}
?>

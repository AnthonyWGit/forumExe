<?php

$posts = $result["data"]["posts"]; //$posts contains generator objects. Preperties of those can only be accessed by doing iterations over them
// var_dump($posts);
?>
<?php
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

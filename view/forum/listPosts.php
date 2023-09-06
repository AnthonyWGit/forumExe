<?php

$posts = $result["data"]["posts"];
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

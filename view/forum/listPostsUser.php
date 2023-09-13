<?php

$user = $result["data"]['user'];
$posts = $result["data"]['posts']
?>

<h1>Topics made by <?= $user->getUsername() ?></h1>

<?php
foreach($posts as $post)
{

    ?>
    <p>
        <a href="index.php?ctrl=post&action=listPosts&id=<?=$post->getId()?>"><?= $post->getContent() ?></a>
        <strong> IN </strong>
        <a href="index.php?ctrl=post&action=listPosts&id=<?= $post->getTopic()->getId()?>"><?= $post->getTopic()->getTitle() ?></a>
    </p>
    <?php
}


  

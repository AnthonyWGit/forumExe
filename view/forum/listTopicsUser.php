<?php

$user = $result["data"]['user'];
$topics = $result["data"]['topics']
?>

<h1>Topics made by <?= $user->getUsername() ?></h1>

<?php
foreach($topics as $topic)
{

    ?>
    <p>
        <a href="index.php?ctrl=post&action=listPosts&id=<?=$topic->getId()?>"><?= $topic->getTitle() ?></a>
    </p>
    <?php
}


  

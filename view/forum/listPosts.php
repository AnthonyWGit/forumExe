<?php

$posts = $result["data"]["posts"];

?>

<h1>What's in the box ? </h1>

<?php
foreach($posts as $post){

    ?>
    <p>
        <?= $post->getUser()->getUsername()?>
    </p>
    <p>
        <?= $post->getContent() ?>
    </p>
    <?php
}

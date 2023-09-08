<?php

$categories = $result["data"]["categories"];

?>

<h1>All the categories avaliable to you are</h1>

<?php
foreach($categories as $category )
{

    ?>
    <p><a href="index.php?ctrl=topic&action=listTopics&id=<?=$category->getId()?>"><?=$category->getName()?></a></p>
    <?php
}

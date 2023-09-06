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
    foreach($topics as $topic ){

        ?>
        <p><a href="index.php?ctrl=post&action=postsList&id=<?=$topic->getId()?>"><?=$topic->getTitle()?></a></p>
        <?php
    }    
}



  

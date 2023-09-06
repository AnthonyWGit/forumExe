<?php

$topics = $result["data"]['topics'];
    
?>

<h1>Users list</h1>

<?php
foreach($topics as $topic ){

    ?>
    <p><?=$topic->getTitle()?></p>
    <?php
}


  

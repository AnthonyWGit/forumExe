<?php

$categories = $result["data"]["categories"];

?>

<h1>All the categories avaliable to you are</h1>

<?php
foreach($categories as $category ){

    ?>
    <p><?=$category->getName()?></p>
    <?php
}

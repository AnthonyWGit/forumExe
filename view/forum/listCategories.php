<?php

$categories = $result["data"]["categories"];

?>

<h1>list categories</h1>

<?php
foreach($categories as $category ){

    ?>
    <p><?=$category->getName()?></p>
    <?php
}

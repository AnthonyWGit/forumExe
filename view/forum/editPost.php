<?php

$posts = $result["data"]["posts"]; //$posts contains generator objects. Preperties of those can only be accessed by doing iterations over them
$topic = $posts->current()->getTopic(); //current() allows us to access properties of the current objet. 
$content = $result["data"]["content"];
//We use it before foreaching so we will always access properties of the first object
//In this forum a topic will always have a post otherwise it doesn't exist so no problem
$lockState = $posts->current()->getTopic()->getLock();
?>
<?= $lockState == 1 ? " <p> This topic has been locked </p>" : ""?>


<?php
echo $topic->getTitle();
foreach($posts as $post)
{
?>
    <p>
        <?= $post->getUser()->getUsername()?> &nbsp <?= $post->getCreationdate() ?>
        <?= (isset($_SESSION["user"]) && $_SESSION["user"]->getRole() == "admin") ? '<a href="index.php?ctrl=post&action=deletePost&id='.$post->getId().'"> X  </a>' : ''?>
        <?= (isset($_SESSION["user"]) && $_SESSION["user"] == $post->getUser()->getUsername()) ?  '<a href="index.php?ctrl=post&action=edit&id='.$post->getId().' "> Edit </a>' : '' ?>
    </p>
    <p>
        <?= $post->getContent() ?>
    </p>
    <?php
}
?>

<?php
if ($lockState == 0 || ($_SESSION["user"]->getRole() == "admin")) //admin has no restrictions and can bypass everything
{
?>
<h2 id="new_post"> Post Edition</h2>

<div class="postForm">
<form id="post_form" method="post" action="index.php?ctrl=post&action=editConfirm&id=<?= $_GET["id"] ?>">

    <label for="makePost">Post Content</label> 
    <textarea id="makePost" name="postContent"><?=$content?></textarea>

    <input type="submit" id="post_validate" value="validate"/>
</form>
</div>

<?php
}
?>


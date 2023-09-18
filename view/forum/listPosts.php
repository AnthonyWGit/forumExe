<?php

$posts = $result["data"]["posts"]; //$posts contains generator objects. Preperties of those can only be accessed by doing iterations over them
$topic = $posts->current()->getTopic(); //current() allows us to access properties of the current objet. 
//We use it before foreaching so we will always access properties of the first object
//In this forum a topic will always have a post otherwise it doesn't exist so no problem
$lockState = $posts->current()->getTopic()->getLock();
if (isset($result["data"]["edit"])) $edit = ($result["data"]["edit"]); //Check edit variables to use edit variables if we are in that case 
if (isset($result["data"]["content"])) $content = $result["data"]["content"];
?>

<?= $lockState == 1 ? " <p> This topic has been locked </p>" : ""?>

<?= $topic->getTitle()?>
<div class="giantBox">
    <?php    
    foreach($posts as $post)
    {
    ?>
    <div class="postBox">
        <p>
            <img src="<?=PUBLIC_DIR?><?=$post->getUser()->getProfileImg()?>" alt="profile pic"><?= $post->getUser()->getUsername()?> &nbsp; <?= $post->getCreationdate() ?>
            <?= (isset($_SESSION["user"]) && (App\SESSION::isAdmin() || App\SESSION::isMod()) ) ? '<a href="index.php?ctrl=post&action=deletePost&id='.$post->getId().'"> X  </a>' : ''?>
            <?= (isset($_SESSION["user"]) && $_SESSION["user"]->getUsername() == $post->getUser()->getUsername()) ?  '<a href="index.php?ctrl=post&action=edit&id='.$post->getId().' "> Edit </a>' : '' ?>
        </p>
        <p>
            <?= nl2br($post->getContent()) ?>
        </p>
    </div>
        <?php
    }
    ?>
</div>
<?php
if (($lockState == 0 || (App\SESSION::isAdmin())) && (!isset($edit))) //admin has no restrictions and can bypass everything Edit mode is off
{
?>

<h2 id="new_post"> New Post Creation </h2>

<div class="postForm">
<form id="post_form" method="post" action="index.php?ctrl=post&action=newPost&id=<?=$_GET["id"]?>">

    <label for="makePost">Post Content</label> 
    <textarea id="makePost" name="makePost"></textarea>
    <label for="post_validate"></label>
    <input type="submit" id="post_validate" value="New Post"/>
</form>
</div>

<?php
}
?>

<?php
if ((isset($edit) && $edit == 1)) //admin has no restrictions and can bypass everything Edit mode is onn 
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



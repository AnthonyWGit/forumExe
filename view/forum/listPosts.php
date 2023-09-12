<?php

$posts = $result["data"]["posts"]; //$posts contains generator objects. Preperties of those can only be accessed by doing iterations over them
$topic = $posts->current()->getTopic(); //current() allows us to access properties of the current objet. 
//We use it before foreaching so we will always access properties of the first object
//In this forum a topic will always have a post otherwise it doesn't exist so no problem

?>
<?php
echo $topic->getTitle();
foreach($posts as $post)
{
?>
    <p>
        <?= $post->getUser()->getUsername()?>
        <?= (isset($_SESSION["user"]) && $_SESSION["user"] == "admin") ? '<a href="index.php?ctrl=post&action=deletePost&id='.$post->getId().'"> X  </a>' : ''?>
        <?= (isset($_SESSION["user"]) && $_SESSION["user"] == $post->getUser()->getUsername()) ?  '<a href="index.php?ctrl=post&action=edit&id='.$post->getId().' "> Edit </a>' : '' ?>
    </p>
    <p>
        <?= $post->getContent() ?>
    </p>
    <?php
}
?>
<h2 id="new_post"> New Post Creation </h2>

<div class="postForm">
<form id="post_form" method="post" action="index.php?ctrl=post&action=newPost&id=<?=$_GET["id"]?>">

    <label for="makePost">Post Content</label> 
    <textarea id="makePost" name="makePost"></textarea>

    <input type="submit" id="post_validate" value="New Post"/>
</form>
</div>

  


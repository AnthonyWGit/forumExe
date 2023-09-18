<h2>Upload profile pic form</h2>

<form method="post" enctype="multipart/form-data" action="index.php?ctrl=security&action=validateProfilePic" id="profilepic_form" class="profilepicForm">
    <label for="avatar">Choose a profile picture:</label>

    <input type="file" id="avatar" name="avatar" accept="image/png, image/jpeg" />
    <label for="submitButton"></label>
    <input type="submit" id="submitButton">
</form>
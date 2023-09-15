<h2>Change credentials form</h2>

<form method="post" action="index.php?ctrl=security&action=validateCredentials" id="register_form" class="registerForm">
    <label for="username">Username</label>
    <input type="text" id="register_username" name="username"/>
    <label for="email">Email</label>
    <input type="email" id="register_email" name="email"/>
    <label for="password">Old Password</label>
    <input type="text" id="old_register_password" name="oldPassword"/> 
    <label for="passwordConfirm">New Password</label>
    <input type="text" id="register_username_validate" name="validatePassword"/>
    <label for="passwordConfirm">New Password Confirm</label>
    <input type="text" id="register_username_validate" name="validatePassword2"/>
    <input type="submit" id="register_submit" value="Register"/>
</form>
<h2>Register form</h2>

<form method="post" action="index.php?ctrl=security&action=validateForm" id="register_form" class="registerForm">
    <label for="username">Username</label>
    <input type="text" id="register_username" name="username"/>
    <label for="email">Email</label>
    <input type="email" id="register_email" name="email"/>
    <label for="password">Password</label>
    <input type="text" id="register_password" name="password"/> 
    <label for="passwordConfirm">Password confirm</label>
    <input type="text" id="register_username_validate" name="validatePassword"/>
    <input type="submit" id="register_submit" value="Register"/>
</form>
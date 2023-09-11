<h2>login form</h2>

<form method="post" action="index.php?ctrl=security&action=validateLogin" id="login_form" class="loginForm">
    <label for="username">Username</label>
    <input type="text" id="login_username" name="username"/>
    <label for="password">Password</label>
    <input type="text" id="login_password" name="password"/> 
    <input type="submit" id="login_submit" value="Login"/>
    <p>Lost password ?</p>
    <p>Lost username ?</p>
</form>

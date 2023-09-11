<?php


namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;



class HomeController extends AbstractController implements ControllerInterface
{

    public function index()
    {

    }

    public function displayRegisterForm()
    {
       return
       [
        "view" => VIEW_DIR."security/register.php"
       ];
    }

    public function displayLoginForm()
    {
       return
       [
        "view" => VIEW_DIR."security/login.php"
       ];
    }

    public function displayErrorPage()
    {
        return
        [
         "view" => VIEW_DIR."security/error.php"
        ];
    }

    public function validateForm()
    {
        $userCtrl = new UserManager();
        $errors = [];
        $arrayPwdCheck = [];
        $pwdMatching = 0;
        foreach($_POST as $fieldName=>$item)
        {   
            switch ($fieldName)
            {
                //Throws an error when there is one empty field no matter what it is
                case NULL:
                $errors = ["One field or more have not been filled"];
                $this->redirectTo("security","displayErrorPage");
                break;
                
                case "username":
                    if($item == null)
                    {
                        $errors = ["One field or more have not been filled"];
                        $this->redirectTo("security","displayErrorPage");
                    }
                    else
                    {   //sanitize
                        $itemFiltered = filter_var($item,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        // Need a regex rule for line below to not allow have username with special chars
                        ($itemFiltered == $item) ? $usernameCheck = 1 : $usernameCheck = 0;
                        $_POST["username"] = $itemFiltered;
                        break;
                    }

                case "email":
                if($item == null)
                {
                    $errors = ["One field or more have not been filled"];
                    $this->redirectTo("security","displayErrorPage");
                }
                else
                {
                    $itemFiltered = filter_var($item,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    filter_var($itemFiltered,FILTER_VALIDATE_EMAIL) == true ? $checkEmail = 1 : $checkEmail = 0;
                    $_POST["email"] = $itemFiltered;
                    break;                    
                }


                case "password":
                    if($item == null)
                    {
                        $errors = ["One field or more have not been filled"];
                        $this->redirectTo("security","displayErrorPage");
                    }
                    else
                    {
                        $itemFiltered = filter_var($item,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        if (strlen($itemFiltered) < 8 || strlen($itemFiltered) > 60) 
                        {
                            $errors[] = "Password should be min 8 characters and max 60 characters";
                        }
                        if (!preg_match("/\d/", $itemFiltered)) 
                        {
                            $errors[] = "Password should contain at least one digit";
                        }
                        if (!preg_match("/[\p{Lu}]/u", $itemFiltered)) 
                        {
                            $errors[] = "Password should contain at least one Capital Letter : can be any unicode";
                        }
                        if (!preg_match("/[\p{Ll}]/", $itemFiltered)) 
                        {
                            $errors[] = "Password should contain at least one small Letter : can be any unicode";
                        }
                        if (!preg_match("/\W/", $itemFiltered)) 
                        {
                            $errors[] = "Password should contain at least one special character";
                        }
                        if (preg_match("/\s/", $itemFiltered)) 
                        {
                            $errors[] = "Password should not contain any white space";
                        }
                        array_push($arrayPwdCheck, $itemFiltered);
                        $_POST["password"] = $itemFiltered;
                    break;                        
                    }


                case "validatePassword":
                if($item == null)
                {
                    $errors = ["One field or more have not been filled"];
                    $this->redirectTo("security","displayErrorPage");
                }
                else
                {
                    $itemFiltered = filter_var($item,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    array_push($arrayPwdCheck, $itemFiltered);
                    break;                    
                }
            }
        }

        //printing specific error when pwd don't match
        if ($arrayPwdCheck[0] != $arrayPwdCheck[1])
        {
            $errors[] = "Passwords don't match";
        }
        else
        {
            $pwdMatching == 1;
        }
        
        //finally processed to check if username and email already exists in DB
        {
            $userFind = ($userCtrl->usernameFind($_POST["username"]));
            $emailFind = ($userCtrl->emailFind($_POST["email"]));

            if (is_object($userFind)) // If we get an object back it means there is something existing in db 
            {
                $usernameSame = 1;

                unset($_SESSION["errors"]);
                $errors = empty($errors);
                $errors = [];
                $errors[] = "This username has already been taken"; 
                $_SESSION["errors"] = $errors;
            }
            else
            {
                $usernameSame = 0;
            }
            // Display both email + username taken or just one of them
            if (is_object($emailFind))
            {
                $emailSame = 1;

                if ($usernameSame == 1)
                {
                    $errors[] = "This email has already been taken"; 
                    $_SESSION["errors"] = $errors;
                }
                else
                {
                    unset($_SESSION["errors"]);
                    $errors = empty($errors);
                    $errors = [];
                    $errors[] = "This email has already been taken"; 
                    $_SESSION["errors"] = $errors;
                }
            }
            else
            {
                $emailSame = 0;
            }

            // To processed, check if every check has been passed. If no errors we have a valid pwd so we can just check if password
            //is the same as pwd confirm
            if (($usernameCheck == 1) && ($checkEmail == 1) && ($usernameSame == 0) && ($emailSame == 0) && empty($errors))
            {
                $success = 1;
                $_SESSION["success"] = "Register complete";

                //hashing password

                $hashedPwd = password_hash($_POST["password"], PASSWORD_DEFAULT);
                $_POST["password"] = $hashedPwd;

                $userCtrl->addUser($_POST);
                $this->redirectTo("home","index");
            }
            else
            {
                $this->redirectTo("security","displayErrorPage");
            }            
        }
    }
    public function validateLogin()
    {
        if (isset($_SESSION["errors"])) unset($_SESSION["errors"]);
        $errors = [];
        $userCtrl = new UserManager(); //will need to fetch data 
        foreach($_POST as $fieldName=>$item)
        {
            $sanitizedValue = filter_var($item, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            switch ($fieldName)
            {
                case "username":
                    $usernameObject = $userCtrl->usernameFind($_POST["username"]); //We use the username of the post to find if we get a row in db
                    if (is_object($usernameObject))
                    {
                        $usernameString = $userCtrl->usernameFind($_POST["username"])->getUsername();
                        $usernameCheck = 1;
                    }
                    else
                    {
                        $errors[] = "This username doesn't exists.";
                        $_SESSION["errors"] = $errors;
                        $this->redirectTo("security", "displayErrorPage");
                    }
                    break;
                
                case "password":
                    if ($usernameCheck == 1 && $sanitizedValue != null)
                    {
                        $password = $usernameObject->getPassword();
                        $verify = password_verify($sanitizedValue, $password);
                        if(!$verify)
                        {
                            SESSION::addFlash("error", "Error detected");
                            $errors[] = "This is not the good password.";
                            $_SESSION["errors"] = $errors;
                            $this->redirectTo("security", "displayErrorPage");
                        }   
                    }
                    else if ($sanitizedValue == null)
                    {
                        SESSION::addFlash("error", "Error detected");
                        $errors[] = "There is an empty field.";
                        $_SESSION["errors"] = $errors;
                        $this->redirectTo("security", "displayErrorPage");
                    }
                    break;
            }
        }

        //We check our values to proceed to login

        if ($verify && $usernameCheck == 1)
        {
            $sessionCtrl = new Session();
            $sessionCtrl->setUser($usernameObject);
            SESSION::addFlash("success", "Loggin has been completed successfully");
            $this->redirectTo("home","index");
        }
        else
        {
            $this->redirectTo("security","displayErrorPage");
        }
    }


    public function logout()
    {
        unset($_SESSION["user"]);
        $this->redirectTo("home", "index");
    }
}


// <label for="username">Username</label>
// <input type="text" id="register_username" name="username"/>
// <label for="email">Email</label>
// <input type="email" id="register_email" name="email"/>
// <label for="password">Password</label>
// <input type="text" id="register_username" name="password"/> 
// <label for="passwordConfirm">Password confirm</label>
// <input type="text" id="register_username_validate" name="validatePassword"/>
// <input type="submit" id="register_submit" value="Register"/>
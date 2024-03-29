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
                // case NULL:
                // $errors = ["One field or more have not been filled"];
                // $this->redirectTo("security","displayErrorPage");
                // break; USELESS B/C $field can't be nulll
                
                case "username":
                    if($item == null)
                    {
                        $errors = ["One field or more have not been filled"];
                        $this->redirectTo("security","displayErrorPage");
                    }
                    else
                    {   //sanitize
                        $itemFiltered = filter_var($item,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $tring = "/[ \xA0]+/";
                        if (preg_match($tring, $sanitizedValue))
                        {
                            SESSION::addFlash("error", "spaces detected in username");
                            $this->redirectTo("home","index");
                        } 
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

    public function changeCredentials()
    {
        return
        [
         "view" => VIEW_DIR."security/redoCredentials.php"
        ];
    }
    public function validateCredentials()
    {
        $userCtrl = new UserManager();
        $errors = [];
        $arrayPwdCheck = [];
        $pwdMatching = 0;
        $oldPwd = 0;
        foreach ($_POST as $fieldName => $value)
        {
            $sanitizedValue = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            switch ($fieldName)
            {
                case "username":
                    if($value == null)
                    {
                        $errors[] = "One field or more have not been filled";
                        $_SESSION["errors"] = $errors;
                        $this->redirectTo("security","displayErrorPage");
                    }
                    else
                    {   //sanitize
                        // Need a regex rule for line below to not allow have username with special chars
                        $usernameCheck = 1;
                        $_POST["username"] = $sanitizedValue;
                        break;
                    }                
                case "email":
                    if($value == null)
                    {
                        $errors[] = "One field or more have not been filled";
                        $_SESSION["errors"] = $errors;
                        $this->redirectTo("security","displayErrorPage");
                    }
                    else
                    {
                        filter_var($sanitizedValue,FILTER_VALIDATE_EMAIL) == true ? $checkEmail = 1 : $checkEmail = 0;
                        $_POST["email"] = $sanitizedValue;
                        break;                    
                    }

                case "oldPassword":
                    if($value == null)
                    {
                        $errors[] = "One field or more have not been filled";
                        $_SESSION["errors"] = $errors;
                        $this->redirectTo("security","displayErrorPage");
                    }
                    else
                    {
                        $oldPwd = $_SESSION["user"]->getPassword();
                        if (password_verify($sanitizedValue, $oldPwd)) $checkOldPwd = 1;
                        break;                        
                    }
                case "validatePassword":
                    if($value == null)
                    {
                        $errors = ["One field or more have not been filled"];
                        $this->redirectTo("security","displayErrorPage");
                    }
                    else
                    {
                        if (strlen($sanitizedValue) < 8 || strlen($sanitizedValue) > 60) 
                        {
                            $errors[] = "Password should be min 8 characters and max 60 characters";
                        }
                        if (!preg_match("/\d/", $sanitizedValue)) 
                        {
                            $errors[] = "Password should contain at least one digit";
                        }
                        if (!preg_match("/[\p{Lu}]/u", $sanitizedValue)) 
                        {
                            $errors[] = "Password should contain at least one Capital Letter : can be any unicode";
                        }
                        if (!preg_match("/[\p{Ll}]/", $sanitizedValue)) 
                        {
                            $errors[] = "Password should contain at least one small Letter : can be any unicode";
                        }
                        if (!preg_match("/\W/", $sanitizedValue)) 
                        {
                            $errors[] = "Password should contain at least one special character";
                        }
                        if (preg_match("/\s/", $sanitizedValue)) 
                        {
                            $errors[] = "Password should not contain any white space";
                        }
                        array_push($arrayPwdCheck, $sanitizedValue);
                        $_POST["password"] = $sanitizedValue;
                        break;
                    }

                case "validatePassword2":
                    if($value == null)
                    {
                        $errors = ["One field or more have not been filled"];
                        $this->redirectTo("security","displayErrorPage");
                    }
                    else
                    {
                        array_push($arrayPwdCheck, $sanitizedValue);
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
                var_dump($usernameCheck);
                var_dump($checkEmail);
                var_dump($usernameSame);
                var_dump($emailSame);
                var_dump($errors);
                var_dump($oldPwd);
                // To processed, check if every check has been passed. If no errors we have a valid pwd so we can just check if password
                //is the same as pwd confirm
                if (($usernameCheck == 1) && ($checkEmail == 1) && ($usernameSame == 0) && ($emailSame == 0) && empty($errors) && ($checkOldPwd  == 1))
                {
                    $success = 1;
                    $_SESSION["success"] = "Register complete";
    
                    //hashing password
    
                    $hashedPwd = password_hash($_POST["password"], PASSWORD_DEFAULT);
                    $_POST["password"] = $hashedPwd;
    
                    $userCtrl->modifyUser($_POST);
                    $this->redirectTo("home","index");
                }
                else
                {
                    $this->redirectTo("security","displayErrorPage");
                }            
            }

    public function deleteAccount()
    {
        return
        [
            "view" => VIEW_DIR."security/confirm.php"
        ];
    }

    public function confirmDelete()
    {
        if (!SESSION::getUSer()) $this->redirectTo("home,index");
        if (array_map('trim', $_POST) == null) //trim all contents in post array
        {
            SESSION::addFlash("error","you cannot post an empty field");
            $this->redirectTo("profile","viewProfile", $_SESSION["user"]->getId());
        }
        else
        {
            $userManager = new userManager();
            $userId = $_SESSION["user"]->getId();
            $userManager->deleteAccount($usedId);
            unset($_SESSION["user"]);
            $this->redirectTo("index","home");
        }
    }

    public function validateProfilePic()
    {
        $uploaddir = PUBLIC_DIR.'/uploads/';
        $uploadfile = $uploaddir . basename($_FILES['avatar']['name']);
        $uploadOK = 1;
        $imageFileType = strtolower(pathinfo($uploadfile,PATHINFO_EXTENSION));
        if(isset($_POST["submit"])) 
        {
            $check = getimagesize($_FILES["avatar"]["tmp_name"]);
            if($check !== false) 
            {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOK = 1;
            } 
            else {
                echo "File is not an image.";
                $uploadOK = 0;
            }
        }
        // Check if file already exists
        if (file_exists($uploadfile)) 
        {
            echo "Sorry, file already exists.";
            $uploadOK = 0;
        }
        if ($_FILES["avatar"]["size"] > 500000) //size restriction
        {
            SESSION::addFlash("error","There was an error with the file upload");
            $this->redirectTo("profile","viewProfile", $_SESSION["user"]->getId());
            echo "Sorry, your file is too large.";
            $uploadOK = 0;
        }
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) //picture extensions
        {
            SESSION::addFlash("error","There was an error with the file upload");
            $this->redirectTo("profile","viewProfile", $_SESSION["user"]->getId());
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOK = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOK == 0) 
        {
            SESSION::addFlash("error","There was an error with the file upload");
            $this->redirectTo("profile","viewProfile", $_SESSION["user"]->getId());
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } 
        else 
        {
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $uploadfile)) 
            {
                $userManager = new UserManager();
                echo "The file ". htmlspecialchars( basename( $_FILES["avatar"]["name"])). " has been uploaded.";
                $file = explode("/", $uploadfile); //constructing the path to specify in db 
                $uploadExplode = $file[1]."/";
                $file = "/".$uploadExplode.$file[2];
                $userManager->updateAvatar($file);
                SESSION::addFlash("success","file successfully uploaded");
                $this->redirectTo("profile","viewProfile", $_SESSION["user"]->getId());
            } 
            else 
            {
                SESSION::addFlash("error","There was an error with the file upload");
                $this->redirectTo("profile","viewProfile", $_SESSION["user"]->getId());
                echo "Sorry, there was an error uploading your file.";
            }
        
        }
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
<?php


namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\SecurityManager;

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

    public function displayErrorPage()
    {
        return
        [
         "view" => VIEW_DIR."security/error.php"
        ];
    }

    public function validateForm()
    {
        
        foreach($_POST as $item)
        {
            switch ($item)
            {
                //Throws an error when there is one empty field no matter what it is
                case NULL:
                $this->redirectTo("security","displayErrorPage");
                break;
                
                case "username":
                $itemFiltered = filter_var($item,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                ($itemFiltered == $item) ? $usernameCheck = 1 : $suernameCheck = 0;
                break;

                case "email":
                filter_var($item,FILTER_VALIDATE_EMAIL) == true ? $checkEmail = 1 : $checkEmail = 0;
                break;

                default:
                $noEmptyFields = 1;
                break;
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
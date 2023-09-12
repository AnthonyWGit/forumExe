<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\UserManager;
    
    class HomeController extends AbstractController implements ControllerInterface{

        public function index()
        {
        }
        
        public function viewProfile()
        {
            $userManager = new UserManager();
            $username = $userManager->usernameFind($_SESSION["user"])->getUsername();
            $email = $userManager->usernameFind($_SESSION["user"])->getEmail();
            $arrayCreationdate = $userManager->usernameFind($_SESSION["user"]);
            // $creationDate = $userManager->usernameFind($_SESSION["user"])->getRegisterDate();

            foreach($arrayCreationdate as $creationDate)
            {
                $creationDate->format("d/m/Y, H:i:s");
            }

            return [
                "view" => VIEW_DIR."forum/profile.php",
                "data" => [
                    "username" => $username,
                    "email" => $email,
                    "creationDate" => $creationDate
                ]
            ];
        }
    }

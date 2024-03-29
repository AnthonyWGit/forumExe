<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    use Model\Managers\CategoryManager;
    use Model\Managers\UserManager;
    
    class UserController extends AbstractController implements ControllerInterface
    {

        public function index()
        {
        }
        
        public function usersList()
        {
            if (SESSION::isBanned() || SESSION::isKicked()) $this->redirectTo("home","index");
            $this->restrictTo("admin");
            $userManager = new UserManager();
 
            return [
                "metaDescription" => "Users list",
                "view" => VIEW_DIR."forum/listUsers.php",
                "data" => [
                    "users" => $userManager->findAllExept(["username", "ASC"])
                ]
            ];
        }
    }
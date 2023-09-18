<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    use Model\Managers\CategoryManager;
    use Model\Managers\UserManager;
    
    class AdminController extends AbstractController implements ControllerInterface
    {

        public function index()
        {
        }
        
        public function topicsCreated($userId)
        {
            $topicManager = new TopicManager(); 
            $userManager = new UserManager();

            $topics = $topicManager->findTopicsByUserMultiple($userId);
            $user = $userManager->userFind($userId);
            if ($topics != null)
            {
                return [
                    "metaDescription" => "topics created",
                    "view" => VIEW_DIR."forum/listTopicsUser.php",
                    "data" => [
                        "user" => $user,
                        "topics" => $topics
                    ]
                ];                
            }
            else if ($topics)
            {
                {
                    return [
                        "view" => VIEW_DIR."forum/listTopicsUser.php",
                        "data" => [
                            "user" => $user,
                            "topics" => $topics
                        ]
                    ];                
                }
            }
            else
            {
                $this->redirectTo("home","index");
            }
        }

        public function postsCreated($userId)
        {
            $postManager = new PostManager(); 
            $userManager = new UserManager();

            $posts = $postManager->findAllPostsFromUser($userId);
            $user = $userManager->userFind($userId);
            if ($posts != null)
            {
                return [
                    "view" => VIEW_DIR."forum/listPostsUser.php",
                    "data" => [
                        "user" => $user,
                        "posts" => $posts
                    ]
                ];                
            }
            else if ($posts)
            {
                {
                    return [
                        "view" => VIEW_DIR."forum/listPostsUser.php",
                        "data" => [
                            "user" => $user,
                            "posts" => $posts
                        ]
                    ];                
                }
            }
            else
            {
                $this->redirectTo("home","index");
            }
        }

        public function ban()
        {
            if (!SESSION::isAdmin()) $this->redirectTo("home","index");
            $userId = $_GET["id"];
            $userManager = new UserManager();
            if ($userId == $_SESSION["user"]->getId() && SESSION::isAdmin())
            {
                SESSION::addFlash("error","Why are you trying to ban yourself ?");
                $this->redirectTo("user","usersList");
            }
            else
            {
                $userO = $userManager->userFind($userId);
                $userManager->banUser($userId);
                SESSION::addFlash("success","User has been banhammer'ed");
                $this->redirectTo("user","usersList");
            }
        }

        public function timeout()
        {
            if (SESSION::isAdmin()) $admin = true;
            if (SESSION::isMod()) $mod = true;
            if ((!SESSION::isAdmin() && SESSION::isMod()) || !isset($mod) && !isset($admin)) $this->redirectTo("index","forum");
            $userId = $_GET["id"];
            $userManager = new UserManager();
            $sqlConverted = date("Y-m-d H:i:s", strtotime($_POST["duration"]));
            if ($userId == $_SESSION["user"]->getId() && SESSION::isAdmin())
            {
                SESSION::addFlash("error","Why are you trying to ban yourself ?");
                $this->redirectTo("user","usersList");
            }
            else
            {
                $userO = $userManager->userFind($userId);
                $userManager->kickUser($userId, $sqlConverted);
                SESSION::addFlash("success","User has been kicked");
                $compare = new \DateTime($sqlConverted);
                if ($compare < date('Y-m-d H:i:s')) $this->redirectTo("home","index");
                $this->redirectTo("user","usersList");
            }
        }

        public function unban()
        {
            if (!SESSION::isAdmin()) $this->redirectTo("home","index");
            $userId = $_GET["id"];
            $userManager = new UserManager();
            $userManager->unbanUser($userId);            
            SESSION::addFlash("success","Redemption has been giveth");
            $this->redirectTo("user","usersList");
        }

        public function promote()
        {
            if (!SESSION::isAdmin()) $this->redirectTo("home","index");
            $userId = $_GET["id"];
            $userManager = new UserManager();
            $userManager->makeRole($userId, "mod");            
            SESSION::addFlash("success","Mod rights been giveth");
            $this->redirectTo("user","usersList");
        }

        public function demote()
        {
            if (!SESSION::isAdmin()) $this->redirectTo("home","index");
            $userId = $_GET["id"];
            $userManager = new UserManager();
            $userManager->makeRole($userId, "member");            
            SESSION::addFlash("success","Mod rights been taketh");
            $this->redirectTo("user","usersList");
        }
    }
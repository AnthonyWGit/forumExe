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
            $userId = $_GET["id"];
            $userManager = new UserManager();
            if ($userId == $_SESSION["user"]->getId() && SESSION::isAdmin())
            {
                SESSION::addFlash("error","Why are you trying to ban yourself ?");
                $this->redirectTo("user","usersList");
            }
            else
            {
                $userManager->banUser($userId);            
                SESSION::addFlash("success","User has been banhammer'ed");
                $this->redirectTo("user","usersList");
            }
        }

        public function unban()
        {
            $userId = $_GET["id"];
            $userManager = new UserManager();
            $userManager->unbanUser($userId);            
            SESSION::addFlash("success","Redemption has been giveth");
            $this->redirectTo("user","usersList");
        }
    }
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
    }
<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\PostManager;
    
    class PostController extends AbstractController implements ControllerInterface
    {
        public function index()
        {

        }
        
        public function listPosts()
        {
            $postManager = new PostManager();

            return [
                "view" => VIEW_DIR."forum/listPosts.php",
                "data" => [
                    "posts" => $postManager->findPostsInTopic($_GET["id"]),
                ]
                ];
            

        }

        public function newPost()
        {
            $data = ["user_id" => 1, "topic_id" => $_GET["id"], "content"=>$_POST["firstPost"]];
            $postManager = new PostManager();
            
            $postManager->add($data);
        }

        // public function topicTitleDisplay()
        // {
        //     $postManager = new PostManager();
        //     return [
        //         "view" => VIEW_DIR."forum/listPosts.php",
        //         "data" => [
        //             "title" => $postManager->findTitleOfTopic($_GET["id"])
        //         ]
        //         ];
        // }
    }

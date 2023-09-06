<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\PostManager;
    
    class PostController extends AbstractController implements ControllerInterface{

        public function index(){
          
        $postManager = new PostManager();

        return [
            "view" => VIEW_DIR."forum/listPosts.php",
            "data" => [
                "posts" => $postManager->findPostsInTopic($_GET["id"]),
                "title" => $postManager->findTitleOfTopic($_GET["id"])
                
            ]
            ];
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

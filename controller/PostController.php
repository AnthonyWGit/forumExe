<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\PostManager;
    
    class PostController extends AbstractController implements ControllerInterface{

        public function index(){
          
        $topicManager = new PostManager();

        return [
            "view" => VIEW_DIR."forum/listPosts.php",
            "data" => [
                "posts" => $topicManager->findPostsInTopic($_GET["id"])
            ]
            ];
        }
    }

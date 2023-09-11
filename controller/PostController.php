<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\PostManager;
    use Model\Managers\TopicManager;
    
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
            //vital minimum filtering
            $sanitizedPost = filter_var($_POST["makePost"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //trimming spaces 
            $sanitizedPost = trim($sanitizedPost);

            $data = ["user_id" => $_SESSION["user"]->getId(), "topic_id" => $_GET["id"], "content"=>$sanitizedPost];
            $postManager = new PostManager();
            $postManager->add($data);
            $this->redirectTo("post", "listPosts", $_GET["id"]);
        }

        public function deletePost()
        {
            if ($_SESSION["user"]->getRole() == "admin") //check if action is performed by admin
            {
                $count = 0;
                $postManager = new PostManager();
                $topicManager = new TopicManager();
                $idPost = $_GET["id"];
                $post = $postManager->withPostGetTopicIdSingle($idPost);
                $idTopic = $post->getTopic()->getId();
                $idCategort = $post->getTopic()->getCategory()->getId();

                $topicsList = $postManager->findPostsInTopic($idTopic);
                foreach ($topicsList as $topic )
                {
                    $count++;
                }

                $nbPosts = $count;
                if (isset($_SESSION["messagePop"]) && ($_SESSION["messagePop"] == 1)) // here it mean there is only one msg and user saw flash msg
                {
                    $postManager->deletePost($_GET["id"]);
                    if (isset($_SESSION["messagePop"])) unset($_SESSION["messagePop"]); //delete messagePop
                    $this->redirectTo("topic","listTopics",$idCategort);
                }
                else if ($nbPosts == 1 && !isset($_SESSION["messagePop"])) 
                {//there is one post and this is the dirst click on button so messgaeop is not set 
                    $postManager->findPostsInTopicOneOrNull($idTopic);
                    $_SESSION["messagePop"] = 1;
                    SESSION::addFlash("error", "Click aagain to delete");
                    $this->redirectTo("post","listPosts",$idTopic);
                }
                else if ($nbPosts > 1 && !isset($_SESSION["messagePop"]))
                {//there is more than one post and so message to del last post in not set 
                    $postManager->deletePost($_GET["id"]);
                    $this->redirectTo("post","listPosts",$idTopic);
                }
            }
            else
            {
                $errors = [];
                $errors[] = "This is an exemple of an unauthorized action";
                $this->redirectTo("security","displayErrorPage");
            }
            
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

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
            $postObject = $postManager->findPostsInTopicOneOrNull($_GET["id"]);
            if(!$postObject)
            {
                $errors = [];
                $errors[] = "This page doesn't exists";
                $_SESSION["errors"] = $errors;
                $this->redirectTo("security","displayErrorPage");
            }
            else
            {
                return [
                    "view" => VIEW_DIR."forum/listPosts.php",
                    "data" => [
                        "posts" => $postManager->findPostsInTopic($_GET["id"]),
                    ]
                    ];
                                
            }

        }

        public function editPost()
        {
            $postManager = new PostManager();
            $idPost = $_GET["id"];

            if (!$postManager->findAPostByIdAndTopicId($idPost)) //The post doesn't exists
            {
                $errors = [];
                $errors[] = "This page doesn't exists";
                $_SESSION["errors"] = $errors;
                $this->redirectTo("security","displayErrorPage");
            }
            else //the post exists
            {
                $idTopic = $postManager->findAPostByIdAndTopicId($idPost)->getTopic()->getId();
                // Using ||Because when the topic is locked no route to edit post should be open 
                if ($_SESSION["user"] != $postManager->findAPostByIdAndTopicId($idPost)->getUser()->getUsername() || $postManager->findAPostByIdAndTopicId($idPost)->getTopic()->getLock() == 1) 
                {
                    SESSION::addFlash("error" , "You vile person");
                    $this->redirectTo("home","index");
                }
                else
                {
                    $postContent = $postManager->findAPostByIdAndTopicId($idPost)->getContent();
                    $idTopic = $postManager->findAPostByIdAndTopicId($idPost)->getTopic()->getId();     
                    return [
                        "view" => VIEW_DIR."forum/editPost.php",
                        "data" => [
                            "posts" => $postManager->findPostsInTopic($idTopic),
                            "idPost" => $idTopic,
                            "content" => $postManager->findAPostByIdAndTopicId($idPost)->getContent()
                        ]
                        ];                          
                }                    
            }
   
        }

        public function newPost()
        {
            //vital minimum filtering
            $sanitizedPost = filter_var($_POST["makePost"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //trimming spaces 
            $sanitizedPost = trim($sanitizedPost);
            $sanitizedPost = trim($sanitizedPost, chr(0xC2).chr(0xA0));
            $data = ["user_id" => $_SESSION["user"]->getId(), "topic_id" => $_GET["id"], "content"=>$sanitizedPost];
            $postManager = new PostManager();
            if (empty($sanitizedPost))
            {
                SESSION::addFlash("error","Post cannot be empty");
                $this->redirectTo("post","listPosts",$_GET["id"]);
            }
            else
            {
                $postManager->add($data);                
                $postManager->addCountUp($_GET["id"]);
                $this->redirectTo("post", "listPosts", $_GET["id"]);                
            }
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
                    $postManager->deletePost($idPost);
                    $topicManager->deleteTopic($idTopic);
                    if (isset($_SESSION["messagePop"])) unset($_SESSION["messagePop"]); //delete messagePop
                    SESSION::addFlash("success", "This post has been reduced to nothing");
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
                    $postManager->deleteCountDown($idTopic);
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

        public function edit()
        {
            $idPost = $_GET["id"];
            $postManager = new PostManager();
            if ($_SESSION["user"] != $postManager->findAPostByIdAndTopicId($idPost)->getUser()->getUsername() || $postManager->findAPostByIdAndTopicId($idPost)->getTopic()->getLock() == 1)
            {
                SESSION::addFlash("error" , "You vile person");
                $this->redirectTo("home","index");
            }
            else
            {
                $postContent = $postManager->findAPostByIdAndTopicId($idPost)->getContent();
                $idTopic = $postManager->findAPostByIdAndTopicId($idPost)->getTopic()->getId();
                $this->redirectTo("post","editPost",$idPost);
            }        

        }

        public function editConfirm()
        {
            $postManager = new PostManager();
            $idPost = $_GET["id"]; 
            $idTopic = $postManager->findAPostByIdAndTopicId($idPost)->getTopic()->getId();
            if ($_SESSION["user"] != $postManager->findAPostByIdAndTopicId($idPost)->getUser()->getUsername() || $postManager->findAPostByIdAndTopicId($idPost)->getTopic()->getLock() == 1)
            {
                SESSION::addFlash("error","Something wrong happpenned");
                $this->redirectTo("home","index");                
            }
            else
            {
                //sanitize the post input and get rid of spaces 
                $sanitizedPostContent = filter_var($_POST["postContent"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $trimedSanitizedPostContent = trim($sanitizedPostContent);
                $trimedSanitizedPostContent = trim($trimedSanitizedPostContent, chr(0xC2).chr(0xA0)); //Doesn't work, trying to remove nbsp 
                $postManager->editPostContent($idPost, $trimedSanitizedPostContent);
                SESSION::addFlash("success","Post has been updated");
                $this->redirectTo("post","listPosts",$idTopic);        
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

<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    
    class TopicController extends AbstractController implements ControllerInterface
    {

        public function index()
        {
        }
          
        //    $topicManager = new TopicManager();

        //     return [
        //         "view" => VIEW_DIR."forum/listTopics.php",
        //         "data" => [
        //             "topics" => $topicManager->findAll(["creationdate", "DESC"])
        //         ]
        //     ]; 
        //Block above shows all topics fromm all categories 
        public function listTopics()
        {

            $topicManager = new TopicManager();

            return [
                "view" => VIEW_DIR."forum/listTopics.php",
                "data" => [
                    "topics" => $topicManager->findTopicsByCategory($_GET["id"])
                    ]
                ];
            

        }

        public function newTopic()
        {
            //Creating managers
            $topicManager = new TopicManager();
            $postManager = new PostManager();

            //but first filter what is posted 
            $sanitizedTitle = filter_var($_POST["title"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            //We get of spaces end and beginning
            $sanitizedTitle = trim($sanitizedTitle);

            $titleLenght = strlen($sanitizedTitle);
            if ($titleLenght == 0)
            {
                if (isset($_SESSION["error"])) unset ($_SESSION["error"]);
                SESSION::addFlash("error", "You cannot have an empty title");
                $this->redirectTo("topic","listTopics",$_GET["id"]);
            }
            else
            {
                $allowanceEmpty = 1;
            }   
            if ($titleLenght > 30)
            {
                if (isset($_SESSION["error"])) unset ($_SESSION["error"]);
                SESSION::addFlash("error", "You cannot have a title with more than 30 chars");
                $this->redirectTo("topic","listTopics",$_GET["id"]);
            }
            else
            {
                $allowanceMax = 1;
            }
            //BELOW FORK WHERE THINGS ARE CORRECT
            //every topic needs at least a first post. Putting what's in the form in the first post
            //first filter post content
            $sanitizedContent = filter_var($_POST["content"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            //trimming
            $sanitizedContent = trim($sanitizedContent);    
            if(empty($sanitizedContent))
            {
                if (isset($_SESSION["error"])) unset ($_SESSION["error"]);
                SESSION::addFlash("error", "Post cannot be empty");
                $this->redirectTo("topic","listTopics",$_GET["id"]);
            }
            else
            {
                $allowancePost = 1;
            }

            if ($allowanceEmpty == 1 && $allowanceMax == 1 && $allowancePost ==1)
            {
                $data = ["user_id" => $_SESSION["user"]->getId() , "title" => $sanitizedTitle, "category_id" => $_GET["id"]];
                //Creating the topic and return its id 
                $idTopicLastCreated = $topicManager->createNewTopic($data);
                $dataPost=["user_id" => $_SESSION["user"]->getId(), "topic_id" => $idTopicLastCreated, "content" => $sanitizedContent];
                $postManager->createNewPost($dataPost);
                $this->redirectTo("post","listPosts",$idTopicLastCreated);                    
            }
            else
            {
                if (isset($_SESSION["error"])) unset ($_SESSION["error"]);
                SESSION::addFlash("error", "An error has occured");
                $this->redirectTo("topic","listTopics",$_GET["id"]);
            }                
        }
    }
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
            //use data from post

            //but first filter what is posted 
            $sanitizedTitle = filter_var($_POST["title"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = ["user_id" => $_SESSION["user"]->getId() , "title" => $sanitizedTitle, "category_id" => $_GET["id"]];
            $topicManager = new TopicManager();
            $postManager = new PostManager();
            $idCat = $_GET["id"];

            $idTopicLastCreated = $topicManager->createNewTopic($data);
            // $topicManager->createNewTopic($data);

            //every topic needs at least a first post. Putting what's in the form in the first post

            //first filter post content
            $sanitizedContent = filter_var($_POST["content"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dataPost=["user_id" => $_SESSION["user"]->getId(), "topic_id" => $idTopicLastCreated, "content" => $sanitizedContent];
            $postManager->createNewPost($dataPost);
            $this->redirectTo("post","listPosts",$idTopicLastCreated);     
        }

    }
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
            $data = ["user_id" => 1 , "title" => $_POST["title"], "category_id" => $_GET["id"]];
            $topicManager = new TopicManager();
            $postManager = new PostManager();

            $topicManager->createNewTopic($data);
            $data=["user_id" => 1, "topic_id" => 1];
            $postManager->createNewPost($data);

            $this->redirectTo("topic","listTopics");            
        }

    }
<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicManager;
    
    class TopicController extends AbstractController implements ControllerInterface{

        public function index(){
          

        //    $topicManager = new TopicManager();

        //     return [
        //         "view" => VIEW_DIR."forum/listTopics.php",
        //         "data" => [
        //             "topics" => $topicManager->findAll(["creationdate", "DESC"])
        //         ]
        //     ]; 
        //Block above shows all topics fromm all categories 
        
        $topicManager = new TopicManager();

        return [
            "view" => VIEW_DIR."forum/listTopics.php",
            "data" => [
                "topics" => $topicManager->findTopicsByCategory($_GET["id"])
            ]
            ];
        }
    }
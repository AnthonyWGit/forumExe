<?php

    // namespace Controller;

    // use App\Session;
    // use App\AbstractController;
    // use App\ControllerInterface;
    // use Model\Managers\TopicManager;
    // use Model\Managers\PostManager;
    // use Model\Managers\CategoryManager;
    
    // class ForumController extends AbstractController implements ControllerInterface{

    //     public function index(){
          

    //        $topicManager = new TopicManager();

    //         return [
    //             "view" => VIEW_DIR."forum/listTopics.php",
    //             "data" => [
    //                 "topics" => $topicManager->findAll(["creationdate", "DESC"])
    //             ]
    //         ];
        
    //     }

    //     public function listCategories(){
  
    //         $categoryManager = new CategoryManager();
 
    //          return [
    //              "view" => VIEW_DIR."forum/listCategories.php",
    //              "data" => [
    //                  "categories" => $categoryManager->findAll(["name", "ASC"])
    //              ]
    //          ];
         
    //      }

    //      public function listUsers(){
  
    //         $categoryManager = new UserManager();
 
    //          return [
    //              "view" => VIEW_DIR."forum/listUsers.php",
    //              "data" => [
    //                  "categories" => $categoryManager->findAll(["username", "DESC"])
    //              ]
    //          ];
         
    //      }
    // }

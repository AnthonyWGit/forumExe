<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\CategoryManager;
    
    class CategoryController extends AbstractController implements ControllerInterface{

        public function index()
        {
            if (SESSION::isBanned() || SESSION::isKicked()) $this->redirectTo("home","index");

            $categoryManager = new CategoryManager();
 
             return [
                 "view" => VIEW_DIR."forum/listCategories.php",
                 "data" => [
                     "categories" => $categoryManager->findAll(["name", "ASC"])
                 ]
             ];
        
        }

    }

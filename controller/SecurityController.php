<?php


namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\SecurityManager;

class HomeController extends AbstractController implements ControllerInterface
{

    public function index()
    {

    }

    public function displayRegisterForm()
    {
       return
       [
        "view" => VIEW_DIR."forum/register.php"
       ];
    }


}
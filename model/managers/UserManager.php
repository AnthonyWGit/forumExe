<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Model\Managers\UserManager;

    class UserManager extends Manager{

        protected $className = "Model\Entities\User";
        protected $tableName = "user";


        public function __construct(){
            parent::connect();
        }

        public function usernameFind($username)
        {
            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.username = :username
                    ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['username' => $username], false), 
                $this->className
            );
        }

        public function addUser($data)
        {
            unset($data["validatePassword"]);
            return $this->add($data);
        }
    }
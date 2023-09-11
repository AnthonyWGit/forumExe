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
                    FROM ".$this->tableName."
                    WHERE username = :username
                    ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['username' => $username], false), 
                $this->className
            );
        }

        public function emailFind($email)
        {
            $sql = "SELECT *
                    FROM ".$this->tableName." 
                    WHERE email = :email
                    ";
            return $this->getOneOrNullResult(
                DAO::select($sql, ['email' => $email], false), 
                $this->className
            );

        }

        public function passwordFindbyUsername($username)
        {
            $sql = "SELECT *
                    FROM ".$this->tableName." 
                    WHERE username = :username
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
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

        public function userFind($id)
        {
            $sql = "SELECT *
                    FROM ".$this->tableName."
                    WHERE id_user = :id
                    ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['id'=>$id], false), 
                $this->className
            );
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

        public function findAllExept($order = null) //Exeption to not show deleted user 
        {

            $orderQuery = ($order) ?                 
                "ORDER BY ".$order[0]. " ".$order[1] :
                "";

            $sql = "SELECT *
                    FROM ".$this->tableName." 
                    WHERE ".$this->tableName."name <> :username_exception
                    ".$orderQuery;
            $param["username_exception"] = "Deleted user";
            return $this->getMultipleResults(
                DAO::select($sql, $param), 
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

        public function banUser($idUser)
        {
            $sql = "UPDATE user as s
                    SET s.state = :prepare , banDate = CURRENT_TIMESTAMP()
                    WHERE id_user = :id";
            $param = [];
            $param["id"] = $idUser;
            $param["prepare"] = "banned";
            DAO::update($sql,$param);
        }

        public function kickUser($idUser, $duration)
        {
            $sql = "UPDATE user as s
                    SET s.state = :prepare , s.kickDate = '$duration'
                    WHERE id_user = :id";
            $param = [];
            $param["id"] = $idUser;
            $param["prepare"] = "kicked";
            DAO::update($sql,$param);
        }

        public function unbanUser($idUser)
        {
            $sql = "UPDATE user as s
                    SET s.state = :prepare , banDate = NULL , kickDate = NULL
                    WHERE id_user = :id";
            $param = [];
            $param["id"] = $idUser;
            $param["prepare"] = "free";
            DAO::update($sql,$param);
        }

        public function makeRole($idUser, $role)
        {
            $sql = "UPDATE user as s
            SET s.role = :prepare
            WHERE id_user = :id";
            $param = [];
            $param["id"] = $idUser;
            $param["prepare"] = $role;
            DAO::update($sql,$param);
        }

        public function modifyUser($data)
        {
            $sql = "UPDATE user as s
            SET s.username = :username, s.password = :passwordH, s.email = :email 
            WHERE id_user = :id";
            $param = [];
            $param["id"] = $_SESSION["user"]->getId();
            $param["username"] = $data["username"];
            $param["passwordH"] = $data["password"];
            $param["email"] = $data["email"];
            DAO::update($sql,$param);
        }

        public function deleteAccount($userId)
        {
            $sql = "UPDATE user as s
            SET s.username = :username, s.password = :passwordH, s.email = :email , s.registerDate = :re , s.state = :state
            WHERE id_user = :id";
            $param = [];
            $param["id"] = $_SESSION["user"]->getId();
            $param["username"] = "Deleted user";
            $param["passwordH"] = "nopwd";
            $param["email"] = "none";
            $param["re"] = NULL;
            $param["state"] = "deleted";
            DAO::update($sql,$param);
        }

        public function updateAvatar($file)
        {
            $sql = "UPDATE user as s
            SET s.profileImg = :fileH
            WHERE id_user = :id";
            $param = [];
            $param["id"] = $_SESSION["user"]->getId();
            $param["fileH"] = $file;
            DAO::update($sql,$param);
        }
    }
<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Model\Managers\PostManager;

    class PostManager extends Manager{

        protected $className = "Model\Entities\Post";
        protected $tableName = "post";


        public function __construct(){
            parent::connect();
        }
// Using a custom method because we need to find all the topics by ids 
        public function findPostsInTopic($id)
        {
            $sql = "SELECT *
                    FROM ".$this->tableName. " p
                    WHERE p.topic_id = :id";
                
            return $this->getMultipleResults(
                DAO::select($sql, ['id'=>$id]),
                $this->className
            );
        }

        public function findTitleOfTopic($id)
        {
            $sql = "SELECT title
                    FROM ".$this->tableName. " p
                    WHERE p.topic_id = :id";
                
            return $this->getOneOrNullResult(
                DAO::select($sql, ['id'=>$id]),
                $this->className
            );
        }

    }
<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Model\Managers\TopicManager;

    class TopicManager extends Manager{

        protected $className = "Model\Entities\Topic";
        protected $tableName = "topic";


        public function __construct(){
            parent::connect();
        }
// Using a custom method because we need to find all the topics by ids 
        public function findTopicsByCategory($id)
        {
            $sql = "SELECT *
                    FROM ".$this->tableName. " p
                    WHERE p.category_id = :id";
                
            return $this->getMultipleResults(
                DAO::select($sql, ['id'=>$id]),
                $this->className
            );
        }

        public function createNewTopic($data) //we need to id to know in wich category we create the topic
        {
            return $this->add($data);
        }
    }
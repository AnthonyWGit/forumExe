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
        
        public function findOneCategoryFromTopic($idTopic)
        {
            $sql = "SELECT *
            FROM ".$this->tableName. " p
            WHERE p.id_topic = :id";
        
            return $this->getOneOrNullResult(
                DAO::select($sql, ['id'=>$idTopic], false),
                $this->className
            );
                }
        
        public function createNewTopic($data) //we need to id to know in wich category we create the topic
        {
            return $this->add($data);
        }

        public function deleteTopic($id)
        {
            return $this->delete($id);
        }

        public function lock($idTopic)
        { //LOCK is reserved keyword we need aliases
            $sql = "UPDATE topic as t
            SET t.lock = 1
            WHERE id_topic = :id";
            $param = [];
            $param["id"] = $idTopic;
            DAO::update($sql,$param);            
        }

        public function unlock($idTopic)
        {
            $sql = "UPDATE topic as t
            SET t.lock = '0'
            WHERE id_topic = :id";
            $param = [];
            $param["id"] = $idTopic;
            DAO::update($sql,$param);            
        }

        public function findTopicsByUserMultiple($id)
        {
            $sql = "SELECT *
                    FROM ".$this->tableName. " p
                    WHERE p.user_id = :id";
                
            return $this->getMultipleResults(
                DAO::select($sql, ['id'=>$id]),
                $this->className
            );
        }

        public function findTopicsByUserSingle($id)
        {
            $sql = "SELECT *
                    FROM ".$this->tableName. " p
                    WHERE p.user_id = :id";
                
            return $this->getOneOrNullResult(
                DAO::select($sql, ['id'=>$id], false),
                $this->className
            );
        }

    }
<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    use Model\Managers\CategoryManager;

    class CategoryManager extends Manager{

        protected $className = "Model\Entities\Category";
        protected $tableName = "category";


        public function __construct(){
            parent::connect();
        }

        public function findACategortyId($idCat)
        {
            $sql = "SELECT *
            FROM ".$this->tableName. " p
            WHERE p.id_category = :idCat";
        
            return $this->getOneOrNullResult(
                DAO::select($sql, ['idCat'=>$idCat], false),
                $this->className
            );
        }
    }

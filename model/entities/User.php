<?php
    namespace Model\Entities;


    use App\Entity;
    use App\Session;

    final class User extends Entity{

        private $id;
        private $username;
        private $role;
        private $registerDate;
        private $password;
        private $email;

        public function __construct($data){         
            $this->hydrate($data);        
        }
 
        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of username
         */ 
        public function getUsername()
        {
                return $this->username;
        }

        /**
         * Set the value of username
         *
         * @return  self
         */ 
        public function setUsername($username)
        {
                $this->username = $username;

                return $this;
        }

        /**
         * Get the value of role
         */ 
        public function hasRole()
        {
                return $this->role;
        }

        /**
         * Set the value of role
         *
         * @return  self
         */ 
        public function setRole($role)
        {
                $this->role = $role;

                return $this;
        }

        public function gstRegisterDate(){
            $formattedDate = $this->registerDate->format("d/m/Y, H:i:s");
            return $formattedDate;
        }

        public function getRegisterDate($date){
            $this->creationdate = new \DateTime($date);
            return $this;
        }

        /**
         * Get the value of password
         */ 
        public function getPassword()
        {
                return $this->password;
        }

        /**
         * Set the value of Password
         *
         * @return  self
         */ 
        public function setPassword($password)
        {
                $this->password = $password;

                return $this;
        }

        /**
         * Get the value of email
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Set the value of Email
         *
         * @return  self
         */ 
        public function setEmail($email)
        {
                $this->email = $email;

                return $this;
        }
        //If no tostring the app will crash because in layout we echo the object
        public function __toString()
        {
                return $this->getUsername();
        }
    }

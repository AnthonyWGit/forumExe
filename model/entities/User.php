<?php
    namespace Model\Entities;


    use App\Entity;
    use App\Session;

    final class User extends Entity{

        private int $id;
        private string $username;
        private string $role;
        private Object $creationdate;
        private Object $registerDateObject;
        private string $password;
        private string $email;
        private string $state;

        public function __construct($data){         
            $this->hydrate($data);        
        }
 
        /**
         * Get the value of id
         */ 
        public function getId() : int
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId(int $id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of username
         */ 
        public function getUsername() : string
        {
                return $this->username;
        }

        /**
         * Set the value of username
         *
         * @return  self
         */ 
        public function setUsername(string $username)
        {
                $this->username = $username;

                return $this;
        }

        /**
         * Get the value of role
         */ 
        public function getRole() : string
        {
                return $this->role;
        }

        /**
         * Set the value of role
         *
         * @return  self
         */ 
        public function setRole(string $role)
        {
                $this->role = $role;

                return $this;
        }

        public function getRegisterDateObject() : Object
        {
                return $this->creationdate;
        }

        public function getRegisterDate() : string
        {
            $formattedDate = $this->creationdate->format("d/m/Y, H:i:s");
            return $formattedDate;
        }

        public function setRegisterDate(string $date)
        {
            $this->creationdate = new \DateTime($date);
            return $this;
        }

        /**
         * Get the value of password
         */ 
        public function getPassword() : string
        {
                return $this->password;
        }

        /**
         * Set the value of Password
         *
         * @return  self
         */ 
        public function setPassword(string $password)
        {
                $this->password = $password;

                return $this;
        }

        /**
         * Get the value of email
         */ 
        public function getEmail() : string 
        {
                return $this->email;
        }

        /**
         * Set the value of Email
         *
         * @return  self
         */ 
        public function setEmail(string $email)
        {
                $this->email = $email;

                return $this;
        }

                /**
         * Get the value of state
         */ 
        public function getState() : string 
        {
                return $this->state;
        }

        /**
         * Set the value of state
         *
         * @return  self
         */ 
        public function setState(string $state)
        {
                $this->state = $state;

                return $this;
        }

        public function hasRole(string $roleName)
        {
                if ($_SESSION["user"]->getRole() == $roleName) // This is used to check if 
                {
                        return true;
                }
                else
                {
                        return false;
                }
        }
        
        
        //If no tostring the app will crash because in layout we echo the object
        public function __toString()
        {
                return $this->getUsername();
        }

    }

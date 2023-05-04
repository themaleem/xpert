<?php
    require_once ("account.php");

    class Staff extends Account {
        private $role;
      

        public function __construct($id, $name, $email, $role, $password) {
            parent::__construct($id, $name, $email, $password);
           
            $this->role = $role;
        }

        public function setRole($value){
            $this->role = $value;
        }
        public function getRole(){
            return $this->role;
        }


        public function display_details(){
            print "User name: ". $this->getName(). " <br />";
            print "User email: ". $this->getEmail() ." <br />";
            print "User role: $this->role <br />";
           
        }


    }
?>

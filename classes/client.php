<?php

    require_once ("account.php");

    class Client extends Account {
        private $phone_number;
        private $address;

        public function __construct($id,$name, $email, $phone_number, $address, $password) {
            parent::__construct($id, $name, $email, $password);
            $this->phone_number = $phone_number;
            $this->address = $address;
        }


         public function setAddress($value){
        $this->address = $value;
        }
        public function getAddress(){
            return $this->address;
        }


        public function setPhoneNumber($value){
            $this->phone_number = $value;
        }
        public function getPhoneNumber(){
            return $this->phone_number;
        }


        public function display_details(){
            print "User name: ". $this->getName(). " <br />";
            print "User email: ". $this->getEmail() ." <br />";
            print "User phone number: $this->phone_number <br />";
            print "User address: $this->address <br />";
        }


    }
?>

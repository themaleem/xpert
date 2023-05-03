<?php
class Account  {
    private $id;
    private $name;
    private $email;
    private $password;

    public function __construct($id, $name, $email, $password) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }


    public function setId($value){
        $this->id = $value;
    }
    public function getId(){
    	return $this->id;
    }

    public function setName($value){
        $this->name = $value;
    }
    public function getName(){
    	return $this->name;
    }

    public function setEmail($value){
        $this->email = $value;
    }
    public function getEmail(){
    	return $this->email;
    }

    public function setPassword($value){
        $this->password = $value;
    }
    public function getPassword(){
    	return $this->password;
    }

    public function display_details(){
        echo "User name: $this->name <br />";
        print "User email: $this->email<br />";
        // print "User phone number: $this->phone_number %<br />";
        // print "User address: $this->address %<br />";
    }
}

?>


<?php

require_once('../../classes/event.php');

class EventModel {
    private $link;
    
    public function __construct($connection) {
        $this->link = $connection;
    }

    public function createClient($client) {
        if (!isset($client)) {
            throw new Exception("Client object required");
        }
        $sql = "INSERT INTO clients (name, email, phone_number, address, password) VALUES (?,?,?,?,?)";

        $name = $client->getName();
        $email = $client->getEmail();
        $phone_number = $client->getPhoneNumber();
        $address = $client->getAddress();
        $password = $client->getPassword();

        $stmt = $this->link->prepare($sql);
        $stmt->bind_param('sssss',$name,$email, $phone_number,$address, $password);
        $status = $stmt->execute();

        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not save Client: " . $errorInfo[2]);
        }

        $id = $this->link->insert_id;
        
        return $id;
    }

    public function delete($client) {
        if (!isset($client)) {
            throw new Exception("client required");
        }
        $id = $client->getId();
        if ($id == null) {
            throw new Exception("client id required");
        }
        $sql = "DELETE FROM clients WHERE id = :id";
        $params = array('id' => $client->getId());
        $stmt = $this->link->prepare($sql);
        $status = $stmt->execute($params);
        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not delete client: " . $errorInfo[2]);
        }
    }



    public function getClientByEmailAndPassword($email,$password) {
        $sql = 'SELECT * FROM clients WHERE email = ? and password = ?';
        $stmt = $this->link->prepare($sql);
        $stmt->bind_param('ss', $email, $password);
        $status = $stmt->execute();
        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not retrieve Client: " . $errorInfo[2]);
        }

        $result= $stmt->get_result();

        $client=null;
        
        if($result->num_rows > 0) {
          
            $row = $result->fetch_assoc();
            $id = $row['id'];
            $name = $row['name'];
            $phone_number = $row['phone_number'];
            $address = $row['address'];
            $password = $row['password'];
            $client = new Client($id, $email, $name, $phone_number, $address, $password);
        }
        return $client;
    }

    public function checkEmailExist($email) {
   
        $sql = "SELECT * FROM clients WHERE email = ?";
        
        // $params = array('email' => $email);
        $stmt = $this->link->prepare($sql);
        $stmt->bind_param('s',$email);
        $status = $stmt->execute();
        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not retrieve Client: " . $errorInfo[2]);
        }

        $result = $stmt->get_result();

        $stmt->close();
        if ($result->num_rows == 1){
            return true;
        };

        return false;     
    }

    public function getClients() {
        $sql = "SELECT * FROM clients";
        $stmt = $this->link->prepare($sql);
        $status = $stmt->execute();
        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not retrieve clients: " . $errorInfo[2]);
        }

        $clients = array();
        $row = $stmt->fetch();
        while ($row != null) {
            $id = $row['id'];
            $name = $row['name'];
            $email = $row['email'];
            $phone_number = $row['phone_number'];
            $address = $row['address'];
            $password = $row['password'];

            $client = new Client($id, $name, $email, $phone_number, $address, $password);
            $clients[$id] = $client;

            $row = $stmt->fetch();
        }
        return $clients;
    }
}

?>

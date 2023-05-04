<?php

require_once('./classes/package.php');

class PackageModel {
    private $link;
    
    public function __construct($connection) {
        $this->link = $connection;
    }

    public function createPackage($package) {
        if (!isset($package)) {
            throw new Exception("Package object required");
        }
        $sql = "INSERT INTO packages (name, price, event_type, description) VALUES (?,?,?,?,?)";

        $name = $package->getName();
        $price = $package->getPrice();
        $event_type = $package->getEventType();
        $description = $package->getDescription();
        $client_id = $package->getClientId();
    

        $stmt = $this->link->prepare($sql);
        $stmt->bind_param('siss', $name, $price, $event_type, $description, $client_id);
        $status = $stmt->execute();

        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not save Package: " . $errorInfo[2]);
        }

        $id = $this->link->insert_id;
        return $id;
    }


    public function getPackageById($id) {
        $sql = 'SELECT * FROM packages WHERE id = ?';
        $stmt = $this->link->prepare($sql);
        $stmt->bind_param('i', $id);
        $status = $stmt->execute();
        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not retrieve Package: " . $errorInfo[2]);
        }

        $result= $stmt->get_result();

        $package=null;

        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id = $row['id'];
            $name = $row['name'];
            $price = $row['price'];
            $event_type = $row['event_type'];
            $description = $row['description'];
            $client_id = $row['client_id'];
            $package = new Package($id, $name, $price, $event_type, $description, $client_id);
        }
        // Close the mysqli connection
        $this->link->close();
        return $package;
    }

    public function getPackages() {
        $sql = "SELECT * FROM packages";
        $stmt = $this->link->prepare($sql);
        $status = $stmt->execute();
        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not retrieve packages: " . $errorInfo[2]);
        }
        $result= $stmt->get_result();
        
        $packages = array();

        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $name = $row['name'];
            $price = $row['price'];
            $event_type = $row['event_type'];
            $description = $row['description'];
            $client_id = $row['client_id'];
    
            $package = new Package($id, $name, $price, $event_type, $description,$client_id);
            $packages[$id] = $package;
        }
        
        // Close the mysqli connection
        $this->link->close();
    
        return $packages;
    
        
    }
}

?>

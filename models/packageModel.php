<?php

require_once('../../classes/package.php');

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
    

        $stmt = $this->link->prepare($sql);
        $stmt->bind_param('siss', $name, $price, $event_type, $description);
        $status = $stmt->execute();

        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not save Package: " . $errorInfo[2]);
        }

        $id = $this->link->insert_id;
        return $id;
    }

    public function delete($package) {
        if (!isset($package)) {
            throw new Exception("package required");
        }
        $id = $package->getId();
        if ($id == null) {
            throw new Exception("package id required");
        }
        $sql = "DELETE FROM packages WHERE id = :id";
        $params = array('id' => $package->getId());
        $stmt = $this->link->prepare($sql);
        $status = $stmt->execute($params);
        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not delete package: " . $errorInfo[2]);
        }
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
            $package = new Package($id, $name, $price, $event_type, $description);
        }
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

        $packages = array();
        $row = $stmt->fetch();
        while ($row != null) {
            $id = $row['id'];
            $name = $row['name'];
            $price = $row['price'];
            $event_type = $row['event_type'];
            $description = $row['description'];

            $package = new Package($id, $name, $price, $event_type, $description);
            $packages[$id] = $package;

            $row = $stmt->fetch();
        }
        return $packages;
    }
}

?>

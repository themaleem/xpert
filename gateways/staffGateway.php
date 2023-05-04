<?php

require_once('../../classes/staff.php');

class StaffTable {
    private $link;
    
    public function __construct($connection) {
        $this->link = $connection;
    }

    public function insert($staff) {
        if (!isset($staff)) {
            throw new Exception("staff object required");
        }
        $sql = "INSERT INTO staffs (name, email, role, password) VALUES (?,?,?,?)";

        $name = $staff->getName();
        $email = $staff->getEmail();
        $role = $staff->getRole();
        $password = $staff->getPassword();
        $stmt = $this->link->prepare($sql);
        $stmt->bind_param('ssss',$name,$email, $role, $password);
        $status = $stmt->execute();

        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not save staff: " . $errorInfo[2]);
        }

        $id = $this->link->insert_id;
        
        return $id;
    }



 

    public function getStaffByName($name) {
        $sql = "SELECT * FROM staffs WHERE name = :name";
        $params = array('name' => $name);
        $stmt = $this->link->prepare($sql);
        $status = $stmt->execute($params);
        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not retrieve Staff: " . $errorInfo[2]);
        }

        $staff = null;
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch();
            $id = $row['id'];
            $email = $row['email'];
            $role = $row['role'];
            $password = $row['password'];
            $staff = new Staff($id, $name, $email, $role, $password);
        }
        return $staff;
    }

    public function getStaffByEmail($email,$password) {
        $sql = 'SELECT * FROM staffs WHERE email = ? and password = ?';
        $stmt = $this->link->prepare($sql);
        $stmt->bind_param('ss', $email, $password);
        $status = $stmt->execute();
        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not retrieve Staff: " . $errorInfo[2]);
        }

        $result= $stmt->get_result();

        $staff=null;
        
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id = $row['id'];
            $name = $row['name'];
            $role = $row['role'];
            $password = $row['password'];
            $staff = new Staff($id, $email, $name, $role, $password);
        }
        return $staff;
    }

    public function checkEmailExist($email) {
   
        $sql = "SELECT * FROM staffs WHERE email = ?";
        
        // $params = array('email' => $email);
        $stmt = $this->link->prepare($sql);
        $stmt->bind_param('s',$email);
        $status = $stmt->execute();
        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not retrieve Staff: " . $errorInfo[2]);
        }

        $result = $stmt->get_result();

        $stmt->close();
        if ($result->num_rows == 1){
            return true;
        };

        return false;     
    }

    public function getStaffs() {
        $sql = "SELECT * FROM staffs";
        $stmt = $this->link->prepare($sql);
        $status = $stmt->execute();
        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not retrieve staffs: " . $errorInfo[2]);
        }

        $staffs = array();
        $row = $stmt->fetch();
        while ($row != null) {
            $id = $row['id'];
            $name = $row['name'];
            $email = $row['email'];
            $role = $row['role'];
            $password = $row['password'];

            $staff = new Staff($id, $name, $email, $role, $password);
            $staffs[$id] = $staff;

            $row = $stmt->fetch();
        }
        return $staffs;
    }
}

?>

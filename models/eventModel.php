<?php

// require_once('../classes/event.php');

class EventModel {
    private $link;
    
    public function __construct($connection) {
        $this->link = $connection;
    }

    public function createEvent($event) {
        if (!isset($event)) {
            throw new Exception("Client object required");
        }
        $sql = "INSERT INTO events (title, description, venue, date, package_id, cost, client_id, staff_id) VALUES (?,?,?,?,?,?,?,?)";

        $title = $event->getTitle();
        $description = $event->getDescription();
        $venue = $event->getVenue();
        $package_id = $event->getPackageId();
        $date = $event->getDate();
        $cost = $event->getCost();
        $client_id = $event->getClientId();
        $staff_id = $event->getStaffId();

        $stmt = $this->link->prepare($sql);
        $stmt->bind_param('sssssisii',$title,$description, $venue, $date,$package_id, $cost,$client_id,$staff_id);
        $status = $stmt->execute();

        if ($status != true) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Could not save Client: " . $errorInfo[2]);
        }

        $id = $this->link->insert_id;
        
        return $id;
    }
}

?>

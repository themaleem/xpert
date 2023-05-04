<?php
    class Event {
        private $id;
        private $title;
        private $description;
        private $venue;
        private $date;
        private $package_id;
        private $cost;
        private $client_id;
        private $staff_id;


        public function __construct($id, $title, $description, $venue, $date, $package_id, $cost, $client_id, $staff_id) {
            $this->id = $id;
            $this->title = $title;
            $this->description = $description;
            $this->venue = $venue;
            $this->date = $date;
            $this->cost = $cost;
            $this->package_id = $package_id;
            $this->client_id = $client_id;
            $this->staff_id = $staff_id;
        }


        public function getId() { return $this->id; }
        public function setId($value) { return $this->id=$value; }
        public function getTitle() { return $this->title; }
        public function getCost() { return $this->cost; }
        public function getDescription() { return $this->description; }
        public function getDate() { return $this->date; }
        
        public function getClientId() { return $this->client_id; }
        public function getPackageId() { return $this->package_id; }
        public function getStaffId() { return $this->staff_id; }
        public function getVenue() { return $this->venue; }
    }
?>
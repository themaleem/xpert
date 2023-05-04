<?php
    class Package {
        private $id;
        private $name;
        private $price;
        private $event_type;
        private $description;
        private $client_id;


        public function __construct($id, $name, $price, $event_type, $description, $client_id) {
            $this->id = $id;
            $this->name = $name;
            $this->price = $price;
            $this->event_type = $event_type;
            $this->description = $description;
            $this->client_id = $client_id;
            
            
        }

        public function getId() { return $this->id; }
        public function setId($value) {  $this->id= $value; }
        public function getName() { return $this->name; }
        public function getPrice() { return $this->price; }
        public function getClientId() { return $this->client_id; }
        public function getEventType() { return $this->event_type; }
        public function getDescription() { return $this->description; }
    }
?>
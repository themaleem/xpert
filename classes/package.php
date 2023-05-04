<?php
    class Package {
        private $id;
        private $name;
        private $price;
        private $event_type;
        private $description;


        public function __construct($id, $name, $price, $event_type, $description) {
            $this->id = $id;
            $this->name = $name;
            $this->price = $price;
            $this->event_type = $event_type;
            $this->description = $description;
            
            
        }

        public function getId() { return $this->id; }
        public function getName() { return $this->name; }
        public function getPrice() { return $this->price; }
        public function getEventType() { return $this->event_type; }
        public function getDescription() { return $this->description; }
    }
?>
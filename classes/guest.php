<?php
    class Guest {
        private $id;
        private $name;
        private $email;
        private $event_id;
        


        public function __construct($id, $name, $email, $event_id) {
            $this->id = $id;
            $this->name = $name;
            $this->email = $email;
            $this->event_id = $event_id;
            
        }

        public function getId() { return $this->id; }
        public function getName() { return $this->name; }
        public function getEmail() { return $this->email; }
        public function getEventId() { return $this->event_id; }
    }
?>
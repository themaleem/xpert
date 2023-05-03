<?php
    class Invitation {
        private $client_id;
        private $guest_id;

        private $body;


        public function __construct($client_id, $guest_id, $body) {
            $this->client_id = $client_id;
            $this->guest_id = $guest_id;
            $this->body = $body;
            
            
        }

        public function getClientId() { return $this->client_id; }
        public function getMessageBody() { return $this->body; }
        public function getGuestId() { return $this->guest_id; }
    }
?>
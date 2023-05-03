<?php
    class WorkflowNote {
        private $id;
        private $message;
        private $event_id;
        private $created_at;
    

    public function __construct($id, $message, $event_id, $created_at) {
        $this->id = $id;
        $this->message = $message;
        $this->event_id = $event_id;
        $this->created_at = $created_at;
    }

    public function getId() { return $this->id; }
    public function getMessage() { return $this->message; }
    public function getCreatedAt() { return $this->created_at; }
    public function getEventId() { return $this->event_id; }

    }

?>
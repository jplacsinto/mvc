<?php
class Gen_model extends Model{

    public function __construct(){
        parent::__construct();
    }

    public function getUsers(){
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', 2);

        return $this->db->results();
    }
}
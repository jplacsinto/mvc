<?php
class Login_model extends Model{

    function __construct(){
        parent::__construct();
    }

    public function run_login($username, $password){
        if(!empty($username) && !empty($password)){
            $this->db->query('SELECT * FROM users WHERE login = :username AND password = :password');
            $this->db->bind(':username', $username);
            $this->db->bind(':password', Hash::create('sha1', $password, HASH_KEY));

            return $result = $this->db->single();
        }
    }
}
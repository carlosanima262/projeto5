<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {
    public function __construct(){
        parent::__construct();
    }
    public function get_usuario_by_email($email){
        $this->db->where('email', $email);
        $query = $this->db->get('usuarios');
        return $query->row();        
    }
}
    
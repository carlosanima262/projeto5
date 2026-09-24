<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medico_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    private function set_usuario_auditoria() {
        $user_id = $this->session->userdata('user_id') ?: $this->session->userdata('id');
        if ($user_id) {
            $this->db->query("SELECT set_config('app.current_user_id', ?, false)", array((string)$user_id));
        }
    }

    public function get_all($busca = null) {
        if ($busca) {
            $this->db->group_start();
            $this->db->like('nome', $busca);
            $this->db->or_like('crm', $busca);
            $this->db->group_end();
        }
        $this->db->order_by('id', 'DESC');
        return $this->db->get('medicos')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('medicos', array('id' => $id))->row();
    }

    public function insert($data) {
        $this->set_usuario_auditoria();
        return $this->db->insert('medicos', $data);
    }

    public function update($id, $data) {
        $this->set_usuario_auditoria();
        $this->db->where('id', $id);
        return $this->db->update('medicos', $data);
    }

    public function delete($id) {
        $this->set_usuario_auditoria();
        $this->db->where('id', $id);
        return $this->db->delete('medicos');
    }

    public function get_auditoria() {
        $this->db->select('auditoria_medicos.*, usuarios.nome as usuario_nome, usuarios.email as usuario_email');
        $this->db->from('auditoria_medicos');
        $this->db->join('usuarios', 'usuarios.id = auditoria_medicos.usuario_id', 'left');
        $this->db->order_by('auditoria_medicos.data_hora', 'DESC');
        return $this->db->get()->result();
    }
}
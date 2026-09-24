<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Garante o acesso à base de dados
        $this->load->model('Usuario_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            redirect('medicos');
        }
        $this->load->view('login');
    }

    public function autenticar() {
        $email = $this->input->post('email');
        $senha = $this->input->post('senha');

        $usuario = $this->Usuario_model->get_usuario_by_email($email);

        if ($usuario && password_verify($senha, $usuario->senha)) {
            $user_data = array(
                'user_id'   => $usuario->id,
                'nome'      => $usuario->nome,
                'email'     => $usuario->email,
                'logged_in' => TRUE
            );
            $this->session->set_userdata($user_data);
            redirect('medicos');
        } else {
            $this->session->set_flashdata('error', 'E-mail ou senha incorretos.');
            redirect('login');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }

    // MÉTODO DE DIAGNÓSTICO E REPARAÇÃO AUTOMÁTICA
    public function testar() {
        $hash = password_hash('123456', PASSWORD_DEFAULT);
        
        $usuario = $this->db->get_where('usuarios', array('email' => 'admin@admin.com'))->row();
        
        if (!$usuario) {
            // Cria o utilizador se ele não existir no PostgreSQL
            $this->db->insert('usuarios', array(
                'nome' => 'Administrador',
                'email' => 'admin@admin.com',
                'senha' => $hash
            ));
            echo "<p style='color: green;'>✅ Utilizador <strong>admin@admin.com</strong> criado na base de dados!</p>";
        } else {
            // Atualiza a palavra-passe se já existir
            $this->db->where('email', 'admin@admin.com');
            $this->db->update('usuarios', array('senha' => $hash));
            echo "<p style='color: blue;'>🔄 Palavra-passe do utilizador <strong>admin@admin.com</strong> redefinida no PostgreSQL!</p>";
        }

        // Testa a verificação da hash no PHP
        $user_check = $this->db->get_where('usuarios', array('email' => 'admin@admin.com'))->row();
        if ($user_check && password_verify('123456', $user_check->senha)) {
            echo "<h3>🎉 TUDO PRONTO!</h3>";
            echo "<p>A palavra-passe <strong>123456</strong> foi verificada com sucesso na base de dados.</p>";
            echo "<p><a href='" . site_url('login') . "'>Clique aqui para ir para o Login e entrar</a></p>";
        } else {
            echo "<p style='color: red;'>❌ Erro ao validar a hash na base de dados.</p>";
        }
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medicos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Medico_model');
        $this->load->library(array('session', 'form_validation'));
        $this->load->helper(array('url', 'form'));

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index() {
        $busca = $this->input->get('busca');
        $data['medicos'] = $this->Medico_model->get_all($busca);
        $data['busca'] = $busca;
        $this->load->view('medicos/index', $data);
    }

    public function create() {
        $this->load->view('medicos/create');
    }

    public function store() {
        // Regras de validação do servidor (Etapa 3)
        $this->form_validation->set_rules('nome', 'Nome completo', 'required|trim');
        $this->form_validation->set_rules('crm', 'CRM', 'required|trim|is_unique[medicos.crm]', array(
            'is_unique' => 'Este CRM já está cadastrado no sistema.'
        ));
        $this->form_validation->set_rules('especialidade', 'Especialidade', 'required|trim');
        $this->form_validation->set_rules('email', 'E-mail', 'valid_email|trim');
        $this->form_validation->set_rules('situacao', 'Situação', 'required|in_list[ativo,inativo]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('medicos/create');
        } else {
            $data = array(
                'nome'          => $this->input->post('nome'),
                'crm'           => $this->input->post('crm'),
                'especialidade' => $this->input->post('especialidade'),
                'cpf'           => $this->input->post('cpf'),
                'telefone'      => $this->input->post('telefone'),
                'email'         => $this->input->post('email'),
                'situacao'      => $this->input->post('situacao')
            );

            $this->Medico_model->insert($data);
            $this->session->set_flashdata('sucesso', 'Médico cadastrado com sucesso!');
            redirect('medicos');
        }
    }

    public function edit($id) {
        $data['medico'] = $this->Medico_model->get_by_id($id);
        if (!$data['medico']) {
            show_404();
        }
        $this->load->view('medicos/edit', $data);
    }

    public function update($id) {
        $medico_atual = $this->Medico_model->get_by_id($id);
        if (!$medico_atual) {
            show_404();
        }

        $this->form_validation->set_rules('nome', 'Nome completo', 'required|trim');
        
        // Se o CRM mudou, valida se o novo é único
        if ($this->input->post('crm') != $medico_atual->crm) {
            $this->form_validation->set_rules('crm', 'CRM', 'required|trim|is_unique[medicos.crm]', array(
                'is_unique' => 'Este CRM já pertence a outro médico.'
            ));
        } else {
            $this->form_validation->set_rules('crm', 'CRM', 'required|trim');
        }

        $this->form_validation->set_rules('especialidade', 'Especialidade', 'required|trim');
        $this->form_validation->set_rules('email', 'E-mail', 'valid_email|trim');
        $this->form_validation->set_rules('situacao', 'Situação', 'required|in_list[ativo,inativo]');

        if ($this->form_validation->run() == FALSE) {
            $data['medico'] = $medico_atual;
            $this->load->view('medicos/edit', $data);
        } else {
            $data = array(
                'nome'          => $this->input->post('nome'),
                'crm'           => $this->input->post('crm'),
                'especialidade' => $this->input->post('especialidade'),
                'cpf'           => $this->input->post('cpf'),
                'telefone'      => $this->input->post('telefone'),
                'email'         => $this->input->post('email'),
                'situacao'      => $this->input->post('situacao')
            );

            $this->Medico_model->update($id, $data);
            $this->session->set_flashdata('sucesso', 'Cadastro do médico atualizado com sucesso!');
            redirect('medicos');
        }
    }

    public function delete($id) {
        $this->Medico_model->delete($id);
        $this->session->set_flashdata('sucesso', 'Médico excluído com sucesso!');
        redirect('medicos');
    }

    public function auditoria() {
        $data['auditorias'] = $this->Medico_model->get_auditoria();
        $this->load->view('medicos/auditoria', $data);
    }
}
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Documents extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("document_model");
        $this->load->library('form_validation');
        $this->load->model("user_model");
		if($this->user_model->isNotLogin()) redirect(site_url('admin/login'));
    }

    public function index()
    {
        if($this->user_model->isRole()){
            $data["documents"] = $this->document_model->getAll();
            $this->load->view("admin/document/list", $data);
        }else{
            $user_id = $this->session->userdata('user_id');
            $data["documents"] = $this->document_model->getByCustomer($user_id);
            $this->load->view("admin/document/list", $data);
        }

    }

    public function add()
    {
        $document = $this->document_model;
        $validation = $this->form_validation;
        $validation->set_rules($document->rules());

        if ($validation->run()) {
            $document->save();
            $this->session->set_flashdata('success', 'Berhasil disimpan');
        }
        $this->load->view("admin/document/new_form");
    }

    public function edit($id = null)
    {
        // $userid = $this->session->userdata('user_id');
        // if($this->user_model->isRole()){        

        if (!isset($id)) redirect('admin/documents');
       
        $document = $this->document_model;
        $validation = $this->form_validation;
        $validation->set_rules($document->rules());

        if ($validation->run()) {
            $document->update();
            $this->session->set_flashdata('success', 'Berhasil disimpan');
        }else{
            $this->session->set_flashdata('failed', 'Data gagal disimpan');
        }

        $data["document"] = $document->getById($id);
        if (!$data["document"]) show_404();
        
        $this->load->view("admin/document/edit_form", $data);

        // }else{
        //     redirect(site_url('admin'));
        // }

    }

    public function delete($id=null)
    {
        // if($this->user_model->isRole()){

        if (!isset($id)) show_404();
        
        if ($this->document_model->delete($id)) {
            redirect(site_url('admin/documents'));
        }

        // }else{
        //     redirect(site_url('admin'));
        // }
    }
}

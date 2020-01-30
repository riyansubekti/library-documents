<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Document_model extends CI_Model
{
    private $_table = "documents";

    public $document_id;
    public $user_id;
    public $name;
    public $category;
    public $document = "default.docx";
    public $description;

    public function rules()
    {
        return [
            ['field' => 'name',
            'label' => 'Name',
            'rules' => 'required'],
            
            ['field' => 'description',
            'label' => 'Description',
            'rules' => 'required']
        ];
    }

    public function getAll()
    {
        return $this->db->get($this->_table)->result();
    }

    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["document_id" => $id])->row();
    }

    public function getByIdCustomer($user_id)
    {
        return $this->db->get_where($this->_table, ["user_id" => $user_id])->row();
    }

    public function getByCustomer($user_id)
    {
        return $this->db->get_where($this->_table, ["user_id" => $user_id])->result();
    }

    public function save()
    {
        $post = $this->input->post();        
        $this->user_id = $this->session->userdata('user_id');
        $this->name = $post["name"];
        $this->category = $post["category"];
        $this->document = $this->_uploadImage();
        $this->description = $post["description"];
        $this->db->insert($this->_table, $this);
    }

    public function update()
    {
        $post = $this->input->post();
        $this->document_id = $post["id"];        
        if ($post["user_id"] ==  $this->session->userdata('user_id')){
            $this->user_id = $this->session->userdata('user_id');
        }else if ($this->user_model->isRole()){
            $this->user_id = $post["user_id"];
        }else{
            redirect(site_url('admin'));
        }
        $this->name = $post["name"];
		$this->category = $post["category"];
		
		if (!empty($_FILES["document"]["name"])) {
            $this->document = $this->_uploadImage();
        } else {
            $this->document = $post["old_document"];
		}

        $this->description = $post["description"];
        $this->db->update($this->_table, $this, array('document_id' => $post['id']));
    }

    public function delete($id)
    {
        $this->_deleteImage($id);
        $user_id = $this->session->userdata('user_id');
        return $this->db->delete($this->_table, array("document_id" => $id, "user_id" => $user_id));
	}
	
	private function _uploadImage()
	{
        $config['upload_path']          = './upload/documents/';
        $config['allowed_types']        = 'docx|doc|pdf|ppt|pptx';
		$config['file_name']            = $this->name;
		$config['overwrite']			= true;
		$config['max_size']             = 10240; // 10 MB

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('document')) {
			return $this->upload->data("file_name");
		}
		
		return "default.docx";
	}

	private function _deleteImage($id)
	{
		$documents = $this->getById($id);
		if ($documents->document != "default.docx") {
			$filename = explode(".", $documents->document)[0];
			return array_map('unlink', glob(FCPATH."upload/documents/$filename.*"));
		}
	}

}

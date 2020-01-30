<?php

class User_model extends CI_Model
{
    private $_table = "users";

    public $user_id;
    public $username;
    public $full_name;
    public $password;
    public $email;
    public $role;

    public function rules()
    {
        return [
            ['field' => 'full_name',
            'label' => 'Name',
            'rules' => 'required'],
			
            ['field' => 'password',
            'label' => 'Password',
            'rules' => 'required|min_length[3]'],
            
            ['field' => 'email',
            'label' => 'Email',
            'rules' => 'required|valid_email']
        ];
    }

    public function getAll()
    {
        return $this->db->get($this->_table)->result();
    }
    
    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["user_id" => $id])->row();
    }

    public function save()
    {
        $post = $this->input->post();
        $this->full_name = $post["full_name"];
        $this->username = $post["username"];
        $this->email = $post["email"];
        $this->password = password_hash($post["password"], PASSWORD_DEFAULT);
        $this->role = $post["role"] ?? "customer";
        $this->db->insert($this->_table, $this);
    }

    public function update()
    {
        $post = $this->input->post();
        $this->user_id = $post["id"];
        $this->full_name = $post["full_name"];
        $this->username = $post["username"];
        $this->password = password_hash($post["password"], PASSWORD_DEFAULT);
        $this->email = $post["email"];
        $this->role = $post["role"];
        $this->db->update($this->_table, $this, array('user_id' => $post['id']));
    }

    public function delete($id)
    {
        return $this->db->delete($this->_table, array("user_id" => $id));
	}

    public function doLogin(){
		$post = $this->input->post();

        $this->db->where('email', $post["email"])
                ->or_where('username', $post["email"]);
        $user = $this->db->get($this->_table)->row();

        if($user){
            $isPasswordTrue = password_verify($post["password"], $user->password);
            $isAdmin = $user->role == "admin";
            $isCustomer = $user->role == "customer";
            if($isPasswordTrue){ 
                $this->session->set_userdata(['username' => $user->username, 'user_id' => $user->user_id, 
                'full_name' => $user->full_name, 'email' => $user->email, 'role' => $user->role]);
                $this->_updateLastLogin($user->user_id);
                return true;
            }
		}
		return false;
    }

    public function isNotLogin(){
        return $this->session->userdata('username') === null;
    }

    public function isLogin(){
        return $this->session->userdata('username') !== null;
    }

    public function isRole(){
        return $this->session->userdata('role') == 'admin';
    }

    public function isRoleCustomer(){
        return $this->session->userdata('role') == 'customer';
    }

    private function _updateLastLogin($user_id){
        $sql = "UPDATE {$this->_table} SET last_login=now() WHERE user_id={$user_id}";
        $this->db->query($sql);
    }

}
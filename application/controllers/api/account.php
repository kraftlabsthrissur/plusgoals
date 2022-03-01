<?php
defined("BASEPATH") OR exit("NO direct script access allowed");

class account extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        
    }

    public function signin()
    {
       // $this->form_validation->set_rules('username','Username','required|xss_clean');
      //  $this->form_validation->set_rules('password','Password','required|xss_clean');
        $this->form_validation->set_rules('username','Username','required');
        $this->form_validation->set_rules('password','Password','required');
        $this->form_validation->set_error_delimiters('','');

        if($this->form_validation->run()===FALSE)
        {
            $response['status']="error";
            $response['message']=form_error('username')." ".form_error('password');
            $response['http_code']=401;

            echo json_encode($response);
        }

        else{

            $result=$this->db->get_where('usermaster',array('umUsername'=>$this->input->post('username'),'umPassword'=>$this->input->post('password')));

            if($result->num_rows()>0)
            {
                $user=$result->row();

                $data=array(
                    'access_token'=>rand().rand().date('Y-M-d')."-".date('H-i-s')
                );

                $this->db->set($data);
                $this->db->where('umId',$user->umId);
                $this->db->update('usermaster',$data);

                $access_token=$this->db->get_where('usermaster',array('umId'=>$user->umId))->row()->access_token;

                $response['status']="success";
                $response['message']="";
                $response['access_token']=$access_token;
                $response['http_code']=200;

               echo json_encode($response);
            }

            else{

                $response['status']="error";
                $response['message']="Incorrect credentials";
                $response['http_code']=200;

                echo json_encode($response);
            }
        }
    }
}


?>
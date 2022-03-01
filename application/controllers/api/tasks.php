<?php

defined("BASEPATH") or exit("No direct script access allowed");

require APPPATH . "controllers/api/panel.php";

class tasks extends panel
{

    public function __construct()
    {
        parent::__construct();
    }

    public function test()
    {
        print_r($this->user);
    }

    public function todays_tasks_due()
    {
        $this->db->select("user_tasks.task_id,user_tasks.user_task_id,usermaster.umFirstName,usermaster.umLastName,tasks.task_name,DATE_FORMAT(user_tasks.due_date,('%d %M %Y')) as due_date,user_tasks.perc_of_completion,tasks.priority,user_tasks.group_ref,user_tasks.due_date as task_due_date");

        $this->db->join('usermaster', 'usermaster.umId=user_tasks.user_id');

        $this->db->join('tasks', 'tasks.task_id=user_tasks.task_id');

        $tasks = $this->db->get_where('user_tasks', array('user_tasks.assigned_user_id' => $this->user->umId, 'user_tasks.status !=' => 'Completed', 'user_tasks.perc_of_completion <' => 100,'tasks.is_active' => 1))->result();

        $response['status'] = "success";

        $response['data'] = $tasks;
        //$response['data'] = print_r($this->db->last_query());

        $response['http_code'] = 200;

        echo json_encode($response);
    }

   public function tasks_assigned_by_me()
    {
        $this->db->select("user_tasks.task_id,user_tasks.user_task_id,usermaster.umFirstName,usermaster.umLastName,tasks.task_name,DATE_FORMAT(user_tasks.due_date,('%d %M %Y')) as due_date,user_tasks.perc_of_completion,tasks.priority,user_tasks.group_ref,user_tasks.due_date as task_due_date");

        $this->db->join('usermaster', 'usermaster.umId=user_tasks.assigned_user_id');

        $this->db->join('tasks', 'tasks.task_id=user_tasks.task_id');

        $tasks = $this->db->get_where('user_tasks', array('user_tasks.user_id' => $this->user->umId, 'user_tasks.status !=' => 'Completed', 'user_tasks.perc_of_completion <' => 100))->result();

        $response['status'] = "success";

        $response['data'] = $tasks;

        $response['http_code'] = 200;

        echo json_encode($response);
    }

    public function task_details()
    {
        $this->form_validation->set_rules('task_id', 'Task Id', 'required|numeric');
        $this->form_validation->set_rules('group_ref', 'Group Ref', 'required|numeric');
        $this->form_validation->set_error_delimiters('', '');



        if ($this->form_validation->run() === FALSE) {

            $response['status'] = "error";
            $response['message'] = form_error('task_id');
            $response['data'] = NULL;
            $response['http_code'] = 404;

            echo json_encode($response);
        } else {

            try {



                $task_check = $this->db->get_where('tasks', array('task_id' => $this->input->post('task_id'), 'is_active' => 1));

                if ($task_check->num_rows() > 0) {

                    $task = $task_check->row();

                    $this->db->select('attached_files.file_id,
                                            attached_files.file_name,
                                            attached_files.file_extension,
                                            attached_files.file_type,
                                            attached_files.file_path,
                                            attached_files.upload_time');
                    $this->db->join('attached_files', 'task_attachments.attachment_id=attached_files.file_id');
                    $task->task_attachments = $this->db->get_where('task_attachments', array('task_attachments.task_id' => $this->input->post('task_id'), 'task_comment_id' => 0))->result();
                    $this->db->select("usermaster.umFirstName,
                                        usermaster.umId as user_id,
                                        usermaster.umUserCode,
                                        usermaster.umUserName,
                                        usermaster.umLastName,
                                        task_comments.comment,
                                        task_comments.task_comment_id,
                                        task_comments.group_ref,
                                        DATE_FORMAT(task_comments.date,('%d %M %Y  %r')) as created_at");
                    $this->db->join('usermaster', 'task_comments.user_id=usermaster.umId');

                    $task->task_comments = $this->db->get_where('task_comments', array('task_comments.task_id' => $this->input->post('task_id'),'task_comments.group_ref' => $this->input->post('group_ref')))->result();
//print_r($this->db->last_query());
//die();
                    foreach ($task->task_comments as $key => $comment) {
                        $this->db->select('attached_files.file_id,
                                            attached_files.file_name,
                                            attached_files.file_extension,
                                            attached_files.file_type,
                                            attached_files.file_path,
                                            attached_files.upload_time');
                        $this->db->join('attached_files', 'task_attachments.attachment_id=attached_files.file_id');
                        $task->task_comments[$key]->files = $this->db->get_where('task_attachments', array('task_attachments.task_id' => $this->input->post('task_id'), 'task_comment_id' => $comment->task_comment_id))->result();
                    }



                    $response['status'] = "success";
                    $response['message'] = "";
                    $response['data'] = $task;
                    $response['http_code'] = 200;

                    echo json_encode($response);
                } else {

                    $response['status'] = "error";
                    $resposne['message'] = "Task not found";
                    $response['data'] = NULL;
                    $response['http_code'] = 200;

                    echo json_encode($response);
                }
            } catch (\Exception $e) {
                $response['status'] = "error";
                $response['message'] = $e->getMessage();
                $response['data'] = NULL;
                $response['http_code'] = 500;

                echo json_encode($response);
            }
        }
    }

    public function add_comment_to_task()
    {
        $this->form_validation->set_rules('task_id', 'Task Id', 'required|numeric');
        $this->form_validation->set_rules('group_ref', 'Group Ref', 'required|numeric');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() === FALSE) {
            $response['status'] = "error";
            $response['message'] = validation_errors();
            $response['data'] = NULL;
            $response['http_code'] = 404;

            echo json_encode($response);
        } else {

            try {
                $user_task = $this->db->get_where('user_tasks',array('task_id' => $this->input->post('task_id'), 'group_ref' => $this->input->post('group_ref')))->row();
                $task = $this->db->get_where('tasks', array('task_id' => $this->input->post('task_id')))->row();

                $no_of_hours = ($this->input->post('no_of_hours') != "") ? $this->input->post('no_of_hours') : 0;

                $data = array(
                    'task_id' => $this->input->post('task_id'),
                    'group_ref' => $user_task->group_ref,
                    'user_id' => $this->user->umId,
                    'is_active' => 1,
                    'comment' => $this->input->post('comment'),
                    'perc_of_completion' => $this->input->post('perc_of_completion'),
                    'status' => $user_task->status,
                    'date' => date('Y-m-d H:i:s'),
                    'rating' => $this->input->post('rating'),
                    'no_of_hours' => $no_of_hours,
                    'approved' => 0,
                    'rejected' => 0,
                    'approved_date' => '0000-00-00',
                    'rejected_date' => '0000-00-00',
                    'approved_by' => 0,
                    'rejected_by' => 0
                );



                $this->db->insert('task_comments', $data);

                $task_comment_id = $this->db->insert_id();

                if ($task_comment_id > 0) {

                    if ($this->input->post('perc_of_completion') == 100) {
                        $status = "Completed";
                    } else if ($this->input->post('perc_of_completion') == 0) {
                        $status = "Not Done";
                    } else {

                        $status = "Partial";
                    }

                    $update_data = array('perc_of_completion' => $this->input->post('perc_of_completion'), 'status' => $status);
                    $this->db->set($update_data);
                    $this->db->where('user_task_id', $user_task->user_task_id);
                    $this->db->update('user_tasks', $update_data);
                    if (isset($_FILES['file'])) {


                        $files = $_FILES;

                        $i = 0;
                        foreach ($_FILES['file']['name'] as $key => $file) {

                            $_FILES['file']['name'] = $files['file']['name'][$i];
                            $_FILES['file']['type'] = $files['file']['type'][$i];
                            $_FILES['file']['tmp_name'] = $files['file']['tmp_name'][$i];
                            $_FILES['file']['error'] = $files['file']['error'][$i];
                            $_FILES['file']['size'] = $files['file']['size'][$i];

                            $path = './uploads/' . date('Y') . '/' . date('m') . '/' . date('d');

                            if (!file_exists($path)) {

                                mkdir($path, 0777, true);
                            }

                            $config = array(
                                'allowed_types' => "doc|docx|pdf|xls|xlsx|jpg|jpeg|mp3|mp4|m4a|aac|wav|ogg|aiff|3gp",
                                'upload_path' => $path,
                                'file_name' => rand(1000, 999) . date('Y-M-d') . "-" . date('H-i-s')
                            );

                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);



                            if ($this->upload->do_upload('file')) {
                                $upload_data = $this->upload->data();

                                $upload_path = str_replace("./uploads/", "/uploads/", $path);
                                $attachment_data = array(
                                    'file_name' => $upload_data['file_name'],
                                    'file_extension' => $upload_data['file_ext'],
                                    'file_size' => $upload_data['file_size'],
                                    'file_type' => $upload_data['file_type'],
                                    'file_path' => $upload_path,
                                    'upload_time' => date('Y-m-d')
                                );

                                $this->db->insert('attached_files', $attachment_data);

                                $attached_file_id = $this->db->insert_id();

                                $task_attachment_data = array(
                                    'task_id' => $this->input->post('task_id'),
                                    'attachment_id' => $attached_file_id,
                                    'is_result' => 1,
                                    'task_comment_id' => $task_comment_id
                                );

                                $this->db->insert('task_attachments', $task_attachment_data);
                            } else {

                                $response['error_message'] = $this->upload->display_errors();
                            }


                            $i++;
                        }
                    }
		    
	//test
		    $up_data = array('status' => $status, 'perc_of_completion' => $this->input->post('perc_of_completion'),'task_comment' => $this->input->post('comment'),'task_comment_id' => $task_comment_id, 'task_comment_date' => date('Y-m-d H:i:s'),'active_comment' => 1);
                    $this->db->set($update_data);
                    $this->db->where(array('task_id' => $this->input->post('task_id'), 'group_ref' => $this->input->post('group_ref')));
                    $this->db->update('user_tasks', $up_data);

		//test

                    $this->db->distinct();
                    $this->db->select('assigned_user_id','group_ref');
                    $other_candidates = $this->db->get_where('user_tasks', array('task_id' => $this->input->post('task_id'), 'assigned_user_id !=' => $this->user->umId))->result();
                    $task_details = array('task_id' => $this->input->post('task_id'), 'group_ref' => $this->input->post('group_ref'),'task_name'=>$task->task_name,'perc_of_completion'=>$this->input->post('perc_of_completion'));

                    if(isset($_FILES['file']))
                    {
                        $comment="File added";
                    }
                    else if($this->input->post('comment')!="")
                    {
                        $comment=$this->user->umFirstName . " commented as " . $this->input->post('comment');
                    }

                    else{

                        $comment=$this->user->umFirstName." added an empty text comment"; 
                    }
                    $this->sendPushnotification($comment, $this->user->umFirstName." added to " . $task->task_name, $other_candidates, $task_details);

                    $response['status'] = "success";
                    $response['message'] = "Task comment added";
                    $response['data'] = NULL;
                    $response['http_code'] = 200;

                    echo json_encode($response);
                } else {

                    $response['status'] = "error";
                    $response['message'] = "Task comment not added";
                    $response['data'] = NULL;
                    $response['http_code'] = 200;

                    echo json_encode($response);
                }
            } catch (\Exception $e) {
                $response['status'] = "error";
                $response['message'] = $e->getMessage();
                $response['data'] = NULL;
                $response['http_code'] = 500;

                echo json_encode($response);
            }
        }
    }

    public function get_subordinate_users($id) {
        $this->db->select('group_concat(distinct hm.user_id) as user_id');
        $this->db->from('hierarchy_mapping hm');
        $this->db->where('hm.parent_user_id', $id);
        $query = $this->db->get();

    //    echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result;
        }
        return FALSE;
    }
    
    public function task_activity_report()
    {

        $this->form_validation->set_rules('comment_date', 'Comment Date', 'required');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() === FALSE) {

            $response['status'] = "error";
            $response['message'] = form_error('comment_date');
            $response['data'] = NULL;
            $response['http_code'] = 404;

            echo json_encode($response);
        } else {
        
            $search = '';

        if ($this->user->umIsHOUser <= 1) { 
            $data['subordinate_users'] = $this->get_subordinate_users($this->user->umId);
            $subordinate_users = $data['subordinate_users']['user_id'];
            if ($subordinate_users == null) {
                $subordinate_users = $this->user->umId;
            } else {
                $subordinate_users = $this->user->umId . ',' . $subordinate_users;
            }
                // $search .= "u.umId in (" . $subordinate_users . ") AND ";
               $search .="AND  (user_tasks.user_id in ( $subordinate_users ) OR  user_tasks.assigned_user_id in ( $subordinate_users ) )";
         }

        $this->db->select('tasks.task_id, tasks.priority,user_tasks.group_ref, user_tasks.created_user_name assigned_by, DATE_FORMAT(user_tasks.task_comment_date, ("%d-%m-%Y %h:%i %p"))as date, 
        user_tasks.assigned_user_name assigned_to, tasks.task_name, uam.umusername as name, date(tasks.created_date) created_date, IF(user_tasks.status = " ", ("Not Done"), (user_tasks.status))as status, 
        user_tasks.perc_of_completion,tasks.created_by,user_tasks.assigned_user_id ,tasks.due_date,user_tasks.approved_status, usermaster.umusername as approved_by, um.umusername as rejected_by, user_tasks.task_comment as comment,
        COALESCE(user_tasks.task_date, (tasks.task_date)) task_date, COALESCE(user_tasks.due_date,(tasks.due_date)) due_date');

        $this->db->join('user_tasks', 'tasks.task_id = user_tasks.task_id AND tasks.is_active=1','left');
        
        $this->db->join('usermaster', 'user_tasks.approved_by = usermaster.umId','left');

        $this->db->join('usermaster um', 'user_tasks.rejected_by = um.umId','left');

        $this->db->join('task_comments', 'user_tasks.task_comment_id = task_comments.task_comment_id','left');

        $this->db->join('usermaster uam', 'task_comments.user_id = uam.umId','left');

//$this->db->group_by('t.task_id,ut.group_ref');
        $group = 'group by tasks.task_id,user_tasks.group_ref order by user_tasks.task_comment_id desc';

        $task_report = $this->db->get_where('tasks',"DATE_FORMAT(user_tasks.task_comment_date,('%Y-%m-%d')) = '" . $this->input->post('comment_date') . "'".$search. $group)->result();

        $response['status'] = "success";

        $response['data'] = $task_report;

        //$response['data'] = print_r($this->db->last_query());

        $response['http_code'] = 200;

        echo json_encode($response);
        }
    }
}
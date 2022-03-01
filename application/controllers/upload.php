<?php

class Upload extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'path', 'date'));
        $this->load->helper('xml');
        //$this->load->library('upload');
    }

    function index() {
        //$error = array('error' => ' ' );
        //$this->load->view('productMaster_view', $error);
    }

    function do_upload() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('uploadProduct_view', $error);
        } else {
            $upload_dat = $this->upload->data();
            $path = $upload_dat['full_path'];
            $xmlString = $this->load->file($path, true);
            $type = new SimpleXMLElement($xmlString);
            $dataset = '';
            $format = '%Y-%m-%d %H:%i:%s';
            $time = time();
            $pmProductCode = array();
            $pmProductName = array();
            $pmCategory = array();
            $pmMRP = array();
            $pmDivisionCode = array();
            $pmDescription = array();
            $this->load->model('connection');
            foreach ($type->Product as $rows) {
                $pdCnt = $this->connection->getproductCode($rows['ProductCode']);

                if ($pdCnt->num_rows() < 1) {
                    $pmProductCode[] = $rows['ProductCode'];
                    $pmProductName[] = $rows['ProductName'];
                    $pmCategory[] = $rows['Category'];
                    $pmMRP[] = $rows['MRP'];
                    $pmDivisionCode[] = $rows['DivisionCode'];
                    $pmDescription[] = $rows['Description'];
                }
                //	$data['pmTS']=> mdate($format, $time)
            }
            $data = array('pmProductCode' => $pmProductCode,
                'pmProductName' => $pmProductName,
                'pmCategory' => $pmCategory,
                'pmMRP' => $pmMRP,
                'pmDivisionCode' => $pmDivisionCode,
                'pmDescription' => $pmDescription
            );

            $this->load->model('connection');
            if ($this->connection->addproductDets($data)) {
                $data['methodeType'] = "add";
                $data['module'] = "Product Master";
                $this->load->view('success_view', $data);
            } else {
                $this->load->view('productMaster_view');
            }
        }
    }

}

?>
<?php

class StockManager extends Secure_Controller {

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


    function stockReg() {
        $this->load->view('StockReport.php');
    }

    function getPopUp($type, $id, $value = '') {
        $this->load->model('report_model');
        if ($type == 'all') {
            $data = $this->report_model->toFillStockDeterminer($id);
        } else if ($value != '') {
            $data = $this->report_model->searchStockpopupData($type, $value, $id);
        }
        $response = "";
        if ($data->num_rows() > 0) {
            $isEven = false;
            foreach ($data->result() as $row) {
                if ($isEven) {
                    $response .= "<tr class=\"even\">";
                    $isEven = false;
                } else {
                    $response .= "<tr>";
                    $isEven = true;
                }
                if ($id == 'btnBranch') {
                    $response .= "<td class=\"first\"><input type=\"hidden\" value=\"" . $row->bmBranchID . "\" />" . $row->bmBranchName . "</td>";
                    $response .= "<td class=\"second\">" . $row->bmBranchCode . "</td>";
                } else if ($id == 'btnItems') {
                    $response .= "<td class=\"first\"><input type=\"hidden\" value=\"" . $row->pmProductId . "\" />" . $row->pmProductName . "</td>";
                    $response .= "<td class=\"second\">" . $row->pmProductCode . "</td>";
                } else {
                    $response .= "<td class=\"first\"><input type=\"hidden\" value=\"" . $row->pmProductId . "\" />" . $row->pmCategory . "</td>";
                    $response .= "<td class=\"second\">" . $row->pmProductCode . "</td>";
                }
                $response .= "<td class=\"last\"></td></tr>";
            }
        } else {
            $response = "<tr><td colspan=\"3\">Sorry no result.</td></tr>";
        }
        echo $response;
    }

    function openReportWindow($From, $To) {
        $dates = array();
        $dates['FromDate'] = $From;
        $dates['ToDate'] = $To;
        $dates['head'] = 'StockReport';
        $data['dates'] = $dates;
        $this->load->view('reportfile_view.php', $data);
    }

}

?>

<?php

/**
 * @author Ajith Vp <ajith@kraftlabs.com>
 * @copyright Copyright (c) 2014, Ajith Vp <ajith@kraftlabs.com>
 * @date 10-Jan-2015
 */
class Error1 extends Secure_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function bad_request() {
        $this->load->view('404');
    }

}

<?php

class Login extends CI_Controller
{
  public function index()
  {
    
    //libraries as filters
    /*
    $this->load->library('ViewSessionFalse', array(
      'config' => $this->config,
    ));
    */
    $this->load->library('HttpAccess',
      array(
        'config' => $this->config,
        'allow' => ['GET'],
        'received' => $this->input->server('REQUEST_METHOD'),
        'instance' => $this,
      )
    );
    /*
    //controller function
    $this->load->helper('Login');
    $data_top = array(
      'title' => 'Bienvenido',
      'csss' => index_css($this->config),
      'jss' => index_js($this->config),
      'mensaje' => '',
    );
    $this->load->view('layouts/blank_header', $data_top);
    $this->load->view('login/index');
    $this->load->view('layouts/blank_footer', array());
    */
    echo($this->config->item('csrf')['key']);
    $this->load->view('admin/login/index');
  }
}

?>
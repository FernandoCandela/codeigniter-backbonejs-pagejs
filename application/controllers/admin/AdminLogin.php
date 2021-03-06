<?php

class AdminLogin extends CI_Controller
{
  public function index()
  {
    // load session
    $this->load->library('session');
    // libraries as filters
    $this->load->library('ViewSessionFalse', array(
      'config' => $this->config,
      'session' => $this->session,
    ));
    $this->load->library('HttpAccess',
      array(
        'config' => $this->config,
        'allow' => ['GET'],
        'received' => $this->input->server('REQUEST_METHOD'),
        'instance' => $this,
      )
    );
    // load helpers
    $this->load->helper('admin/Login');
    $this->load->helper('content');
    // get content
    $content = get_content('sp', 'admin_login');
    // controller function
    $data = array(
      'title' => 'Bienvenido',
      'csss' => access_css($this->config),
      'jss' => access_js($this->config),
      'message' => '',
      'message_color' => '',
      'config' => $this->config,
    );
    // render view
    $this->load->view('admin/login', $data);
  }

  public function access()
  {
    // load session
    $this->load->library('session');
    // libraries as filters
    $this->load->library('HttpAccess',
      array(
        'config' => $this->config,
        'allow' => ['POST'],
        'received' => $this->input->server('REQUEST_METHOD'),
        'instance' => $this,
      )
    );
    // controller function
    $user = $this->input->post('user');
    $password = $this->input->post('password');
    if(
      $user == $this->config->item('login')['user'] && 
      $password == $this->config->item('login')['password']
    ){
      // set session
      $this->session->set_userdata(array(
        'user' => $user,
        'state' => true,
        'time' => date('Y-m-d H:i:s'),
      ));
      // go to home???
      header('Location: ' . $this->config->item('base_url') . 'admin');
      exit();
    }else{
      // load helpers
      $this->load->helper('admin/Login');
      // data to view
      $data = array(
        'title' => 'Bienvenido',
        'csss' => access_css($this->config),
        'jss' => access_js($this->config),
        'message' => 'Usuario y/o contraseña no coincide',
        'message_color' => 'text-danger',
        'config' => $this->config,
      );
      // render view
      $this->load->view('admin/login', $data);
    }
  }

  public function view()
  {
    // load session
    $this->load->library('session');
    // libraries as filters
    $this->load->library('HttpAccess',
      array(
        'config' => $this->config,
        'allow' => ['GET'],
        'received' => $this->input->server('REQUEST_METHOD'),
        'instance' => $this,
      )
    );
    //controller function
    if ($this->session->has_userdata('state')) {
      if($this->session->userdata('state') != true){
        echo '<h1>El usuario no se encuentra logueado</h1>';
        exit();
      }else{
        $rpta =
          '<h1>Usuario Logeado</h1><ul><li>' .
          $this->session->userdata('user') . '</li><li>' .
          $this->session->userdata('state') . '</li><li>' .
          $this->session->userdata('time') . '</li></ul>';
        echo $rpta;
      }
    }else{
      echo '<h2>El usuario no se encuentra logueado</h2>';
      exit();
    }
  }

  public function exit()
  {
    // load session
    $this->load->library('session');
    // libraries as filters
    $this->load->library('HttpAccess',
      array(
        'config' => $this->config,
        'allow' => ['GET'],
        'received' => $this->input->server('REQUEST_METHOD'),
        'instance' => $this,
      )
    );
    //controller function
    $this->session->sess_destroy();
    header('Location: ' . $this->config->item('base_url') . 'admin/login');
    exit();
  }
}

?>

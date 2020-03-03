<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HTTPErrors extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
  }
 
  function index()
  {
    // TODO
  }

  function show_404($page='')
  {
    $this->config =& get_config();
    $base_url = $this->config['base_url'];

    // redirect to home page
    header("location: ".$base_url);
    exit;
  }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('cookie');

        $this->session->set_userdata("controlador", "Login");
        $this->session->set_userdata("accio", "index");
    }

    public function index() {
        $this->load->view('vista_login');
        // $this->entrar();
    }

    public function entrar() {
        /*
          $usuari = array(
          "nom" => "TEST",
          "cuiner" => "Y",
          "camarer" => "Y",
          "administrador" => "Y",
          "administrador_usuaris" => "Y",
          );
          $this->session->set_userdata("usuari", $usuari);
          //redirect("Camarer/index");
          //redirect("Administrador_Usuaris/index");
         */

        $user_params = array(
            "nom" => $_POST["nom"],
            "password" => $_POST["password"],
        );

        $this->load->model('Usuari');
        $query = $this->Usuari->get_usuari($user_params);

        if ($query->num_rows() === 1) {

            $this->session->set_userdata("usuari", $query->row_array());

            $u = $query->row_array();

            if ($u["camarer"] == "Y") {
                redirect("Camarer/index");
            } else if ($u["cuiner"] == "Y") {
                redirect("Cuiner/index");
            } else if ($u["administrador"] == "Y") {
                redirect("Administrador/index");
            } else if ($u["administrador_usuaris"] == "Y") {
                redirect("Administrador_Usuaris/index");
            } else {
                $this->index();
            }
        } else {
            $this->index();
        }
    }

    public function sortir() {
        //$this->session->unset_userdata('usuari');
        $this->session->sess_destroy();
        $this->index();
    }

}

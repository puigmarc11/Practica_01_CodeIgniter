<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Administrador_Usuaris extends CI_Controller {

    public function __construct() {
// Call the CI_Model constructor
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('cookie');
        $this->load->helper('form');

        if ($this->session->userdata("usuari")["administrador_usuaris"] == "N" || $this->session->userdata("usuari") == null) {
            $c = $this->session->userdata("controlador");
            $a = $this->session->userdata("accio");
            redirect($c . "/" . $a);
        } else {
            $this->session->set_userdata("controlador", "Administrador_Usuaris");
            $this->session->set_userdata("accio", "index");
        }
    }

    public function index($edicio = false) {

        $data["usuari"] = $this->session->userdata("usuari");

        $this->load->model("Usuari");
        $data["llista_usuaris"] = $this->Usuari->get_all();

        for ($i = 0; $i < count($data["llista_usuaris"]); $i++) {

            if ($data["llista_usuaris"][$i]->id == $this->session->flashdata('id_actualitzar')) {
                $data["llista_usuaris"][$i]->classe = "success";
                $data["llista_usuaris"][$i]->edicio = true;
            } else {
                $data["llista_usuaris"][$i]->classe = "";
                $data["llista_usuaris"][$i]->edicio = false;
            }
        }

        $data["edicio"] = $edicio;

        $this->load->template('vista_admin_usuaris', $data);
    }

    public function edicio($id = null) {

        $id_actualitzar = $this->session->flashdata('id_actualitzar');

        if ($id_actualitzar == null) {

            $this->session->set_flashdata("id_actualitzar", $id);
            $this->index(true);
        } else {


            $this->load->model("Usuari");

            $data = array(
                "id" => $id_actualitzar,
                "nom" => $_POST["nom"],
                "camarer" => isset($_POST["camarer"]) ? "Y" : "N",
                "cuiner" => isset($_POST["cuiner"]) ? "Y" : "N",
                "administrador" => isset($_POST["administrador"]) ? "Y" : "N",
                "administrador_usuaris" => isset($_POST["administrador_usuaris"]) ? "Y" : "N",
                "actiu" => isset($_POST["actiu"]) ? "1" : "0",
            );

            $this->Usuari->modificar_usuari($data);

            $this->session->unset_userdata("id_actualitzar");
            $this->index(false);
        }
    }

    public function crear_usuari() {

        var_dump($_POST);

        $data = array(
            "mail" => $_POST["mail"],
            "nom" => $_POST["nom"],
            "password" => $_POST["password"],
            "camarer" => isset($_POST["camarer"]) ? "Y" : "N",
            "cuiner" => isset($_POST["cuiner"]) ? "Y" : "N",
            "administrador" => isset($_POST["administrador"]) ? "Y" : "N",
            "administrador_usuaris" => isset($_POST["administrador_usuaris"]) ? "Y" : "N",
            "actiu" => "1",
        );

        $this->load->model("Usuari");
        $this->Usuari->crear_usuari($data);

        $this->index();
    }

    public function validar() {

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->database();

        $this->form_validation->set_rules('mail', 'mail', 'required|is_unique[usuari.mail]', array('required' => 'L\'email és obligatori', 'is_unique' => 'Ja existeix aquest compte'));
        $this->form_validation->set_rules('nom', 'nom', 'required', array('required' => 'El nom és obligatori'));
        $this->form_validation->set_rules('password', 'password', 'required', array('required' => 'La contrasenya és oblligatoria'));

        if ($this->form_validation->run() == TRUE) {

            $data = array(
                "mail" => $_POST["mail"],
                "nom" => $_POST["nom"],
                "password" => $_POST["password"],
                "camarer" => isset($_POST["camarer"]) ? "Y" : "N",
                "cuiner" => isset($_POST["cuiner"]) ? "Y" : "N",
                "administrador" => isset($_POST["administrador"]) ? "Y" : "N",
                "administrador_usuaris" => isset($_POST["administrador_usuaris"]) ? "Y" : "N",
                "actiu" => "1",
            );

            $this->load->model("Usuari");
            $this->Usuari->crear_usuari($data);
        }

        $this->index();
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cuiner extends CI_Controller {

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

        if ($this->session->userdata("usuari")["cuiner"] == "N" || $this->session->userdata("usuari") == null) {
            $c = $this->session->userdata("controlador");
            $a = $this->session->userdata("accio");
            redirect($c . "/" . $a);
        } else {
            $this->session->set_userdata("controlador", "Cuiner");
            $this->session->set_userdata("accio", "index");
        }
    }

    public function index($filtre = NULL) {

        $this->load->model("Comanda");
        $this->load->model("Producte");
        $cc = $this->Comanda->get_all_comandes();

        $data["comandes"] = array();
        for ($i = 0; $i < count($cc); $i++) {

            $pc = $this->Producte->get_dades_producte($cc[$i]["producte"]);

            if ($filtre == $pc["categoria"] || $filtre == NULL) {

                $data["comandes"][$i]["producte"] = $pc["nom"] . "";
                $data["comandes"][$i]["categoria"] = $pc["categoria"];

                $data["comandes"][$i]["id"] = $cc[$i]["id"];
                $data["comandes"][$i]["taula"] = $cc[$i]["taula"];
                $data["comandes"][$i]["ordre"] = $cc[$i]["ordre"];
                $data["comandes"][$i]["estat"] = $cc[$i]["estat"];
                $data["comandes"][$i]["quantitat"] = $cc[$i]["quantitat"];
                $data["comandes"][$i]["estat_prod"] = $cc[$i]["estat_prod"];
                $data["comandes"][$i]["id_detall_comanda"] = $cc[$i]["id_detall_comanda"];
            }
        }

        $data["filtre"] = $filtre;
        $data["usuari"] = $this->session->userdata("usuari");

        $this->load->template('vista_cuiner', $data);
    }

    public function filtrar_productes() {

        var_dump($_POST);

        if (isset($_POST["Plat"]) && !isset($_POST["Beguda"])) {
            $this->index("Plat");
        } else if (!isset($_POST["Plat"]) && isset($_POST["Beguda"])) {
            $this->index("Beguda");
        } else {
            $this->index();
        }
    }

    public function cuinar_productes() {

        $this->load->model("Comanda");
        $data = array();

        for ($i = 0; $i < count($_POST['estat_prod']); $i++) {

            $data[] = array(
                "id" => $_POST['id_detall_comanda'][$i],
                "estat_prod" => $_POST['estat_prod'][$i],
            );

            if ($_POST['estat_prod'][$i] == "cuinant") {
                $this->Comanda->modificar_estat_ordre_comanda($_POST['id_ordre_comanda'][$i], $_POST['ordre_comanda'][$i]);
            }
        }


        $this->Comanda->modificar_estat_producte($data);

        $this->index();
    }

}

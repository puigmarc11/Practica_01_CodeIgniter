<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Camarer extends CI_Controller {

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

        if ($this->session->userdata("usuari")["camarer"] == "N" || $this->session->userdata("usuari") == null) {
            $c = $this->session->userdata("controlador");
            $a = $this->session->userdata("accio");
            redirect($c . "/" . $a);
        } else {
            $this->session->set_userdata("controlador", "Camarer");
            $this->session->set_userdata("accio", "index");
        }
    }

    public function index() {

        $this->load->model("Producte");
        $this->load->model("Taula");
        $this->load->model("Comanda");

        //Dades Sessio
        $data["usuari"] = $this->session->userdata("usuari");
        $data["taulaSeleccionada"] = $this->session->userdata("taula");

        //Dades XML
        $data["plats"] = $this->Producte->get_all_per_categoria("Plat");
        $data["begudes"] = $this->Producte->get_all_per_categoria("Beguda");
        $data["taules"] = $this->Taula->get_all();

        $data["productesTaula"] = $this->Comanda->productes_de_la_taula($this->session->userdata("taula"));

        $this->load->template('vista_camarer', $data);
    }

    public function seleccionar_taula() {

        $this->session->set_userdata("taula", $_POST["taula"]);
        $this->index();
    }

    public function crear_comanda() {

        $this->load->model("Comanda");

        $comanda = array(
            "taula" => $this->session->userdata("taula"),
            "estat" => "oberta",
        );
        
        $json = json_decode($_POST["comanda"]);
        //ID-NOM-QUANTITAT

        $id_comanda = $this->Comanda->get_comanda_oberta($this->session->userdata("taula"));
        
        

        if ($id_comanda != NULL && $json != NULL) {
            $this->entrar_detall($id_comanda, $json);
        } else if ($id_comanda == NULL) {
            $this->Comanda->crear_comanda($comanda);
            $id_comanda_nova = $this->Comanda->get_comanda_oberta($this->session->userdata("taula"));

            if ($json != NULL) {
                $this->entrar_detall($id_comanda_nova, $json);
            }
        }

        $this->index();
    }

    private function entrar_detall($id_comanda, $json) {

        $o = $this->Comanda->get_ordre_comanda($id_comanda->id);

        if ($o == NULL || $o->ordre == NULL) {

            $nou_ordre = array(
                "id_comanda" => $id_comanda->id,
                "ordre" => "1",
                "estat" => "cua",
            );

            $id_ordre = $this->Comanda->crear_ordre($nou_ordre);
        } else {

            if ($o->estat !== "cua") {

                $nou_ordre = array(
                    "id_comanda" => $id_comanda->id,
                    "ordre" => ($o->ordre) + 1,
                    "estat" => "cua",
                );
                $id_ordre = $this->Comanda->crear_ordre($nou_ordre);
            } else {
                $id_ordre = $o->id;
            }
        }

        $detall = array();

        foreach ($json as $p) {

            $detall[] = array(
                "id_ordre" => $id_ordre,
                "producte" => $p[0],
                "quantitat" => $p[2],
                "estat_prod" => "no_iniciat",
            );
        }

        $this->Comanda->inserir_detall($detall);
    }

}

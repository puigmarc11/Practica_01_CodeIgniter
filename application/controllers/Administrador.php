<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Administrador extends CI_Controller {

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

        if ($this->session->userdata("usuari")["administrador"] == "N" || $this->session->userdata("usuari") == null) {
            $c = $this->session->userdata("controlador");
            $a = $this->session->userdata("accio");
            redirect($c . "/" . $a);
        } else {
            $this->session->set_userdata("controlador", "Administrador");
            $this->session->set_userdata("accio", "index");
        }
    }

    public function index() {

        $data["usuari"] = $this->session->userdata("usuari");

        $this->load->model("Comanda");
        $this->load->model("Factura");
        $this->load->model("Producte");

        $data["llista_factures"] = $this->Factura->get_all_factures();
        $data["llista_taules_obertes"] = $this->Comanda->get_taules_obertes();

        $data["productesTaula"] = $this->formatar_productes();

        $this->load->template('vista_administrador', $data);
    }

    private function formatar_productes() {

        $auxProd = array();
        $taula_factura = $this->session->userdata("taula_factura");

        if (isset($taula_factura)) {


            foreach ($this->Comanda->productes_de_la_taula_agrupats($taula_factura) as $row) {

                $prod = $this->Producte->get_dades_producte($row["producte"]);

                $auxProd[] = array(
                    "producte" => $prod["nom"],
                    "quantitat" => $row["quantitat"],
                    "preu" => $prod["preu"],
                );
            }
        }

        return $auxProd;
    }

    public function visualitzar_factura($taula_sel) {

        $this->session->set_userdata("taula_factura", $taula_sel);
        $this->index();
    }

    public function generar_factura() {

        $taula_factura = $this->session->userdata("taula_factura");
        if (isset($taula_factura)) {

            $this->load->model("Factura");
            $this->load->model("Comanda");

            $factura = array(
                "taula" => $taula_factura,
                "usuari" => $this->session->userdata("usuari")["nom"],
                "data" => date("Y-m-d H:i:s"),
                "total" => 0,
            );

            $this->Factura->crear_factura($factura);
            $this->Comanda->modificar_estat_comanda($taula_factura);
        }

        $this->session->unset_userdata("taula_factura");
        $this->index();
    }

}

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
        include APPPATH . 'third_party/fpdf/fpdf.php';

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

    private function formatar_productes($id_factura = null) {

        $auxProd = array();
        $taula_factura = $this->session->userdata("taula_factura");

        if (isset($taula_factura)) {

            if (!$this->session->userdata("historic")) {

                foreach ($this->Comanda->productes_de_la_taula_agrupats($taula_factura) as $row) {

                    $prod = $this->Producte->get_dades_producte($row["producte"]);

                    $auxProd[] = array(
                        "id_factura" => $id_factura,
                        "producte" => $prod["nom"],
                        "quantitat" => $row["quantitat"],
                        "preu" => $prod["preu"],
                    );
                }
            } else {

                foreach ($this->Factura->get_factura($taula_factura) as $row) {

                    $auxProd[] = array(
                        "id_factura" => $id_factura,
                        "producte" => $row->producte,
                        "quantitat" => $row->quantitat,
                        "preu" => $row->preu,
                    );
                }
            }
        }

        return $auxProd;
    }

    public function visualitzar_factura($taula_sel, $historic = null) {

        $this->session->set_userdata("taula_factura", $taula_sel);
        $this->session->set_userdata("historic", $historic);

        $this->index();
    }

    public function generar_factura() {

        $taula_factura = $this->session->userdata("taula_factura");
        if (isset($taula_factura)) {

            $this->load->model("Factura");
            $this->load->model("Comanda");
            $this->load->model("Producte");


            $factura = array(
                "taula" => $taula_factura,
                "usuari" => $this->session->userdata("usuari")["nom"],
                "data" => date("Y-m-d H:i:s"),
                "total" => 0,
            );

            $id = $this->Factura->crear_factura($factura);

            $llista_p_t = $this->formatar_productes($id);
            $this->Factura->crear_factura_detall($llista_p_t);
            $this->Comanda->modificar_estat_comanda($taula_factura);
        }

        $this->session->unset_userdata("taula_factura");
        $this->index();
    }

    public function generar_pdf() {

        $this->load->model("Factura");
        $taula_factura = $this->session->userdata("taula_factura");
        $f = $this->Factura->get_factura($taula_factura);

        $total = 0;

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);

        $pdf->Cell(4 * 40, 10, "Data: " . $f[0]->data, 0, 1);
        $pdf->Cell(4 * 40, 10, "Camarer: " . $f[0]->usuari, 0, 1);
        $pdf->Cell(4 * 40, 10, "Taula: " . $f[0]->taula, 0, 1);
         $pdf->Ln();

        $pdf->Cell(40, 10, "Producte", 1, 0);
        $pdf->Cell(40, 10, "Quantitat", 1, 0, 'R');
        $pdf->Cell(40, 10, "Preu/Unitat", 1, 0, 'R');
        $pdf->Cell(40, 10, "Preu", 1, 1, 'R');

        $pdf->SetFont('Arial', '', 12);

        foreach ($f as $row) {

            $pdf->Cell(40, 10, $row->producte, 1, 0);
            $pdf->Cell(40, 10, "x" . $row->quantitat, 1, 0, 'R');
            $pdf->Cell(40, 10, $row->preu . chr(128), 1, 0, 'R');

            $total += $row->preu * $row->quantitat;

            $pdf->Cell(40, 10, $row->preu * $row->quantitat . chr(128), 1, 1, 'R');
        }

        $pdf->Cell(40 * 3, 10, "Total:", 1, 0);
        $pdf->Cell(40, 10, $total . chr(128), 1, 1, 'R');

        $pdf->Output();
    }

}

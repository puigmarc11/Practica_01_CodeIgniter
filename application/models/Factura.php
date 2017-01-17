<?php

class Factura extends CI_Model {

    // public $id;
    //  public $taula;
    // public $estat;

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_all_factures() {

        $query = $this->db->get("factura");
        return $query->result();
    }

    public function crear_factura($data) {
        $this->db->insert('factura', $data);
    }

}

?>
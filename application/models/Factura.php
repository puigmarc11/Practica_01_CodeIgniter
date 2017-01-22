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
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    public function crear_factura_detall($data) {

        $this->db->insert_batch('detall_factura', $data);
    }

    public function get_factura($data) {

        $array = array('factura.id' => $data);

        $this->db->select();
        $this->db->from('factura');
        $this->db->join('detall_factura', 'detall_factura.id_factura = factura.id');
        $this->db->where($array);
        $query = $this->db->get();

       return $query->result();
    }

}

?>
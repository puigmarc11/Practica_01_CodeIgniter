<?php

class Usuari extends CI_Model {

    public $id;
    public $mail;
    public $nom;
    public $password;
    public $camarer;
    public $cuiner;
    public $administrador;
    public $administrador_usuaris;
    public $actiu;
    public $classe;

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {

        $query = $this->db->get("usuari");
        return $query->result();
    }

    public function get_usuari($data) {

        $query = $this->db->get_where("usuari", $data);
        return $query;
    }

    public function crear_usuari($data) {

        $this->db->insert('usuari', $data);
    }

    public function modificar_usuari($data) {

        $this->db->where('id', $data["id"]);
        $this->db->update('usuari', $data);
    }

}

?>
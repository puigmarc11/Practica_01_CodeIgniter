<?php

class Comanda extends CI_Model {

    // public $id;
    //  public $taula;
    // public $estat;

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_comanda_oberta($taula) {

        //select * from comanda where taula = 't01' and estat <> 'tancat';

        $array = array('taula' => $taula, 'estat =' => 'oberta');
        $this->db->select();
        $this->db->from('comanda');
        $this->db->where($array);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_ordre_comanda($comanda) {

        $array = array('id_comanda' => $comanda);
        $this->db->select_max('ordre');
        $this->db->from('ordre_comanda');
        $this->db->where($array);
        $query = $this->db->get();

        $a = $query->row();

        if ($a->ordre != NULL) {
            $array2 = array('ordre' => $a->ordre, 'id_comanda' => $comanda);
            $this->db->select();
            $this->db->from('ordre_comanda');
            $this->db->where($array2);
            $query = $this->db->get();
            return $query->row();
        } else {
            return NULL;
        }
    }

    public function crear_comanda($data) {
        $this->db->insert('comanda', $data);
    }

    public function crear_ordre($data) {
        $this->db->insert('ordre_comanda', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function inserir_detall($data) {
        $this->db->insert_batch('detall_comanda', $data);
    }

    public function productes_de_la_taula($taula) {

        $array = array('taula' => $taula, 'comanda.estat =' => 'oberta');

        $this->db->select('comanda.id, ordre_comanda.estat, detall_comanda.producte, detall_comanda.quantitat');
        $this->db->from('detall_comanda');
        $this->db->join('ordre_comanda', 'ordre_comanda.id = detall_comanda.id_ordre');
        $this->db->join('comanda', 'comanda.id = ordre_comanda.id_comanda');
        $this->db->where($array);
        $query = $this->db->get();

        return $query->result();
    }

    public function productes_de_la_taula_agrupats($taula) {

        $sql = "SELECT c.id, c.taula, c.estat, d.producte, SUM(d.quantitat) as quantitat
                FROM comanda c left join ordre_comanda o on c.id = o.id_comanda
                LEFT JOIN detall_comanda d on d.id_ordre = o.id
                WHERE c.estat = 'oberta' and taula = ?
                GROUP BY d.producte, c.id, c.taula, c.estat, d.producte
                ORDER by d.producte";

        $query = $this->db->query($sql, array($taula));

        return $query->result_array();
    }

    public function get_all_comandes() {

        $array = array('comanda.estat =' => 'oberta');

        $this->db->select('comanda.id, comanda.taula, ordre_comanda.ordre, ordre_comanda.estat, detall_comanda.producte, '
                . 'detall_comanda.quantitat, detall_comanda.estat_prod, detall_comanda.id as id_detall_comanda');
        $this->db->from('detall_comanda');
        $this->db->join('ordre_comanda', 'ordre_comanda.id = detall_comanda.id_ordre');
        $this->db->join('comanda', 'comanda.id = ordre_comanda.id_comanda');
        $this->db->where($array);
        $this->db->order_by("ordre_comanda.id, detall_comanda.producte");
        $query = $this->db->get();

        return $query->result_array();
    }

    public function modificar_estat_comanda($id) {

        $data = array(
            "estat" => "tancada",
        );

        $this->db->where('taula', $id);
        $this->db->update('comanda', $data);
    }

    public function modificar_estat_ordre_comanda($id, $ordre) {

        $data = array(
            "estat" => "cuinant",
        );

        $this->db->where('id_comanda', $id);
        $this->db->where('ordre', $ordre);
        $this->db->update('ordre_comanda', $data);
    }

    public function modificar_estat_producte($data) {


        foreach ($data as $d) {

            $this->db->where('id', $d["id"]);
            $this->db->update('detall_comanda', $d);
        }
        
    }

    public function get_taules_obertes() {

        $array = array('comanda.estat =' => 'oberta');
        $this->db->select();
        $this->db->from('comanda');
        $this->db->where($array);
        $query = $this->db->get();

        return $query->result();
    }

}

?>
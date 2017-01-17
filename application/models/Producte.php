<?php

class Producte extends CI_Model {

    public $codi;
    public $nom;
    public $preu;
    public $categoria;

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function get_all() {

        if (is_file("public_html/data/productes.xml")) {
            $xml = simplexml_load_file("public_html/data/productes.xml");

            $productes = array();

            foreach ($xml->productes->producte as $producte) {

                $producte = array(
                    "id" => $producte['codi'] . "",
                    "nom" => $producte->nom . "",
                );

                $productes[] = $producte;
            }

            return $productes;
        } else {
            return null;
        }
    }

    public function get_all_per_categoria($categoria) {

        if (is_file("public_html/data/productes.xml")) {

            $xml = simplexml_load_file("public_html/data/productes.xml");
            $xpath = $xml->xpath("//producte[categoria='" . $categoria . "']");

            $productes = array();

            foreach ($xpath as $producte) {

                $producte = array(
                    "id" => $producte['codi'] . "",
                    "nom" => $producte->nom . "",
                    "categoria" => $producte->categoria . "",
                );

                $productes[] = $producte;
            }

            return $productes;
        } else {
            return null;
        }
    }

    public function get_dades_producte($id) {

        if (is_file("public_html/data/productes.xml")) {

            $xml = simplexml_load_file("public_html/data/productes.xml");
            $xpath = $xml->xpath("//producte[@codi='" . $id . "']");

            foreach ($xpath as $producte) {

                $producte = array(
                    "id" => $producte['codi'] . "",
                    "nom" => $producte->nom . "",
                    "preu" => $producte->preu . "",
                    "categoria" => $producte->categoria . "",
                );
            }

            return $producte;
            
        } else {
            return null;
        }
    }

}

?>
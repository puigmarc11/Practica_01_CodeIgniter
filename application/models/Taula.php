<?php

class Taula extends CI_Model {

    public $codi;

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function get_all() {

        if (is_file("public_html/data/productes.xml")) {
            $xml = simplexml_load_file("public_html/data/productes.xml");

            $taules = array();

            foreach ($xml->taules->taula as $taula) {

                $taula = array(
                    "id" => $taula['codi']."",
                );

                $taules[] = $taula;
            }

            return $taules;
        } else {
            return null;
        }
    }

}

?>
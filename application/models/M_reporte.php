<?php

class M_reporte extends  CI_Model{
    function __construct(){
        parent::__construct();
    }

    function getDatosUser() {
        $sql = "SELECT * FROM participante";
        $result = $this->db->query($sql);
        return $result->result();
    }
}
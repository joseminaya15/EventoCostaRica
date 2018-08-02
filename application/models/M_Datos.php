<?php

class M_Datos extends  CI_Model{
    function __construct(){
        parent::__construct();
    }

    function insertarDatos($insertParticipante, $tabla){
        $this->db->insert($tabla, $insertParticipante);
        $sql = $this->db->insert_id();
        if($this->db->affected_rows() != 1) {
            throw new Exception('Error al insertar');
            $data['error'] = EXIT_ERROR;
        }
        return array("error" => EXIT_SUCCESS, "msj" => MSJ_INS, "Id" => $sql);
    }

    function existCorreo($correo){
        $sql = "SELECT email
                  FROM participante
                  WHERE email = ?";
        $result = $this->db->query($sql, array($correo));
        return $result->result();
    }

    function getDatosCorreos() {
        $sql = "SELECT email
                  FROM participante";
        $result = $this->db->query($sql);
        return $result->result();
    }
    function actualizarDatos($correo, $tabla, $arrayUpDate){
        $this->db->where('email',$correo);
        $this->db->update($tabla, $arrayUpDate);
        if ($this->db->trans_status() == false) {
            throw new Exception('No se pudo actualizar los datos');
        }
        return array('error' => EXIT_SUCCESS,'msj' => MSJ_UPT);
    }
}
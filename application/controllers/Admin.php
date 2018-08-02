<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->model('M_reporte');
        $this->load->helper("url");//BORRAR CACHÉ DE LA PÁGINA
        $this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
        $this->output->set_header('Pragma: no-cache');
    }
	public function index(){
		/*if($this->session->userdata('usuario') == null){
			header("location: Login");
		}*/
        $datos = $this->M_reporte->getDatosUser();
        $html  = '';
        $cont  = 1;
        $invitado = '';
        if(count($datos) == 0) {
            $html = '';
        }else {
            foreach ($datos as $key){
		$invitado = $key->invitation == 1 ? 'Si' : 'No';
                $html .= '<tr class="tr-cursor-pointer">
                            <td class="text-left">'.$key->tipo.'</td>
                            <td class="text-left">'.$key->breakout.'</td>
                            <td class="text-left">'.$key->name.' '.$key->surname.'</td>
                            <td class="text-left">'.$key->company.'</td>
                            <td class="text-left">'.$key->country.'</td>
                            <td class="text-left">'.$key->position.'</td>
                            <td class="text-right">'.$key->phone.'</td>
                            <td class="text-left">'.$key->email.'</td>
                            <td class="text-left">'.$key->size.'</td>
                            <td class="text-center">'.$key->llegada.'</td>
                            <td class="text-center">'.$key->retorno.'</td>
                            <td class="text-right">'.$key->reserva.'</td>
                            <td class="text-left">'.$invitado.'</td>
                        </tr>';
                $cont++;
            }
        }
		$data['html'] = $html;
		$this->load->view('v_admin', $data);
	}
    function cerrarCesion(){
        $data['error'] = EXIT_ERROR;
        $data['msj']   = null;
        try {
            $this->session->unset_userdata('usuario');
            $data['error'] = EXIT_SUCCESS;
        } catch (Exception $e){
            $data['msj'] = $e->getMessage();
        }
        echo json_encode($data);
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper("url");//BORRAR CACHÉ DE LA PÁGINA
		$this->load->model('M_Datos');
		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
        $this->output->set_header('Pragma: no-cache');
	}

	public function index()
	{
		$this->load->view('v_home');
	}

	function register(){
		$data['error'] = EXIT_ERROR;
      	$data['msj']   = null;
		try {
			$name           = $this->input->post('Name');
			$surname 		= $this->input->post('Surname');
			$correo 		= $this->input->post('Email');
			$telefono	    = $this->input->post('Phone');
			$empresa 		= $this->input->post('Company');
			$cargo 		    = $this->input->post('Position');
			$pais	 		= $this->input->post('Country');
			$existe         = $this->M_Datos->existCorreo($correo);
			if(count($existe) != 0) {
				$data['msj']   = 'Correo ya registrado';
			}
			else{
				$insertParticipante = array('name'    => $name,
										   'surname'  => $surname,
										   'email' 	  => $correo,
										   'phone' 	  => $telefono,
										   'company'  => $empresa,
										   'position' => $cargo,
										   'country'  => $pais);
				$datoInsert  = $this->M_Datos->insertarDatos($insertParticipante,'participante');
	          	$data['msj']   = $datoInsert['msj'];
	          	$data['error'] = $datoInsert['error'];
	          }
		} catch(Exception $ex) {
			$data['msj'] = $ex->getMessage();
		}
      	echo json_encode($data);
	}
	function ingresar() {
		$data['error'] = EXIT_ERROR;
        $data['msj']   = null;
         try {
			$correo   = $this->input->post('correo');
			$username = $this->M_Datos->getDatosCorreos();
			if(count($username) != 0) {
				foreach ($username as $key) {
					if ($key->email == $correo) {
						$session = array('email' => $key->email);
                        $this->session->set_userdata($session);
						$data['error'] = EXIT_SUCCESS;
					}
				}
			}
        }catch(Exception $e) {
           $data['msj'] = $e->getMessage();
        }
        echo json_encode($data);
	}
}

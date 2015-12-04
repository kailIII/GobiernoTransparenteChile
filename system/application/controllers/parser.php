<?php

class Parser extends Controller {

    function __construct() {
        parent::__construct();

        if(!$this->session->userdata('logged_in') && isset($_SERVER['REMOTE_ADDR'])){
            $this->session->set_userdata('referer', current_url());
            redirect(site_url('/usuarios/login'));
        }

        log_message('debug','INICIO DE CARGA DE LIBRERIAS' );

        $this->load->library('simple_html_dom');
        $this->load->library('simple_html_dom');
        $this->load->library('parser_library');
        $this->load->library('parser_indexador');
        $this->load->library('parser_planilla');
        $this->load->library('parser_per_planta');
        $this->load->library('parser_per_contrata');
        $this->load->library('parser_codtrabajo');
        $this->load->library('parser_per_honorarios');
        $this->load->library('parser_normativa_a6');
        $this->load->library('parser_normativa_a6_2');
        $this->load->library('parser_normativa_a7c');
        $this->load->library('parser_normativa_a7g');
        $this->load->library('parser_facultades');
        $this->load->library('parser_otras_compras');
        $this->load->library('parser_transferencias');
        $this->load->library('parser_auditorias');
        $this->load->library('parser_otros_tramites');
        $this->load->library('parser_ciudadana');
        $this->load->library('parser_subsidio_programas');
        $this->load->library('parser_vinculos');
        $this->load->library('parser_secretoreserva');
        $this->load->library('parser_ley20416');
        $this->load->library('parser_solicitud_informacion');
        $this->load->library('parser_informacion_no_disponible');
        $this->load->library('parser_registro_respuestas');
        log_message('debug','LIBRERIAS CARGADAS CORRECTAMENTE' );
    }

    function index() {
        $servicios = $this->Servicios_model->get()->result();
        $data['servicios'] = $servicios;

        $data['title'] = 'Parser';
        $data['content'] = 'parser_ajax';
        $this->load->view('template_parser', $data);
    }

    function ajax_parse_consejo() {
        $this->parser_consejo->start();
    }

    function ajax_parse_servicio($servicio_id) {
        try {
            $servicio = $this->Servicios_model->getById($servicio_id)->row();

            log_message('debug','INICIO PARSEO SERVICIO: '.$servicio->servicio );

            //Obtenemos el directorio de paginas del servicio
            $home_parser_result = $this->parser_indexador->start($servicio->id);

            if (isset($home_parser_result->paginas))
                $paginas_indexadas = $home_parser_result->paginas;
            else
                $paginas_indexadas = array();
            $data['paginas_indexadas'] = $paginas_indexadas;

            log_message('debug','PAGINAS INDEXADAS: '.count($paginas_indexadas));

            log_message('debug','PARSER PER PLANTA');
            $aux = $this->parser_per_planta->start($servicio->id);
            $servicio->paginas[] = clone $aux;
            log_message('debug','PARSER PER CONTRATA');
            $aux = $this->parser_per_contrata->start($servicio->id);
            $servicio->paginas[] = clone $aux;
            log_message('debug','PARSER PER HONORARIOS');
            $aux = $this->parser_per_honorarios->start($servicio->id);
            $servicio->paginas[] = clone $aux;
            log_message('debug','PARSER CODTRABAJO');
            $aux = $this->parser_codtrabajo->start($servicio->id);
            $servicio->paginas[] = clone $aux;
            log_message('debug','PARSER NORMATIVA A6');
            $aux = $this->parser_normativa_a6->start($servicio->id);
            $servicio->paginas[] = clone $aux;
            log_message('debug','PARSER NORMATIVA A6 2');
            $aux = $this->parser_normativa_a6_2->start($servicio->id);
            $servicio->paginas[] = clone $aux;
            log_message('debug','PARSER NORMATIVA A7C');
            $aux = $this->parser_normativa_a7c->start($servicio->id);
            $servicio->paginas[] = clone $aux;
            log_message('debug','PARSER NORMATIVA A7G');
            $aux = $this->parser_normativa_a7g->start($servicio->id);
            $servicio->paginas[] = clone $aux;
            log_message('debug','PARSER FACULTADES');
            $aux = $this->parser_facultades->start($servicio->id);
            $servicio->paginas[] = clone $aux;
            log_message('debug','PARSER OTRAS COMPRAS');
            $aux = $this->parser_otras_compras->start($servicio->id);
            $servicio->paginas[] = clone $aux;
            log_message('debug','PARSER TRANSFERECIAS');
            $aux = $this->parser_transferencias->start($servicio->id);
            $servicio->paginas[] = clone $aux;
            log_message('debug','PARSER AUDITORIAS');
            $aux = $this->parser_auditorias->start($servicio->id);
            $servicio->paginas[] = clone $aux;
            log_message('debug','PARSER OTROS TRAMITES');
            $aux = $this->parser_otros_tramites->start($servicio->id);
            $servicio->paginas[] = clone $aux;
            log_message('debug','PARSER CIUDADANA');
            $aux = $this->parser_ciudadana->start($servicio->id);
            $servicio->paginas[] = clone $aux;
            log_message('debug','PARSER SUBCIDIO PROGRAMAS');
            $aux = $this->parser_subsidio_programas->start($servicio->id);
            $servicio->paginas[] = clone $aux;
            log_message('debug','PARSER VINCULOS');
            $aux = $this->parser_vinculos->start($servicio->id);
            $servicio->paginas[] = clone $aux;
            log_message('debug','PARSER SECRETO RESERVA');
            $aux = $this->parser_secretoreserva->start($servicio->id);
            $servicio->paginas[] = clone $aux;
            log_message('debug','PARSER LEY 20416');
            $aux = $this->parser_ley20416->start($servicio->id);
            $servicio->paginas[] = clone $aux;
            // Se elimina el parser de solicitudes de información
            // $aux=$this->parser_solicitud_informacion->start($servicio->id);
            // $servicio->paginas[]=clone $aux;
            log_message('debug','PARSER INFORMACION NO DISPONIBLE');
            $aux = $this->parser_informacion_no_disponible->start($servicio->id);
            $servicio->paginas[] = clone $aux;
            log_message('debug','PARSER REGISTRO RESPUESTAS');
            $aux = $this->parser_registro_respuestas->start($servicio->id);
            $servicio->paginas[] = clone $aux;


            $data['result'] = $servicio;
            $this->load->view('parser_ajax_parse_servicio', $data);
            log_message('debug','FINALIZACIÓN DE PROCESO');
        }catch(Exception $ex){
            log_message('error', $ex->getMessage());
            $data['heading'] = 'error dal parsear información';
            $data['message'] = $ex->getMessage();
            $this->load->view('error_general', $data);

        }
    }

    function test(){
        $this->load->library('parser_per_planta');
        print_r($this->parser_per_planta->parser('http://transparenciaactiva.presidencia.cl/2015/per_planta.html'));
    }

}

?>

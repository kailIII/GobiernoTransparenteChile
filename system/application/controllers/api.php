<?php
class API extends Controller{
    function API(){
        parent::Controller();
    }

    function index(){
        $data['content']='api_index';
        $data['title']='API para Desarrolladores';

        $this->load->view('template_reportes',$data);
    }
}

?>

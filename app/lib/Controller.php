<?php

namespace app\lib;

class Controller {

    public $content;
    public $route;

    public function __construct($route = null) {
        $this->route = $route;
        if(is_callable(array($this, $route['view']))){
            $this->$route['view']($route['id']);
        }else{
            $this->listar();
        }
        
        $this->template();
    }

    public function rotas() {
        $op = isset($_GET['op']) ? $_GET['op'] : NULL;
        if (!$op || $op == 'listar') {
            $this->listar();
        } elseif ($op == 'alterar') {
            $this->alterar();
        } elseif ($op == 'deletar') {
            $this->deletar();
        } elseif ($op == 'inserir') {
            $this->inserir();
        }
    }

    public function view($name, Array $options = null) {

        ob_start();
        ob_implicit_flush(false);
        if (isset($options)) {
            foreach ($options as $key => $value) {
                $$key = $value;
                extract($$key, EXTR_OVERWRITE);
            }
        }

        require('./app/view/' . $name . '.php');

        $this->content = ob_get_clean();
    }

    public function template($name = null) {
        if ($name == null)
            $name = "index";
        $request = $_REQUEST;
        include './public/template/' . $name . '.php';
    }

}

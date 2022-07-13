<?php

namespace app\core;
use app\router\Router;

class Core
{

    public function callRouter()
    {
        $exists = $this->existsClassAndMethod();

        if ($exists == true) :
            //echo "Chamando a classe solicitada.. <br>";
            call_user_func_array([$this->object, $this->method], $this->param);
        endif;

        if ($exists == false) :
            //echo "Chamando a classe Index... <br>";
            $class = "\\app\\controllers\\Index";
            $object = new $class;
            call_user_func_array([$object, 'index'], []);
        endif;
    }

    private function existsClassAndMethod(){
        $uri = new Router();
        $router = $uri->getUri();
        array_shift($router);
        
        //echo "Procurando classe...<br>";
        if (file_exists('../app/controllers/' . ucfirst($router[0] . '.php'))) {         
            //echo "A classe existe..<br>";
            $this->controller = $router[0];
            array_shift($router);

            $class = "\\app\\controllers\\" . ucfirst($this->controller);
            $object = new $class;
            $this->object = $object;
            //echo "Procurando o metodo...<br>";

            if (isset($router[0]) and method_exists($object, $router[0])) :
                //echo "Método encontrado..<br>";
                $this->method = $router[0];
                array_shift($router);
                $this->param = $router ? array_values($router) : [];
                //echo "Pegando valores: método e parâmetro.. <br>";
                return true;
            else :
                //echo "A Classe existe. Pórem método não encontrado..<br>";
                return false;
            endif;
        } else {
            //echo "A Classe não existe..";
            return false;
        }
    }
}

<?php

namespace app\router;

class Router{
    public function getUri(){
        //echo "Pegando a URI..<br>";
        $uri = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        return $uri;
    }
}

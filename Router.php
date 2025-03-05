<?php

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }
    

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function comprobarRutas()
    {
        //session_start();
        define('DEFAULT_LANGUAGE', 'en');
        chooseLanguage();

        $url_actual = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$url_actual] ?? null;
        } else {
            $fn = $this->postRoutes[$url_actual] ?? null;
        }
        if ( $fn ) {
            call_user_func($fn, $this);
        } else {
            echo "Página No Encontrada o Ruta no válida";
        }
    }

    public function render($view, $datos = []){
        $lang_file = __DIR__ . "/lang.json";

        if (file_exists($lang_file)) {
            $lang_json = file_get_contents($lang_file);
            $lang_array = json_decode($lang_json, true);
            if (is_array($lang_array)) {
                $datos = array_merge($datos, $lang_array);
            }
        }

        foreach ($datos as $key => $value) {
            $$key = $value; 
        }

        ob_start();

        include_once __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean(); 

        $pattern = '/\{%\s*([\w-]+)\s*%\}/';
        $contenido = preg_replace_callback($pattern, function($matches) use ($datos) {
            $lang = chooseLanguage();
            $variable_name = $matches[1];
            return isset($datos[$variable_name][$lang]) ? $datos[$variable_name][$lang] : 'Corregir llave en: ' . $variable_name . '';
        }, $contenido);

        
        $url_actual = $_SERVER['PATH_INFO'] ?? '/';

        if(str_contains($url_actual, '/filmtono/')) {
            include_once __DIR__ . "/views/layouts/admin-layout.php";
        } elseif(str_contains($url_actual, '/music/') || (isset($_SESSION['nivel_musica'])&& str_contains($url_actual, '/complete-register'))) {
            include_once __DIR__ . "/views/layouts/musica-layout.php";
        } else {
            include_once __DIR__ . "/views/layouts/main-layout.php";
        }
    }
}

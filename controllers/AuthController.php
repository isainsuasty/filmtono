<?php

namespace Controllers;

use MVC\Router;
use Model\Terms;
use Model\Sellos;
use Classes\Email;
use Model\Empresa;
use Model\NTAdmin;
use Model\Privacy;
use Model\Usuario;
use Model\NTMusica;
use Model\CTRMusical;
use Model\TipoMusica;
use Classes\Comprador;
use Model\Comunicados;
use Model\CTRArtistico;
use Model\PerfilUsuario;
use Model\UsuarioSellos;
use Model\ContactoCompra;
use Classes\MusicalContract;
use Classes\ArtisticContract;

class AuthController {
    public static function login(Router $router) {
        $alertas = [];
        $usuario = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarLogin();
            
            if(empty($alertas)) {
                // Verificar quel el usuario exista
                $usuario = Usuario::where('email', $usuario->email);

                if(!$usuario || !$usuario->confirmado ) {
                    $usuario = new Usuario;
                    $usuario->email = s($_POST['email']);
                    Usuario::setAlerta('error', 'auth_alert_user-not-exist');
                } else {
                    // El Usuario existe
                    if( password_verify($_POST['password'], $usuario->password) ) {
                        $nivel_musica = NTMusica::where('id_usuario', $usuario->id);
                        $nivel_admin = NTAdmin::where('id_usuario', $usuario->id);
                        
                        // Iniciar la sesión
                        session_start();    
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['apellido'] = $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['perfil'] = $usuario->perfil;
                        $_SESSION['aprobado'] = $usuario->aprobado;

                        // Verificar el nivel de acceso y redireccionar
                        if($nivel_musica) {
                            $_SESSION['nivel_musica'] = $nivel_musica->id_nivel;
                            header('Location: /music/dashboard');
                        }elseif($nivel_admin) {
                            $_SESSION['nivel_admin'] = $nivel_admin->id_nivel;
                            header('Location: /filmtono/dashboard');
                        } else {
                            header('Location: /');
                        }
                        
                    } else {
                        Usuario::setAlerta('error', 'auth_alert_password-wrong');
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();
        
        // Render a la vista 
        $router->render('auth/login', [
            'titulo' => 'auth_login_title',
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
    }

    public static function logout() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION = [];
            session_destroy();
            $_SESSION = [];
            header('Location: /');
        }       
    }

    public static function register(Router $router) {
        $lang = $_SESSION['lang'] ?? 'en';
        $alertas = [];
        $contacto = new ContactoCompra;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contacto->sincronizar($_POST);

            $alertas = $contacto->validar();

            if(empty($alertas)) {
                    // Crear un nuevo contacto
                $resultado =  $contacto->guardar();
                    
                // Enviar email
                $email = new Comprador($contacto->nombre, $contacto->apellido, $contacto->email, $contacto->pais, $contacto->telefono, $contacto->presupuesto, $contacto->mensaje);
                $email->enviarMensaje();

                if($resultado) {
                    header('Location: /');
                }
            }
        }

        // Render a la vista
        $router->render('auth/register', [
            'titulo' => 'auth_register_title',
            'lang' => $lang,
            'contacto' => $contacto,
            'alertas' => $alertas
        ]);
    }

    public static function registerMusic(Router $router){
        $lang = $_SESSION['lang'] ?? 'en';
        $alertas = [];
        $musico = TipoMusica::allOrderBy('tipo_'.$lang);
        $tipoMusico = new NTMusica;
        $usuario = new Usuario;
        $userType = $_GET['type'] ?? null;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['honeypot'])) {
                die(header('Location: /'));
            }
            $usuario->sincronizar($_POST);
            $usuario->nombre = sText($usuario->nombre);
            $usuario->apellido = sText($usuario->apellido);
            $tipoMusico->sincronizar($_POST);
            
            $alertas = $usuario->validar_cuenta();
            $alertas = $tipoMusico->validar_tipo();
            $alertas = $usuario->validarPassword();

            if($tipoMusico->id_musica === '1' || $tipoMusico->id_musica === '2'){
                $tipoMusico->id_nivel = '2';
            } elseif($tipoMusico->id_musica === '3'){
                $tipoMusico->id_nivel = '3';
            }
            
            if(empty($alertas)){
                $existeUsuario = Usuario::where('email', $usuario->email);

                if($existeUsuario) {
                    Usuario::setAlerta('error', 'auth_alert_user-already-exist');
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el password
                    $usuario->hashPassword();

                    // Eliminar password2
                    unset($usuario->password2);

                    // Generar el Token
                    $usuario->crearToken();

                    // Crear un nuevo usuario
                    $resultado =  $usuario->guardar();
                    
                    $tipoMusico->id_usuario = $resultado['id'];
                    $tipoMusico->guardar();

                    // Enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    if($lang == 'en'){
                        $email->enviarConfirmacion();
                    } else{
                        $email->enviarConfirmacionEs();
                    }
                    

                    if($resultado) {
                        header('Location: /message');
                    }
                }
            }

        }
        $router->render('auth/register-music', [
            'titulo' => 'auth_register-music_title',
            'alertas' => $alertas,
            'musico' => $musico,
            'lang' => $lang,
            'usuario' => $usuario,
            'userType' => $userType
        ]);
    }

    public static function forgot(Router $router) {
        $alertas = [];
        $lang = $_SESSION['lang'] ?? 'en';
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if(empty($alertas)) {
                // Buscar el usuario
                $usuario = Usuario::where('email', $usuario->email);

                if($usuario && $usuario->confirmado) {

                    // Generar un nuevo token
                    $usuario->crearToken();
                    unset($usuario->password2);

                    // Actualizar el usuario
                    $usuario->guardar();

                    // Enviar el email
                    $email = new Email( $usuario->email, $usuario->nombre, $usuario->token );
                    if($lang == 'en'){
                        $email->enviarInstrucciones();
                    } else{
                        $email->enviarInstruccionesEs();
                    }


                    // Imprimir la alerta
                    // Usuario::setAlerta('exito', 'Hemos enviado las instrucciones a tu email');
                    $alertas = Usuario::setAlerta('exito', 'auth_forgot-password_alert-success');
                } else {
                 
                    // Usuario::setAlerta('error', 'El Usuario no existe o no esta confirmado');
                    $alertas = Usuario::setAlerta('error', 'auth_forgot-password_alert-error');
                }
                $alertas = Usuario::getAlertas();
            }
        }

        // Muestra la vista
        $router->render('auth/forgot', [
            'titulo' => 'auth_forgot-password_title',
            'alertas' => $alertas,
            'lang' => $lang
        ]);
    }

    public static function reset(Router $router) {

        $token = s($_GET['token']);

        $token_valido = true;

        if(!$token) header('Location: /');

        // Identificar el usuario con este token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            Usuario::setAlerta('error', 'auth_reset-password_alert-error');
            $token_valido = false;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Añadir el nuevo password
            $usuario->sincronizar($_POST);

            // Validar el password
            $alertas = $usuario->validarPassword();

            if(empty($alertas)) {
                
                unset($usuario->password2);
                // Hashear el nuevo password
                $usuario->hashPassword();

                // Eliminar el Token
                $usuario->token = null;

                // Guardar el usuario en la BD
                $resultado = $usuario->guardar();

                // Redireccionar
                if($resultado) {
                    header('Location: /login');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        
        // Muestra la vista
        $router->render('auth/reset', [
            'titulo' => 'auth_reset-password_title',
            'alertas' => $alertas,
            'token_valido' => $token_valido
        ]);
    }

    public static function message(Router $router) {

        $router->render('auth/message', [
            'titulo' => 'auth_message_title'
        ]);
    }

    public static function confirm(Router $router) {
        
        $token = s($_GET['token']);

        if(!$token) header('Location: /');

        // Encontrar al usuario con este token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            // No se encontró un usuario con ese token
            Usuario::setAlerta('error', 'auth_confirm_alert-error');
        } else {
            // Confirmar la cuenta
            $usuario->confirmado = 1;
            $usuario->token = '';
            unset($usuario->password2);
            
            // Guardar en la BD
            $usuario->guardar();

            Usuario::setAlerta('exito', 'auth_confirm_alert-success');
        }

     

        $router->render('auth/confirm', [
            'titulo' => 'auth_confirm_title',
            'alertas' => Usuario::getAlertas()
        ]);
    }

    public static function completeRegister(Router $router){
        $usuario = Usuario::find($_SESSION['id']);
        $titulo = 'auth_complete-register_title';
        $empresa = new Empresa();
        $ctr_music = new CTRMusical();
        $ctr_artistic = new CTRArtistico();
        $terms = new Terms();
        $privacy = new Privacy();
        $comunicados = new Comunicados();
        $perfilUsuario = new PerfilUsuario();        

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $empresa->sincronizar($_POST);
            $terms->sincronizar($_POST);
            $privacy->sincronizar($_POST);
            $comunicados->sincronizar($_POST);
            $firma = $_POST['signatureInput'];
            $firmaOpt= $_POST['signatureOptional'];
   
            //Asignar el id del usuario a cada tabla
            $terms->id_usuario = $usuario->id;
            //Asignar la version de los terminos y condiciones
            $terms->version = '1.0';
            $terms->guardar();

            $privacy->id_usuario = $usuario->id;
            //Asignar la versión de la politica de privacidad
            $privacy->version = '1.0';
            $privacy->guardar();

            $comunicados->id_usuario = $usuario->id;
            $comunicados->guardar();
            

            //Organizar el teléfono de contacto
            $empresa->tel_contacto = $_POST['tel-index'].$_POST['tel_contacto'];

            $empresa->cargo = sText($empresa->cargo);
            $empresa->empresa = sText($empresa->empresa);
            //guardar los datos en la base de datos
            $empresa->guardar();

            $empresa = Empresa::where('empresa', $empresa->empresa);

            $contractPDF = new MusicalContract($usuario->id, $empresa->empresa, $usuario->nombre.' '.$usuario->apellido, $empresa->id_fiscal, $empresa->direccion, $firma, $_POST['pais_contacto_name'], $empresa->tel_contacto, $usuario->email, date('d-m-y'), $empresa->id);

            $contractPDF->guardarContrato();
                        
            $ctr_music->id_usuario = $usuario->id;
            $ctr_music->id_empresa = $empresa->id;
            $ctr_music->nombre_doc = $ctr_music->id_usuario.'-'.$ctr_music->id_empresa.'-music-'.date('d-m-y').'.pdf';
            $ctr_music->guardar();
                       
            if($firmaOpt != ''){
                $empresa = Empresa::where('empresa', $empresa->empresa);

                $contractPDF = new ArtisticContract($usuario->id, $empresa->empresa, $usuario->nombre.' '.$usuario->apellido, $empresa->id_fiscal, $empresa->direccion, $firmaOpt, $_POST['pais_contacto_name'], $empresa->tel_contacto, $usuario->email, date('d-m-y'), $empresa->id);
                $contractPDF->guardarContrato();

                $ctr_artistic->id_usuario = $usuario->id;
                $ctr_artistic->id_empresa = $empresa->id;
                $ctr_artistic->nombre_doc = $ctr_artistic->id_usuario.'-'.$ctr_artistic->id_empresa.'-artistic-'.date('d-m-y').'.pdf';
                $ctr_artistic->guardar();
            }
            

            //Revisar si el usuario es un sello
            if(isset($_SESSION['nivel_musica'])){
                $sello = new Sellos();
                if($_SESSION['nivel_musica'] == 3){
                    $sello->nombre = $empresa->empresa;
                    $sello->guardar();

                    //Asignar el sello al usuario
                    $sello = Sellos::where('nombre',$sello->nombre);
                    $usuarioSellos = new UsuarioSellos();
                    $usuarioSellos->id_usuario = $usuario->id;
                    $usuarioSellos->id_empresa = $empresa->id;
                    $usuarioSellos->id_sellos = $sello->id;
                    $usuarioSellos->guardar();
                }
            }


            //Asignar usuario y empresa a la tabla perfil_usuario
            $perfilUsuario->id_usuario = $usuario->id;
            $perfilUsuario->id_empresa = $empresa->id;
            $perfilUsuario->guardar();

            //Cambiar el estado del perfil del usuario y Redireccionar al usuario a la pagina de inicio
            $usuario->perfil = '1';
            $resultado = $usuario->guardar();
            $_SESSION['perfil'] = $usuario->perfil;

            if($resultado){
                header('Location: /music/dashboard');
            }
        }

        $router->render('auth/complete-register', [
            'titulo' => 'auth_complete-register_title',
            'usuario' => $usuario
        ]);
    }
}
<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Comprador {

    public $nombre;
    public $apellido;
    public $email;
    public $pais;
    public $telefono;
    public $presupuesto;
    public $mensaje;
    
    public function __construct($nombre, $apellido, $email, $pais, $telefono, $presupuesto, $mensaje)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->pais = $pais;
        $this->telefono = $telefono;
        $this->presupuesto = $presupuesto;
        $this->mensaje = $mensaje;
    }

    public function enviarMensaje() {

         // create a new object
         $mail = new PHPMailer();
         $mail->isSMTP();
         $mail->Host = $_ENV['EMAIL_HOST'];
         $mail->SMTPAuth = true;
         $mail->Port = $_ENV['EMAIL_PORT'];
         $mail->Username = $_ENV['EMAIL_USER'];
         $mail->Password = $_ENV['EMAIL_PASS'];
     
         $mail->setFrom('no-reply@filmtono.com');
         $mail->addAddress('isainsuasty@gmail.com');
         $mail->Subject = 'Contacto de comprador Filmtono';

         // Set HTML
         $mail->isHTML(TRUE);
         $mail->CharSet = 'UTF-8';

         $contenido = '<html>';
         $contenido .= "<style>
                            body{
                                font-family: 'Roboto', sans-serif;
                                line-height: 1.2;
                                height: fit-content;
                            }
                            img{
                                width: 100%;
                                height: auto;
                            }
                            .center{
                                max-width: 400px;
                                margin: auto;
                                display: flex;
                                flex-direction: column;
                            }
                            .background{
                                background-color: #dedede;
                                padding: 20px 20px 10px 20px;
                            }
                            .content{
                                background-color: #fff;
                                padding: 20px;
                                margin-bottom: 4rem;
                            }
                            h1{
                                color: #FD9526;
                                font-weight: 900;
                                text-align: center;
                                margin-top: 5px;
                            }
                            a{
                                background-color: #FD9526;
                                color: #292B3F;
                                padding: 10px 20px;
                                border-radius: 10px;
                                margin: 10px auto;
                                text-decoration: none;
                                font-weight: bold;
                                display: block;
                                width: fit-content;
                            }
                            p span{
                                font-weight: bold;
                                display: block;
                                margin-top: 25px;
                            }
                        </style>";
         $contenido .= "<body style='max-width:400px; border: 2px solid #fD9526;'>";

         $contenido .= "<div class='center' style='max-width:400px; margin:auto; display:block;'>";

         $contenido .= "<div class='background' style='max-width:400px; background-color: #dedede; padding: 20px 20px 10px 20px;'>";

         $contenido .= "<div class='content' style='background-color: #fff;      padding: 20px; margin: auto auto;'>";

         $contenido .= "<h1 style='color: #FD9526; font-weight: 900;             text-align: center; margin-top: 5px;'>¡Nuevo contacto de comprador!</h1>";

         $contenido .= "<h2 style='color:black; font-weight:bold;'>Nombre: " . $this->nombre .' '.$this->apellido.  "</h2>";

         $contenido .= "<p style='color:black;'>Email: ".$this->email."</p>";

         $contenido .= "<p style='color:black;'>País: ".$this->pais."</p>";

         $contenido .= "<p style='color:black;'>Teléfono: ".$this->telefono."</p>";

         $contenido .= "<p style='color:black;'>Presupuesto: ".$this->presupuesto."</p>";

         $contenido .= "<p style='color:black;'>Mensaje: ".$this->mensaje."</p>";

         $contenido .= "</div>";

         $contenido .= "<div class='footer' style='margin: auto auto';>";       

         $contenido .= "<p style='color:black;'><span style='margin-top:25px; font-weight: bold; display:block; text-align:center;'>Filmtono © ".date("Y"). "</span></p>";

         $contenido .= "</div>";

         $contenido .= "</div>";

         $contenido .= "</div>";

         $contenido .= "</body>";

         $contenido .= '</html>';

         $mail->Body = $contenido;

         //Enviar el mail
         $mail->send();

    }
}
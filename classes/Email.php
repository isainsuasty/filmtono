<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;
    
    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {

         // create a new object
         $mail = new PHPMailer();
         $mail->isSMTP();
         $mail->Host = $_ENV['EMAIL_HOST'];
         $mail->SMTPAuth = true;
         $mail->Port = $_ENV['EMAIL_PORT'];
         $mail->Username = $_ENV['EMAIL_USER'];
         $mail->Password = $_ENV['EMAIL_PASS'];
     
         $mail->setFrom('no-reply@filmtono.com');
         $mail->addAddress($this->email, $this->nombre);
         $mail->Subject = 'Activate your Filmtono account';

         // Set HTML
         $mail->isHTML(TRUE);
         $mail->CharSet = 'UTF-8';

         $contenido = '<html>';
         $contenido .= "<style>
                            body{
                                font-family: 'Roboto', sans-serif;
                                line-height: 1.2;
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
                                transform: translateY(-20%);
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
                            .footer{
                                margin-top: -40px;
                            }
                            p span{
                                font-weight: bold;
                                display: block;
                                margin-top: 25px;
                            }
                        </style>";
         $contenido .= "<body style='max-width:400px'>";

         $contenido .= "<div class='center' style='max-width:400px; margin:auto; display:block;'>";

         $contenido .= "<img style='max-width:400px' src='https://www.filmtono.com/build/img/confirm-account.webp' alt='confirm account' />";

         $contenido .= "<div class='background' style='max-width:400px; background-color: #dedede; padding: 20px 20px 10px 20px;'>";

         $contenido .= "<div class='content' style='background-color: #fff;      padding: 20px; margin:-20% auto auto auto;'>";

         $contenido .= "<h1 style='color: #FD9526; font-weight: 900;             text-align: center; margin-top: 5px;'>Welcome to Filmtono!</h1>";

         $contenido .= "<h2 style='color:black; font-weight:bold;'>Hi " . $this->nombre .  "</h2>";

         $contenido .= "<p style='color:black;'>We need to verify your email to give you access to the most creative musical supervision</p>";

         $contenido .= "<p style='color:black;'>To confirm your account click here:</p>";

         $contenido .= "<a style='background-color: #FD9526; color: #292B3F;     padding: 10px 20px; border-radius: 10px; margin: 10px auto;         text-decoration: none; font-weight: bold; display: block;           width: fit-content;' href='https://filmtono.com/confirm-account?token=" . $this->token . "'>Confirm Account</a>";

         $contenido .= "</div>";

         $contenido .= "<div class='footer' style='margin: -40px auto auto auto';>";       

         $contenido .= "<p style='color:black;'>If you did not create this account you can ignore this message</p>";

         $contenido .= "<p style='color:black;'>Regards,</p>";

         $contenido .= "<p style='color:black;'><span style='margin-top:25px; font-weight: bold; display:block;'>Filmtono Team</span></p>";

         $contenido .= "</div>";

         $contenido .= "</div>";

         $contenido .= "</div>";

         $contenido .= "</body>";

         $contenido .= '</html>';

         $mail->Body = $contenido;

         //Enviar el mail
         $mail->send();

    }

    public function enviarConfirmacionEs() {

        // create a new object
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
    
        $mail->setFrom('no-reply@filmtono.com');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Activa tu cuenta Filmtono';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<style>
                        body{
                            font-family: 'Roboto', sans-serif;
                            line-height: 1.2;
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
                            transform: translateY(-20%);
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
                        .footer{
                            margin-top: -40px;
                        }
                        p span{
                            font-weight: bold;
                            display: block;
                            margin-top: 25px;
                            color: black;
                        }
                    </style>";
        $contenido .= "<body style='max-width:400px'>";

        $contenido .= "<div class='center' style='max-width:400px; margin:auto; display:block;'>";

        $contenido .= "<img style='max-width:400px' src='https://www.filmtono.com/build/img/confirm-account.webp' alt='confirm account' />";
        $contenido .= "<div class='background' style='max-width:400px; background-color: #dedede; padding: 20px 20px 10px 20px;'>";

        $contenido .= "<div class='content' style='background-color: #fff;      padding: 20px; margin:-20% auto auto auto;'>";

        $contenido .= "<h1 style='color: #FD9526; font-weight: 900;             text-align: center; margin-top: 5px;'>¡Bienvenido(a) a Filmtono!</h1>";

        $contenido .= "<h2 style='color:black; font-weight:bold;'>Hola " . $this->nombre .  "</h2>";

        $contenido .= "<p style='color:black;'>Necesitamos verificar tu correo electrónico para darte acceso a la supervisión musical más creativa</p>";

        $contenido .= "<p style='color:black;'>Para confirmar tu cuenta haz click aquí:</p>";

        $contenido .= "<a style='background-color: #FD9526; color: #292B3F;     padding: 10px 20px; border-radius: 10px; margin: 10px auto;         text-decoration: none; font-weight: bold; display: block;           width: fit-content;' href='https://filmtono.com/confirm-account?lang=es&token=" . $this->token . "'>Confirmar Cuenta</a>";

        $contenido .= "</div>";

        $contenido .= "<div class='footer' style='margin: -40px auto auto auto';>";

        $contenido .= "<p style='color:black;'>Si tú no creaste esta cuenta; puedes ignorar el mensaje</p>";

        $contenido .= "<p style='color:black;'>Saludos,</p>";

        $contenido .= "<p style='color:black;'><span style='margin-top:25px; font-weight: bold; display:block;'>El equipo de Filmtono</span></p>";

        $contenido .= "</div>";
        $contenido .= "</div>";
        $contenido .= "</div>";
        $contenido .= "</body>";
        $contenido .= '</html>';
        $mail->Body = $contenido;
        //Enviar el mail
        $mail->send();

   }

    public function enviarInstrucciones() {

        // create a new object
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
    
        $mail->setFrom('no-reply@filmtono.com');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Restablece tu password';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<style>
                        body{
                            font-family: 'Roboto', sans-serif;
                            line-height: 1.2;
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
                            transform: translateY(-10%);
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
                        .footer{
                            margin-top: -30px;
                        }
                        p span{
                            font-weight: bold;
                            display: block;
                            margin-top: 25px;
                        }
                    </style>";

        $contenido .= "<body style='max-width:400px'>";

        $contenido .= "<div class='center' style='max-width:400px; margin:auto; display:block;'>";

        $contenido .= "<img style='max-width:400px' src='https://www.filmtono.com/build/img/reset-password.webp' alt='reset password' />";

        $contenido .= "<div class='background' style='max-width:400px; background-color: #dedede; padding: 20px 20px 10px 20px;'>";

        $contenido .= "<div class='content' style='background-color: #fff;      padding: 20px; margin:-20% auto auto auto;'>";

        $contenido .= "<h1 style='color: #FD9526; font-weight: 900;             text-align: center; margin-top: 5px;'>Reset your password!</h1>";

        $contenido .= "<h2 style='color:black; font-weight:bold;'>Hi " . $this->nombre .  "</h2>";

        $contenido .= "<p style='color:black;'>You have requested to reset your password</p>";

        $contenido .= "<p style='color:black;'>To do so, click here:</p>";

        $contenido .= "<a style='background-color: #FD9526; color: #292B3F;     padding: 10px 20px; border-radius: 10px; margin: 10px auto;         text-decoration: none; font-weight: bold; display: block;           width: fit-content;' href='https://filmtono.com/reset-password?token=" . $this->token . "'>Reset Password</a>";

        $contenido .= "</div>";

        $contenido .= "<div class='footer' style='margin: -40px auto auto auto';>";

        $contenido .= "<p style='color:black;'>If you did not request this change; you can ignore the message</p>";

        $contenido .= "<p style='color:black;'>Regards,</p>";

        $contenido .= "<p><span style='margin-top:25px; font-weight: bold; display:block'>Filmtono Team</span></p>";

        $contenido .= "</div>";

        $contenido .= "</div>";

        $contenido .= "</div>";

        $contenido .= "</body>";

        $contenido .= '</html>';

        $mail->Body = $contenido;

        //Enviar el mail
        $mail->send();
    }

    public function enviarInstruccionesEs() {

        // create a new object
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
    
        $mail->setFrom('no-reply@filmtono.com');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Restablece tu contraseña';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<style>
                        body{
                            font-family: 'Roboto', sans-serif;
                            line-height: 1.2;
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
                            transform: translateY(-10%);
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
                        .footer{
                            margin-top: -30px;
                        }
                        p span{
                            font-weight: bold;
                            display: block;
                            margin-top: 25px;
                        }
                    </style>";
        $contenido .= "<body style='max-width:400px'>";

        $contenido .= "<div class='center' style='max-width:400px; margin:auto; display:block;'>";

        $contenido .= "<img style='max-width:400px;' src='https://www.filmtono.com/build/img/reset-password.webp' alt='reset password' />";

        $contenido .= "<div class='background' style='max-width:400px; background-color: #dedede; padding: 20px 20px 10px 20px;'>";

        $contenido .= "<div class='content' style='background-color: #fff;      padding: 20px; margin:-20% auto auto auto;'>";

        $contenido .= "<h1 style='color: #FD9526; font-weight: 900; text-align: center; margin-top: 5px;'>¡Reestablece tu contraseña!</h1>";

        $contenido .= "<h2 style='color:black; font-weight:bold;'>Hola " . $this->nombre .  "</h2>";

        $contenido .= "<p style='color:black;'>Has solicitado restablecer tu contraseña</p>";

        $contenido .= "<p style='color:black;'>Para hacerlo, haz click aquí:</p>";

        $contenido .= "<a style='background-color: #FD9526; color: #292B3F; padding: 10px 20px; border-radius: 10px; margin: 10px auto; text-decoration: none; font-weight: bold; display: block; width: fit-content;' href='https://filmtono.com/reset-password?lang=es&token=" . $this->token . "'>Reestablecer Contraseña</a>";

        $contenido .= "</div>";

        $contenido .= "<div class='footer' style='margin: -40px auto auto auto';>";

        $contenido .= "<p style='color:black;'>Si tú no solicitaste este cambio; puedes ignorar el mensaje</p>";

        $contenido .= "<p style='color:black;'>Saludos,</p>";

        $contenido .= "<p style='color:black;'><span style='margin-top:25px; font-weight: bold; display:block'>El equipo de Filmtono</span></p>";

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
<?php

namespace Classes;

use Mpdf\Mpdf;

class MusicalContract{
    public $id_usuario;
    public $empresa;
    public $nombre;
    public $id_fiscal;
    public $direccion;
    public $firma;
    public $pais;
    public $telefono;
    public $email;
    public $fecha;
    public $id_empresa;

    public function __construct($id_usuario, $empresa, $nombre, $id_fiscal, $direccion, $firma, $pais, $telefono, $email, $fecha, $id_empresa){
        $this->id_usuario = $id_usuario;
        $this->empresa = $empresa;
        $this->nombre = $nombre;
        $this->id_fiscal = $id_fiscal;
        $this->direccion = $direccion;
        $this->firma = $firma;
        $this->pais = $pais;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->fecha = date('d-m-y');
        $this->id_empresa = $id_empresa;
    }

    public function guardarContrato(){
        $contract = '<html>
        </head>
            <style>
                .contrato h1{
                    text-align: center;
                    margin: 50px auto;
                }
                .contrato h2{
                    text-align: center;
                    margin: 35px auto;
                }
                .contrato h3{
                    text-align: left;
                    margin: 30px auto;
                }
                .contrato p{
                    text-align: justify;
                    line-height: 1.5;
                }
                .grid-firmas{
                    width: 50%
                    margin: 35px auto;
                    margin: 35px;
                }
                .grid-firmas__campo{
                    border: 2px solid #000;
                    margin: 7px;
                }
                .grid-firmas__campo p{
                    break-inside: avoid;
                    padding: 5px;
                    margin: 0;
                }
                .grid-firmas__campo--span{
                    break-inside: avoid;
                    font-weight: bold;
                }
                .no-display{
                    display: none;
                }
            </style>
        </head>
        </body>';

        $contract .= file_get_contents(__DIR__.'/../views/contracts/c-musical-'.$_SESSION['lang'].'.php');

        if($_SESSION['lang'] == 'en'){
            $contract .= '<div class="grid-firmas">
                        <div class="grid-firmas__campo">
                            <p class="grid-firmas__campo--span" >Authorized representative</p>
                            <p id="contract-empresa">'.$this->empresa.'</p>
                        </div>
                        <div class="grid-firmas__campo">
                            <p class="grid-firmas__campo--span">Main Contact</p>
                            <p id="contract-nombre">'.$this->nombre.'</p>
                        </div>
                        <div class="grid-firmas__campo">
                            <p class="grid-firmas__campo--span">Tax ID</p>
                            <p id="contract-id-fiscal">'.$this->id_fiscal.'</p>
                        </div>
                        <div class="grid-firmas__campo">
                            <p class="grid-firmas__campo--span">Address</p>
                            <p id="contract-direccion">'.$this->direccion.'</p>
                        </div>
                        <div class="grid-firmas__campo">
                            <p class="grid-firmas__campo--span">Signature</p>
                            <img id="signature-img" width="350" src="'.$this->firma.'" alt="signature"/>
                        </div>
                        <div class="grid-firmas__campo">
                            <p class="grid-firmas__campo--span">Country</p>
                            <p id="contract-pais">'.$this->pais.'</p>
                        </div>
                        <div class="grid-firmas__campo">
                            <p class="grid-firmas__campo--span">Phone</p>
                            <p id="contract-telefono">'.$this->telefono.'</p>
                        </div>
                        <div class="grid-firmas__campo">
                            <p class="grid-firmas__campo--span">Email</p>
                            <p id="contract-email">'.$this->email.'</p>
                        </div>
                    </div>';
        } else {
            $contract .= '<div class="grid-firmas">
                        <div class="grid-firmas__campo">
                            <p class="grid-firmas__campo--span" >Representante Autorizado</p>
                            <p id="contract-empresa">'.$this->empresa.'</p>
                        </div>
                        <div class="grid-firmas__campo">
                            <p class="grid-firmas__campo--span">Contacto Principal</p>
                            <p id="contract-nombre">'.$this->nombre.'</p>
                        </div>
                        <div class="grid-firmas__campo">
                            <p class="grid-firmas__campo--span">ID Fiscal</p>
                            <p id="contract-id-fiscal">'.$this->id_fiscal.'</p>
                        </div>
                        <div class="grid-firmas__campo">
                            <p class="grid-firmas__campo--span">Dirección</p>
                            <p id="contract-direccion">'.$this->direccion.'</p>
                        </div>
                        <div class="grid-firmas__campo">
                            <p class="grid-firmas__campo--span">Firma</p>
                            <img id="signature-img" width="350" src="'.$this->firma.'" alt="signature"/>
                        </div>
                        <div class="grid-firmas__campo">
                            <p class="grid-firmas__campo--span">País</p>
                            <p id="contract-pais">'.$this->pais.'</p>
                        </div>
                        <div class="grid-firmas__campo">
                            <p class="grid-firmas__campo--span">Teléfono</p>
                            <p id="contract-telefono">'.$this->telefono.'</p>
                        </div>
                        <div class="grid-firmas__campo">
                            <p class="grid-firmas__campo--span">Email</p>
                            <p id="contract-email">'.$this->email.'</p>
                        </div>
                    </div>';
        }
                 
        $contract .= '</body>
        </html>';
        
        //$mpdf = new \Mpdf\Mpdf();
        $mpdf = new \Mpdf\Mpdf(['contracts' => '../public/contracts/']);  
        $mpdf->WriteHTML($contract);
        $mpdf->OutputFile('../public/contracts/'.$this->id_usuario.'-'.$this->id_empresa.'-music-'.date('d-m-y').'.pdf');
    }
}
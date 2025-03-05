<?php

namespace Model;

class ActiveRecord{
     //Base de Datos
     protected static $db;
     protected static $columnasDB = [];
     protected static $tabla = '';
 
     //Errores - Validación
     protected static $alertas = [];
     
    
     //Definir la conexión a la BD
     public static function setDB($database){
         self::$db = $database;
     }

     // Setear un tipo de Alerta
    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }

    // Obtener las alertas
    public static function getAlertas() {
        return static::$alertas;
    }
    
    // Validación que se hereda en modelos
    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    // Consulta SQL para crear un objeto en Memoria (Active Record)
    public static function consultarSQL($query) {
        // Consultar la base de datos
        //debugging($query);
        $resultado = self::$db->query($query);
        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }
        // liberar la memoria
        $resultado->free();

        // retornar los resultados
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    public function sincronizar($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = trim($value);
          }
        }
    }

    // Registros - CRUD
    public function guardar() {
        $resultado = '';
        if(!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    // Obtener todos los Registros
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE id = ${id}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Obtener Registros con cierta cantidad
    public static function get($limite) {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id LIMIT ${limite}" ;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function getOrdered($limite, $col, $sense) {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY ${col} ${sense} LIMIT ${limite}" ;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busqueda Where con Columna 
    public static function where($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} = '${valor}'";
        //debugging($query);
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado );
    }

    // Busqueda Where con Columna 
    public static function whereAll($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} = '${valor}'";
        //debugging($query);
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function whereOrdered($columna, $valor, $col) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} = '${valor}'". " ORDER BY ${col} ASC";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function whereAdmin($columna, $valor, $valor2) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} = '${valor}' OR ${columna} = '${valor2}'";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function unionTables($tabla1, $tabla2){
        $query = "SELECT * FROM " . $tabla1 . " UNION SELECT * FROM " . $tabla2;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function innerJoin($tabla1, $tabla2, $col1, $col2){
        $query = "SELECT ".$tabla1.".*". "FROM " . $tabla1 . " INNER JOIN " . $tabla2 . " ON " . $tabla1 . "." . $col1 . " = " . $tabla2 . "." . $col2;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function innerJoinWhere($tabla1, $tabla2, $col1, $col2){
        $query = "SELECT ".$tabla1.".*". "FROM " . $tabla1 . " INNER JOIN " . $tabla2 . " ON " . $tabla1 . "." . $col1 . " = " . $tabla2 . "." . $col2 . " WHERE " . $tabla2 . $col2 . " = " . $col2;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }


    public static function innerJoinAll($tabla1, $tabla2, $col1, $col2){
        $query = "SELECT * FROM " . $tabla1 . " INNER JOIN " . $tabla2 . " ON " . $tabla1 . "." . $col1 . " = " . $tabla2 . "." . $col2;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
 
    //Crea un nuevo registro
    public function crear() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = "INSERT INTO " . static::$tabla . " (";
        $query .= join(', ', array_keys($atributos));
        $query .= ") VALUES ('"; 
        $query .= join("', '", array_values($atributos));
        $query .= "')";

        //debugging($query); // Descomentar si no te funciona algo

        // Resultado de la consulta
        $resultado = self::$db->query($query);
        return [
           'resultado' =>  $resultado,
           'id' => self::$db->insert_id
        ];
    }
 
    // Actualizar el registro
    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(', ', $valores );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        // Actualizar BD
        $resultado = self::$db->query($query);
        return $resultado;
    }
 
     //Eliminar un registro
     public function eliminar(){        
         $query = "DELETE FROM ". static::$tabla ." WHERE id =".self::$db->escape_string($this->id)." LIMIT 1" ;
         $resultado = self::$db->query($query);
         return $resultado;
     }

     // Subida de archivos
     public function setImagen($imagen){
         //Elimina la imagen previa
         if(!is_null($this->id)){
             $this->borrarImagen();            
         }
         //Asignar el nombre de la imagen al atributo
         if($imagen){
             $this->imagen = $imagen;
         }
     }

     public function setDocumento($documento){
        //Elimina el documento previo
        if(!is_null($this->id)){
            $this->borrarDocumento();            
        }
        //Asignar el nombre del documento al atributo
        if($documento){
            $this->documento = $documento;
        }
    }
 
     //Eliminar la imagen
     public function borrarImagen(){
         $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
             if($existeArchivo){
                 unlink(CARPETA_IMAGENES . $this->imagen);
             } 
     }

     //Eliminar el archivo
     public function borrarDocumento(){
        $existeDoc = file_exists(CARPETA_DOCS . $this->documento);
        if($existeDoc){
            unlink(CARPETA_DOCS . $this->documento);
        } 
    }
 
 
     public static function allOrderBy($orden){
        $query = "SELECT * FROM " . static::$tabla. " ORDER BY $orden";
        
        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    public static function allByCol($col){
        $query = "SELECT $col FROM " . static::$tabla;
        
        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    public function enviarMensaje(){
        $atributos = $this->sanitizarAtributos();

        // $string = join(', ',array_values($atributos));
        // debugging($string);

        $query = "INSERT INTO ".  static::$tabla. "(";
        $query.= join(', ',array_keys($atributos));
        $query.= ") VALUES('";
        $query.= join("', '", array_values($atributos));
        $query.= "')";

        $resultado = self::$db->query($query);

        // if($resultado){
        //    header('Location: /contacto');
        // }
    }

    public function eliminarMensaje(){        
        $query = "DELETE FROM ". static::$tabla ." WHERE id =".self::$db->escape_string($this->id)." LIMIT 1" ;

        $resultado = self::$db->query($query);

        if($resultado){
            header('location: /inbox?resultado=4');
        }
    }

    public static function allOrderDesc($orden){
        $query = "SELECT * FROM " . static::$tabla. " ORDER BY $orden DESC";
        
        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    public static function allOrderAsc($orden){
        $query = "SELECT * FROM " . static::$tabla. " ORDER BY $orden ASC";
        
        $resultado = self::consultarSQL($query);

        return $resultado;
    }
}
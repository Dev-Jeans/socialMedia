<?php
class util_functions{

    public static function resultado_humanizado($resultado){
        if($resultado == true){
            return "Realizado correctamente";
        }else{
            return "Error al realizarlo";
        }
    }

    public static function fecha_to_sql($cadena){
        $fecha_sql = explode("-", strval($cadena));
        return $fecha_sql[2]."-".$fecha_sql[1]."-".$fecha_sql[0];
    }

    public static function is_date_validateFormatXLS($cadena){ //jeans cuba
       $pattern = '/^([0-2][0-9]|3[0-1])(\/)(0[1-9]|1[0-2])\2(\d{4})$/'; // expresion regular fecha formato 'dd/mm/yyyy'
       $subject = $cadena;
       if (preg_match($pattern,$subject)) {
           $date = explode('/',$subject);
           if (count($date) == 3 && checkdate($date[1],$date[0],$date[2])) {
               return true;
           }else {
               return false;
           }
       }else {
           return false;
       }
    }

    public static function  is_validate_email($email){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }else{
            return false;
        }
    }

    public static function is_convert_date($cadena){
        $date = explode("/", strval($cadena));
        return $date[2]."-".$date[1]."-".$date[0];
    }


    public static function is_estado_validate($cadena){
        if ($cadena == "1" || $cadena == "0"){
            return 1;
        }else{
            return 0;
        }
    }

    public static function is_booleano_validate($cadena){
        if ($cadena == "SI" || $cadena == "NO" || $cadena == 0 || $cadena == 1){
            return true;
        }else{
            return false;
        }
    }

    public static function is_convert_booleano($cadena){
        if ($cadena == "SI"){
            return 1;
        }elseif ($cadena == "NO") {
            return 0;
        }
    }

    public static function is_numero_validate($cadena){
        return is_numeric($cadena);
    }

    public static function is_cadena_validate($candena){
        return is_string($candena);
    }
  
    public static function is_precio_validate($cadena){
        $validador = 0;
        for ($i =0 ; $i < strlen($cadena); $i++){
            if($cadena[$i] == ","){
                $validador += 1;
            }
        }

        if($validador > 1){
            $validador = 0;
        }

        return $validador;
    }

    public static function is_valor_validate($cadena){
        $validador = 0;
        for ($i=0; $i < strlen($cadena); $i++) { 
            if ($cadena[$i] == "," || $cadena[$i] == ";") {
                $validador += 1;
            }
        }

        if($validador > 1){
            $output = false;
        }else{
            $output = true;
        }

        return $output;
       
    }

    public static function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();
       
        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    public static function filter_array($array,$key,$key_value) {
        $temp_array = array();
       
        foreach($array as $val) {
            if ($val[$key] == $key_value) {
               array_push($temp_array,$val);
            }
        }
        return $temp_array;
    }


    public static function find_coods_multi3_array($array, $key, $key_value) {
        $coord = array();
        foreach($array as $x => $row) {
            foreach($row as $y => $val) {
                if($val[$key] == $key_value){
                    array_push($coord,$x);
                    array_push($coord,$y);
                    return $coord;
                };
            }
        }
        return false;
    }

    public static function is_date_validate($cadena){
        $validador = 0;
        for ($i =0 ; $i < strlen($cadena); $i++){
            if($cadena[$i] == "-"){
                $validador += 1;
            }
        }

        if($validador == 2){
            $validador = 1;
        }else{
            $validador = 0;
        }
        
        return $validador;
    }

    

    public static function rutaRespaldoImagen()
    {
        return "assets/upload/producto_eli/";
    }

    public static function rutaImagenRepoMinificada()
    {
        return "assets/upload/producto/";
    }

    public static function rutaTexturaRepoMinificada()
    {
        //return "assets/upload/textura_eli/";
        return "assets/upload/textura/";
    }
    
    public static function existeLaImagen($ruta_imagen)
    {
        if (file_exists($ruta_imagen)) {
            return true;
        } else {
            return false;
        }
    }

    public static function extensionImgPermitida($extension)
    {
        if (
            $extension == "jpg" || $extension == "png" || $extension == "gif" || $extension == "JPG" || $extension == "PNG" ||
            $extension == "GIF" || $extension == "bmp" || $extension == "BMP" || $extension == "JPEG" || $extension == "jpeg"
        ) {
            return true;
        } else {
            return false;
        }
    }

    public static function tamanioImgPermitida($tamanio)
    {
        if ($tamanio < 9000000000000) {
            return true;
        } else {
            return false;
        }
    }

    public static function mi_utf8ize($d) {
        if (is_array($d)) {
            foreach ($d as $k => $v) {
                $d[$k] = self::mi_utf8ize($v);
            }
        } else if (is_string($d)) {
            return utf8_encode($d);
        }
        return $d;
    }

    public static function mi_utf8ize_2($d) {
        if (is_array($d)) 
            foreach ($d as $k => $v) 
                $d[$k] = self::mi_utf8ize_2($v);
    
         else if(is_object($d))
            foreach ($d as $k => $v) 
                $d->$k = self::mi_utf8ize_2($v);
    
         else 
            return utf8_encode($d);
    
        return $d;
    }

    public static function cleanInput($input)
    {
        $search = array(
            '@<script[^>]*?>.*?</script>@si',   // Elimina javascript
            '@<[\/\!]*?[^<>]*?>@si',            // Elimina las etiquetas HTML
            '@<style[^>]*?>.*?</style>@siU',    // Elimina las etiquetas de estilo
            '@<![\s\S]*?--[ \t\n\r]*>@'         // Elimina los comentarios multi-l??nea
        );

        $output = preg_replace($search, '', $input);
        return $output;
    }

    public static function cleanSpecialChars($texto){
        $texto = str_replace( array("\\","??", "??", "|", "'","[", "]","{","}", "????", "~", "*", "??", "???", "=", "_","<" ,"??","??","??","?","??","??","???","??","??","??","???","???"), " ", $texto);

        $texto = str_replace(
            array('??', '??', '??', '??', '??', '??', '??', '??', '??', "????",),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A', 'a',),
            $texto
        );

        $texto = str_replace(
            array('??', '??', '??', '??', '??', '??', '??', '??',"????", "?????"),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E',"e", "E"),
            $texto
        );

      
        $texto = str_replace(
            array('??', '??', '??', '??', '??', '??', '??', '??', "???? i", "????"),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I', "i", "I"),
            $texto
        );

        $texto = str_replace(
            array('??', '??', '??', '??', '??', '??', '??', '??', "????", "?????"),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O', "o", "O"),
            $texto
        );

        $texto = str_replace(
            array('??', '??', '??', '??', '??', '??', '??', '??', "????", "????"),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U', "u", "U"),
            $texto
        );
        
        $texto = str_replace(
            array('??', '??', '??', '??', "????", "?????"),
            array('n', 'N', 'c', 'C', "n", "N"),
            $texto
        );

        $texto = str_replace(
            array("\\", "??", "??", "~", 
                    // "-",
                 "#", "@", "|", "!", "\"",
                 "??", "$", "%", "&", "/",
                 "(", ")", "?", "'", "??",
                 "??", "[", "^", "`", "]",
                 "+", "}", "{", "??", "??",
                 ">", "< ", ";", ",", ":",
                 "."),
            '',
            $texto
        );

    return $texto;
  }


    public static function urls_amigables($url)
    {
        $url = strtolower($url);
        $find = array('??', '??', '??', '??', '??', '??');
        $repl = array('a', 'e', 'i', 'o', 'u', 'n');

        $url = str_replace($find, $repl, $url);

        $find = array(' ', '&', '\r\n', '\n', '+');
        $url = str_replace($find, '-', $url);

        $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');

        $repl = array('', '-', '');

        $url = preg_replace($find, $repl, $url);

        return $url;
    }
}
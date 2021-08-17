<?php
class usuario{
    private $cn = null;

    public function __construct($conexion){ $this->cn = $conexion; }

    public function loginUsuario($email,$password){

        $consulta = "SELECT IDcliente FROM clientes WHERE email='$email' AND password='$password' AND estado=1";

        try{
            $sql = $this->cn->query($consulta);
            if($sql){
                if($sql->num_rows>0){
                    return $sql -> fetch_assoc();
                }else{
                    return 0;
                }
            }else{
                return -1;
            }
        } catch (Exception $e){
           return -1;
        }
    }

    public function loginRS(string $email,string $IDaccount,string $redSocial){
        $consulta="SELECT IDcliente,IDfacebook,IDgoogle,email FROM clientes 
                   WHERE ";

        if ($redSocial == 'facebook') { $consulta .= "IDfacebook = '$IDaccount' OR email = '$email'"; }
        if ($redSocial == 'google') { $consulta .= "IDgoogle = '$IDaccount' OR email = '$email'"; }

        var_dump($consulta);
        try{
            $sql = $this->cn->query($consulta);
            if($sql){
                if($sql->num_rows>0){
                    return $sql -> fetch_assoc();
                }else{
                    return 0;
                }
            }else{
                return -1;
            }
        } catch (Exception $e){
           return -1;
        }
    }
    public function getDuplicate($email){

        $consulta = "SELECT COUNT(IDcliente) AS total FROM clientes WHERE email='$email' AND estado=1";

        try {
            $sql = $this->cn->query($consulta);
            if($sql){
                return $sql -> fetch_row();
            }else{
                return -1;
            }
        } catch (Exception $e){
            return -1;
        }
    }

    public function getUserByEmail($email){

        $consulta = "SELECT * FROM clientes WHERE email='$email' AND estado=1";

        try{
            $sql = $this->cn->query($consulta);
            if($sql){
                if($sql->num_rows>0){
                    return $sql -> fetch_assoc();
                }else{
                    return 0;
                }
            }else{
                return -1;
            }
        } catch (Exception $e){
           return -1;
        }
    }

    public function register($nombres,$apellidos,$email,$password){

        $result = $this->getDuplicate($email);

        if($result[0]==0){
            $consulta = "INSERT INTO clientes (nombres,apellidos,email,password) VALUES ('$nombres','$apellidos','$email','$password')";

            try {
                $sql = $this->cn->query($consulta);
                
                if($sql){//si se inserto correctamente
                    return 1;
                }else{
                    return -1;// Retorna codigo de fallo
                }
            } catch (Exception $e) {
                return -1;// Retorna codigo de fallo
            }
        }elseif($result==-1){//si hubo un error en la cunsulta
            return -1;// Retorna codigo de fallo
        }else{
            return 0;//si ya existen mas de 0 registros
        }
    }

    public function deleteResetPasswordPetitionUsuario($email) {
        $consulta = "DELETE FROM pwdreset WHERE pwdResetEmail='$email';";

        try {
            $sql = $this->cn->query($consulta);
            
            if($sql){
                return 1;
            }else{
                return -1;
            }
        } catch (Exception $e) {
            return -1;
        }
    }

    public function processResetPasswordPetitionUsuario($email,$selector,$token,$expires) {
        $result = $this->deleteResetPasswordPetitionUsuario($email);
        if($result!=-1){
            $consulta = "INSERT INTO pwdreset (pwdResetEmail,pwdResetSelector,pwdResetToken,pwdResetExpires) VALUES ('$email','$selector','$token',$expires);";
            try {
                $sql = $this->cn->query($consulta);
                if($sql){
                    return 1;
                }else{
                    return -1;
                }
            } catch (Exception $e) {
                return -1;
            }
        }else{
            return -1;
        }
    }

    public function getRecoveryUsuario($selector,$expires){
        $consulta = "SELECT * FROM pwdreset WHERE pwdResetSelector='$selector' AND pwdResetExpires>='$expires';";

        try{
            $sql = $this->cn->query($consulta);
            if($sql){
                if($sql->num_rows>0){
                    return $sql -> fetch_assoc();
                }else{
                    return 0;
                }
            }else{
                return -1;
            }
        } catch (Exception $e){
           return -1;
        }
    }

    public function passCartToSession($IDsesion,$IDcliente){

        $consulta = "UPDATE proceso_compra SET IDcliente=$IDcliente WHERE IDsesion='$IDsesion' AND mercado_pago IS NULL AND estado=1";

        try{
            $sql = $this->cn->query($consulta);
            if($sql){
                return true;
            }else{
                return false;
            }
        } catch (Exception $e){
           return false;
        }
    }

    public function getDataClient($IDcliente){
        $consulta="SELECT *,(SELECT GROUP_CONCAT(IDtdocumento,'-',tipo) from tipo_documento  where IDtdocumento<>6)AS documento 
        FROM clientes WHERE IDcliente = $IDcliente GROUP BY IDcliente LIMIT 1;";
        
        try{
            $sql = $this->cn->query($consulta);
            if($sql){
                if($sql->num_rows>0){
                    return $sql -> fetch_assoc();
                }else{
                    return 0;
                }
            }else{
                return -1;
            }
        } catch (Exception $e){
           return -1;
        }
    }

    public function updateDataClient($IDcliente,$IDtdocumento,$nombres,$apellidos,$fnacimiento,$ndocumento,$celular){
        
        $consulta="UPDATE clientes SET IDtdocumento = $IDtdocumento,nombres = '$nombres',
                    apellidos = '$apellidos', ndocumento = '$ndocumento',celular = '$celular' ";
        if($fnacimiento!=''){
            $consulta.=" , fnacimiento = '$fnacimiento' ";
        }
        $consulta.=" WHERE IDcliente=$IDcliente ";
 
        try {
            $sql = $this->cn->query($consulta);
            
            if($sql){
                return 1;
            }else{
                return -1;
            }
        } catch (Exception $e) {
            return -1;
        }
    }

    public function updatePasswordClient($IDcliente,$password){
        $consulta="UPDATE clientes SET password = '$password' WHERE IDcliente =$IDcliente";
            
        try {
            $sql = $this->cn->query($consulta);
            
            if($sql){
                return 1;
            }else{
                return -1;
            }
        } catch (Exception $e) {
            return -1;
        }
    }
    
    public function getAddresByIdCliente($IDcliente,$IDdepartamentoU,$IDprovinciaU,$IDlocalidadU){
        $consulta = "SELECT * FROM clientes_direccion WHERE estado=1 AND IDcliente=$IDcliente ";
        if($IDdepartamentoU!=''&&$IDprovinciaU!=''&&$IDlocalidadU!=''){
            $consulta .= "AND IDdepartamentoU='$IDdepartamentoU' AND IDprovinciaU='$IDprovinciaU' AND IDlocalidadU='$IDlocalidadU' ";
        }
        $consulta .= " ORDER BY nombre ASC;";

        try{
            $sql = $this->cn->query($consulta);
            if($sql){
                if($sql->num_rows>0){
                    return $sql->fetch_all(MYSQLI_ASSOC);
                }else{
                    return 0;
                }
            }else{
                return -1;
            }
        } catch (Exception $e){
           return -1;
        }
    }

    public function registerClientAddress($IDcliente,$nombre,$direccion,$referencia,$IDdepartamentoU,$IDprovinciaU,$IDlocalidadU){
        $consulta = "INSERT INTO clientes_direccion (IDcliente,nombre,direccion,referencia,IDdepartamentoU,IDprovinciaU,IDlocalidadU) 
                    VALUES ($IDcliente,'$nombre','$direccion','$referencia','$IDdepartamentoU','$IDprovinciaU','$IDlocalidadU')";
        try {
            $sql = $this->cn->query($consulta);
            if($sql){
                return  $this->cn->insert_id;
            }else{
                return -1;
            }
        } catch (Exception $e) {
            return -1;
        }
    }

    public function updateClientAddress($IDcliente,$nombre,$direccion,$referencia,$IDdepartamentoU,$IDprovinciaU,$IDlocalidadU,$IDdireccion){
        $consulta = "UPDATE clientes_direccion SET nombre='$nombre',direccion='$direccion',
                    referencia='$referencia', IDdepartamentoU='$IDdepartamentoU', 
                    IDprovinciaU='$IDprovinciaU', IDlocalidadU='$IDlocalidadU' 
                    WHERE IDcliente=$IDcliente AND IDdireccion=$IDdireccion AND estado=1;";

        try {
            $sql = $this->cn->query($consulta);
            if($sql){
                return 1;
            }else{
                return -1;
            }
        } catch (Exception $e) {
            return -1;
        }
    }

    public function deleteClientAddress($IDdireccion){
        $consulta = "DELETE FROM clientes_direccion WHERE IDdireccion=$IDdireccion AND estado=1;";

        try {
            $sql = $this->cn->query($consulta);
            if($sql){
                return 1;
            }else{
                return -1;
            }
        } catch (Exception $e) {
            return -1;
        }
    }

    public function updateClientNewsletter($IDcliente,$newsletter){

        $consulta = "UPDATE clientes SET newsletter=$newsletter WHERE IDcliente=$IDcliente AND estado=1";

        try {
            $sql = $this->cn->query($consulta);
            
            if($sql){
                return 1;
            }else{
                return -1;
            }
        } catch (Exception $e) {
            return -1;
        }
    }

    public function listFavorite($IDcliente){
        $consulta = "SELECT
            fav.IDfavorito,
            pro.*,
            ( SELECT img FROM productos_img WHERE codigoERP AND orden = 1 AND codigoERP = pro.codigoERP )AS IMG1,
            ( SELECT img FROM productos_img WHERE codigoERP AND orden = 2 AND codigoERP = pro.codigoERP )AS IMG2 
        FROM
            productos_favoritos AS fav
            LEFT JOIN productos AS pro ON fav.codigoERP = pro.codigoERP 
        WHERE
            IDcliente = $IDcliente;";

        try {
            $sql = $this->cn->query($consulta);
            if($sql){
                return $sql->fetch_all(MYSQLI_ASSOC);
            }else{
                return -1;
            }
        } catch (Exception $e) {
            return -1;
        }
    }














 

    // public function update_password($IDcliente,$new_password){
    //     $consulta = "UPDATE clientes SET password='$new_password' WHERE IDcliente=$IDcliente AND estado=1";

    //     try {
    //         $sql = $this->cn->query($consulta);
    //         if($sql){
    //             return 1;
    //         }else{
    //             return -1;
    //         }
    //     } catch (Exception $e) {
    //         return -1;
    //     }
    // }
}
?>
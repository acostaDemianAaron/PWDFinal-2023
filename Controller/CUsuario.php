<?php

include_once '../Config/config.php';

class CUsuario
{
    public function Login($data)
    {
        $res = ['messageErr' => "?messageErr=", 'messageOk' => "?messageOk="];
        // Instanciar objetos necesarios
        $sesion = new Session();
        $abmUsuario = new ABMUsuario();
        $user = $abmUsuario->Search($data);
        if (count($user) > 0) {
            $userName = $user[0];
            if ($userName->getUsDeshabilitado() == '0000-00-00 00:00:00') {
                $sesion->Start($data['usnombre'], $data['uspass']);
                list($sesionStar, $error) = $sesion->Verify();
                if (!$sesionStar) {
                    $sesion->Close();
                    $res['messageErr'] .= urlencode("Error en el inicio de sesión");
                } else {
                    $res['messageOk'] .= urlencode("Sesión iniciada");
                }
            } else {
                $res['messageErr'] .= urlencode("Usuario deshabilitado");
            }
        } else {
            $res['messageErr'] .= urlencode("Usuario y/o contraseña incorrectos");
        }
        return $res;
    }
}

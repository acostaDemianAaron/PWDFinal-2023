<?php
class CUsuario
{
    public function Login($data)
    {
        $res = ['msgError' => "?msgError=", 'msg' => "?msg="];
        // Instanciar objetos necesarios
        $sesion = new Session();
        $abmUsuario = new ABMUsuario();
        $data['uspass'] = hash("SHA512/256", $data['uspass']);

        $user = $abmUsuario->Search($data);
        if (count($user) > 0) {
            $userName = $user[0];
            if ($userName->getUsDeshabilitado() == null) {
                $sesion->Start($data['usnombre'], $data['uspass']);
                list($sesionStar, $error) = $sesion->Verify();
                if (!$sesionStar) {
                    $sesion->Close();
                    $res['msgError'] .= urlencode("Error en el inicio de sesión");
                } else {
                    session_id($sesionStar['usnombre']);
                    $res['msg'] .= urlencode("Sesión iniciada");
                }
            } else {
                echo($userName->getUsDeshabilitado());
                die();

                $res['msgError'] .= urlencode("Usuario deshabilitado");
            }
        } else {
            $res['msgError'] .= urlencode("Usuario y/o contraseña incorrectos");
        }
        return $res;
    }

}

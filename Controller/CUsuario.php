<?php
class CUsuario
{
    public function Login($data)
    {
        $res = ['msgError' => "?msgError=", 'msg' => "?msg="];
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
                    $res['msgError'] .= urlencode("Error en el inicio de sesión");
                } else {
                    $res['msg'] .= urlencode("Sesión iniciada");
                }
            } else {
                $res['msgError'] .= urlencode("Usuario deshabilitado");
            }
        } else {
            $res['msgError'] .= urlencode("Usuario y/o contraseña incorrectos");
        }
        return $res;
    }

}

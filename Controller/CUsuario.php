<?php
class CUsuario
{
    public function Login($data)
    {
        $res = FALSE;
        $sesion = new Session();
        $abmUsuario = new ABMUsuario();
        $data['uspass'] = hash("SHA512/256", $data['uspass']);

        $user = $abmUsuario->Search($data);
        if (count($user) > 0) {
            $userName = $user[0];
            if ($userName->getUsDeshabilitado() == NULL) {
                $sesion->Start($data['usnombre'], $data['uspass']);
                $sesionStar =  $sesion->Verify();
                if (!$sesionStar) {
                    $sesion->close();
                    //Error en el inicio de sesión
                    $res =  FALSE;
                } else {
                    session_id($sesionStar['usnombre']);
                    //Sesión iniciada
                    $res =  TRUE;
                }
            } else {
                echo ($userName->getUsDeshabilitado());
                //Usuario deshabilitado
                $res =  FALSE;
            }
        } else {
            //Usuario y/o contraseña incorrectos
            $res =  FALSE;
        }
        return $res;
    }
}

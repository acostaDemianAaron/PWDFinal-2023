<?php

class Session
{
    private $idUsuario;
    private $usNombre;
    private $usPass;
    private $rol;

    //Magic Methods
    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }


    //Setters
    public function setIdUsuario($idUsuario)
    {
        $_SESSION['idusuario'] = $idUsuario;
    }

    public function setUsPass($usPass)
    {
        $_SESSION['uspass'] = $usPass;
    }

    public function setUsNombre($usNombre)
    {
        $_SESSION['usnombre'] = $usNombre;
    }

    public function setRol($rol)
    {
        $_SESSION['rol'] = $rol;
    }


    //Getters
    public function getIdUsuarioSession()
    {
        return $_SESSION['idusuario'];
    }

    public function getUsPassSession()
    {
        return $_SESSION['uspass'];
    }

    public function getUsNombreSession()
    {
        return $_SESSION['usnombre'];
    }

    public function getRolSession()
    {
        return $_SESSION['rol'];
    }


    //Methods
    public function Start($usNombre, $usPass)
    {
        $this->setUsNombre($usNombre);
        $this->setUsPass($usPass);
    }

    public function Verify()
    {

        $success = FALSE;
        $user = $this->getUsNombreSession();
        $pass = $this->getUsPassSession();
        $abmUsuario = new ABMUsuario();
        $where = ['usnombre' => $user, 'uspass' => $pass];
        $userList = $abmUsuario->Search($where);
        if (empty($userList)) {
            //Usuario y/o contraseña incorrecto!
            $success = FALSE;
        } else {
            $userName = $userList[0];
            $fechaDes = $userName->getUsDeshabilitado();
            if ($fechaDes != null) {
                //Este usuario se encuentra deshabilitado!
                $success = FALSE;
            } else {
                $success = TRUE;
                $this->setIdUsuario($userName->getIdUsuario());

                $abmUsuarioRol = new ABMUsuarioRol();
                $userRolList = $abmUsuarioRol->Search(['idusuario' => $userName->getIdUsuario()]);

                if (!empty($userRolList)) {
                    $this->setRol([$userRolList[0]->getObjRol()->getIdRol()]);
                }
            }
        }
        return $success;
    }

    public function getUser()
    {
        if (isset($_SESSION['idusuario'])) {
            $abmUsuario = new ABMUsuario();
            $where = ['idusuario' => $_SESSION['idusuario']];
            try {
                $datUser = $abmUsuario->Search($where);
                return $datUser[0] ?? null;
            } catch (Exception $e) {
                error_log("Error al buscar usuario: " . $e->getMessage());
            }
        }
        return null;
    }

    public function onSession()
    {
        $on = FALSE;
        if (isset($_SESSION['usnombre'])) {
            $on = TRUE;
        }
        return $on;
    }

    public function close()
    {
        session_unset();
        session_destroy();
    }
}

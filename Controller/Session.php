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
        if (!array_key_exists('idusuario', $_SESSION)) {
            // echo "started session"; 
            // session_start();
        }
    }


    //Setters
    public function setIdUsuario($idUsuario)
    {
        $_SESSION['idusuario'] = $idUsuario;
    }

    public function setUsPass($usPass)
    {
        $this->usPass = $usPass;
    }

    public function setUsNombre($usNombre)
    {
        $this->usNombre = $usNombre;
    }

    public function setRol($rol)
    {
        $this->rol = $rol;
    }


    //Getters
    public function getIdUsuarioSession()
    {
        return $_SESSION['idusuario'];
    }

    public function getUsPassSession()
    {
        return $this->usPass;
    }

    public function getUsNombreSession()
    {
        return $this->usNombre;
    }

    public function getRolSession()
    {
        return $this->rol;
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

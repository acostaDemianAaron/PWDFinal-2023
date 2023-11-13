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


        // print_r($userList);
        // die();


        $error = "";

        if (empty($userList)) {
            $error .= "Usuario y/o contraseña incorrecto!";
        } else {
            $userName = $userList[0];
            $fechaDes = $userName->getUsDeshabilitado();

            if ($fechaDes != null) {
                $error .= "Este usuario se encuentra deshabilitado!";
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
        return [$success, $error];
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

    // private $objUsuario;

    // //Magic Methods
    // public function __construct()
    // {
    //     session_start();
    //     $this->setObjUsuario(new ABMUsuario());

    //     // Verifica si existe un nombre de usuario en la sesión
    //     if (isset($_SESSION["usnombre"])) {
    //         $usNombre["usnombre"] = $_SESSION["usnombre"];
    //         $user = $this->getObjUsuario()->Search($usNombre);
    //         $this->setObjUsuario($user[0]);
    //     }
    // }

    // //Setters
    // public function setObjUsuario($objUsuario)
    // {
    //     $this->objUsuario = $objUsuario;
    // }

    // //Getters
    // public function getObjUsuario()
    // {
    //     return $this->objUsuario;
    // }

    // public function getUsuario()
    // {
    //     return $this->getObjUsuario();
    // }

    // public function onSesion()
    // {
    //     return isset($_SESSION["usnombre"]);
    // }

    // public function Start($usNombre, $rol)
    // {
    //     $_SESSION["usnombre"] = $usNombre;
    //     $_SESSION["rol"] = $rol;

    //     // Obtiene el objeto de vista asociado al rol
    //     $objRol = new ABMRol();
    //     $array = [2];
    //     $_SESSION["on"] = $objRol->objectSearchId($array)[0];
    // }

    // public function Verify($array)
    // {
    //     $arrayUser = $this->getObjUsuario()->Search($array);
    //     $resp = FALSE;

    //     if ($arrayUser !== NULL && $array["uspass"] == $arrayUser[0]->getUsPass()) {
    //         $this->setObjUsuario($arrayUser[0]);
    //         $rolId = $this->getRol();
    //         $this->onSesion($array["usnombre"], $rolId);
    //         $resp = TRUE;
    //     }
    //     return $resp;
    // }

    // public function getRol()
    // {
    //     $rolId = [];
    //     if ($this->getObjUsuario() !== NULL) {
    //         $objUsuarioRol = new ABMUsuarioRol();
    //         $array["idusuario"] = $this->getObjUsuario()->getIdUsuario();
    //         $arrayUsuarioRol = $objUsuarioRol->Search($array);
    //         foreach ($arrayUsuarioRol as $rol) {
    //             $rolId[] = $rol->getRol()->getIdRol();
    //         }
    //     }
    //     return $rolId;
    // }

    // public function close()
    // {
    //     return session_unset();
    //     return session_destroy();
    // }
}

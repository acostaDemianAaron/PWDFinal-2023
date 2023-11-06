<?php

class Usuario
{
    private $idUsuario;
    private $usNombre;
    private $usPass;
    private $usMail;
    private $usDeshabilitado;
    private $mensaje;

    //Magic Methods
    public function __construct()
    {
        $this->idUsuario = "";
        $this->usNombre = "";
        $this->usPass = "";
        $this->usMail = "";
        $this->usDeshabilitado = "";
        $this->mensaje = "";
    }


    //Setters
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function setUsNombre($usNombre)
    {
        $this->usNombre = $usNombre;
    }

    public function setUsPass($usPass)
    {
        $this->usPass = $usPass;
    }

    public function setUsMail($usMail)
    {
        $this->usMail = $usMail;
    }

    public function setUsDeshabilitado($usDeshabilitado)
    {
        $this->usDeshabilitado = $usDeshabilitado;
    }

    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }


    //Getters
    public function getIdUsuario()
    {
        $this->idUsuario;
    }

    public function getUsNombre()
    {
        $this->usNombre;
    }

    public function getUsPass()
    {
        $this->usPass;
    }

    public function getUsMail()
    {
        $this->usMail;
    }

    public function getUsDeshabilitado()
    {
        $this->usDeshabilitado;
    }

    public function getMensaje()
    {
        $this->mensaje;
    }


    //Methods
    public function setValues($idUsuario, $usNombre, $usPass, $usMail, $usDeshabilitado)
    {
        $this->setIdUsuario($idUsuario);
        $this->setUsNombre($usNombre);
        $this->setUsPass($usPass);
        $this->setUsMail($usMail);
        $this->setUsDeshabilitado($usDeshabilitado);
    }

    public function Load()
    {
        $res = false;
        $database = new Database();
        $query = "SELECT * FROM 'usuario' WHERE idusuario = " . $this->getIdUsuario();

        if ($database->Start()) {
            $status = $database->Execute($query);
            if ($status > 0) {
                $row = $database->Register();
                $this->setValues($row['idusuario'], $row['usnombre'], $row['uspass'], $row['usmail'], $row['usdeshabilitado']);
                $res = true;
            }
        } else {
            $this->setMensaje("Usuario->Load: " . $database->getError());
        }
        return $res;
    }

    public function Insert()
    {
        $res = false;
        $database = new Database();
        $query = "INSERT INTO usuario (usnombre, uspass, usmail, usdeshabilitado) VALUES ('" . $this->getUsNombre() . "','" . $this->getUsPass() . "','" . $this->getUsMail() . ",'0000-00-00 00:00:00');";

        if ($database->Start()) {
            if ($database->Execute($query)) {
                $this->setIdUsuario($database);
                $res = true;
            } else {
                $this->setMensaje("Usuario->Insert: " . $database->getError());
            }
        } else {
            $this->setMensaje("Usuario->Insert: " . $database->getError());
        }
        return $res;
    }

    public function Modify()
    {
        $res = false;
        $database = new Database();
        $query = "UPDATE usuario SET usnombre = '{$this->getUsNombre()}', uspass = '{$this->getUsPass()}', usmail = '{$this->getUsMail()}', usdeshabilitado = '{$this->getUsDeshabilitado()} WHERE idusuario = {$this->getIdUsuario()}";

        if ($database->Start()) {
            if ($database->Execute($query) > -1) {
                $res = true;
            } else {
                $this->setMensaje("Usuario->Modify: " . $database->getError());
            }
        } else {
            $this->setMensaje("Usuario->Modify: " . $database->getError());
        }
        return $res;
    }

    public function Delete()
    {
        $res = false;
        $database = new Database();
        $query = "DELETE FROM 'usuario' WHERE idusuario = " . $this->getIdUsuario();

        if ($database->Start()) {
            if ($database->Execute($query)) {
                $res = true;
            } else {
                $this->setMensaje("Usuario->Delete: " . $database->getError());
            }
        } else {
            $this->setMensaje("Usuario->Delete: " . $database->getError());
        }
        return $res;
    }

    public function List($condition = "")
    {
        $array = array();
        $database = new Database();
        $query = "SELECT * FROM usuario ";
        if ($condition != "") {
            $query .= " WHERE " . $condition;
        }
        $res = $database->Execute($query);
        if ($res > 0) {
            while ($row = $database->Register()) {
                $obj = new Usuario();
                $obj->setValues($row['idusuario'], $row['usnombre'], $row['uspass'], $row['usmail'], $row['usdeshabilitado']);
                array_push($array, $obj);
            }
        } else {
            $this->setMensaje("Usuario->List: " . $database->getError());
        }
        return $array;
    }

    public function State($condition = "")
    {
        $res = false;
        $database = new Database();
        $query = "UPDATE 'usuario' SET usdeshabilitado='" . $condition . "' WHERE idusuario=" . $this->getIdUsuario();

        if ($database->Start()) {
            if ($database->Execute($query)) {
                $res = true;
            } else {
                $this->setMensaje("Usuario->State: " . $database->getError());
            }
        } else {
            $this->setMensaje("Usuario->State: " . $database->getError());
        }
        return $res;
    }
}

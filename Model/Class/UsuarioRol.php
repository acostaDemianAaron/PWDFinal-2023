<?php

class UsuarioRol
{
    private $objUsuario;
    private $objRol;
    private $mensaje;



    //Magic Methods
    public function __construct()
    {
        $this->objRol = NULL;
        $this->objUsuario = NULL;
        $this->mensaje = "";
    }

    //Setters
    public function setObjRol($objRol)
    {
        $this->objRol = $objRol;
    }

    public function setObjUsuario($objUsuario)
    {
        $this->objUsuario = $objUsuario;
    }

    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }

    //Getters
    /**
     * @return Rol
     */
    public function getObjRol()
    {
        $this->objRol;
    }

    /**
     * @return Usuario
     */
    public function getObjUsuario()
    {
        $this->objUsuario;
    }

    public function getMensaje()
    {
        $this->mensaje;
    }



    //Methods
    public function setValues($objRol, $objUsuario)
    {
        $this->setObjRol($objRol);
        $this->setObjUsuario($objUsuario);
    }

    /**
     * Get values of object UsuarioRol respect of idusuario and (if needed) IdRol.
     * @return Boolean|Integer
     */
    public function Load()
    {
        $res = false;
        $database = new Database();

        $query = "SELECT * FROM 'usuariorol' WHERE idusuario= " . $this->getObjUsuario()->getIdUsuario();
        if($this->getObjRol()->getIdRol() != NULL) $query .= " AND idrol= " . $this->getObjRol()->getIdRol();

        if ($database->Start()) {
            $status = $database->Execute($query);
            if ($status > 0) {
                $objRol = NULL;
                $objUsuario = NULL;
                $row = $database->Register();

                if ($row['idrol'] != NULL) {
                    $objRol = new Rol();
                    $objRol->setIdRol($row['idrol']);
                    $objRol->Load();
                }

                if ($row['idusuario'] != NULL) {
                    $objUsuario = new Usuario();
                    $objUsuario->setIdUsuario($row['idusuario']);
                    $objUsuario->Load();
                }
                $this->setValues($objUsuario, $objRol);
                $res = true;
            }
        } else {
            $this->setMensaje("UsuarioRol->Load: " . $database->getError());
        }
        return $res;
    }

    public function Insert()
    {
        $res = false;
        $database = new Database();
        $query = "INSERT INTO usuariorol (idusuario, idrol) VALUES (" . $this->getObjUsuario()->getIdUsuario() . "," . $this->getObjRol()->getIdRol() . ");";
        if ($database->Start()) {
            if ($database->Execute($query)) {
                $res = true;
            } else {
                $this->setMensaje("UsuarioRol->Insert: " . $database->getError());
            }
        } else {
            $this->setMensaje("UsuarioRol->Insert: " . $database->getError());
        }
        return $res;
    }

    public function Modify()
    {
        $res = false;
        $database = new Database();
        $query = " UPDATE usuariorol SET idrol = " . $this->getObjRol()->getIdRol() . " WHERE idusuario =" . $this->getObjUsuario()->getIdUsuario();
        if ($database->Start()) {
            if ($database->Execute($query) > -1) {
                $res = true;
            } else {
                $this->setMensaje("UsuarioRol->Modify: " . $database->getError());
            }
        } else {
            $this->setMensaje("UsuarioRol->Modify: " . $database->getError());
        }
        return $res;
    }

    public function Delete()
    {
        $res = false;
        $database = new Database();
        $query = "DELETE FROM 'usuariorol' WHERE idusuario=" . $this->getObjUsuario()->getIdUsuario() . " AND idrol=" . $this->getObjRol()->getIdRol();
        if ($database->Start()) {
            if ($database->Execute($query)) {
                $res = true;
            } else {
                $this->setMensaje("UsuarioRol->Delete: " . $database->getError());
            }
        } else {
            $this->setMensaje("UsuarioRol->Delete: " . $database->getError());
        }
        return $res;
    }

    public function List($condition = "")
    {
        $array = array();
        $database = new Database();
        $query = "SELECT * FROM 'usuariorol' ";
        if ($condition != "") {
            $query .= "WHERE " . $condition;
        }
        $res = $database->Execute($query);
        if ($res > 0) {
            while ($row = $database->Register()) {
                $objUsuario = NULL;
                $objRol = NULL;

                if ($row['idrol'] != NULL) {
                    $objRol = new Rol();
                    $objRol->setIdRol($row['idrol']);
                    $objRol->Load();
                }

                if ($row['idusuario'] != NULL) {
                    $objUsuario = new Usuario();
                    $objUsuario->setIdUsuario($row['idusuario']);
                    $objUsuario->Load();
                }

                $obj = new UsuarioRol();
                $obj->setValues($objUsuario, $objRol);
                array_push($array, $obj);
            }
        } else {
            $this->setMensaje("UsuarioRol->List: " . $database->getError());
        }
        return $array;
    }
}

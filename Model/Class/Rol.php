<?php

class Rol
{
    private $idRol;
    private $roDescripcion;
    private $mensaje;

    //Magic Methods
    public function __construct()
    {
        $this->idRol = "";
        $this->roDescripcion = "";
        $this->mensaje = "";
    }


    //Setters
    public function setIdRol($idRol)
    {
        $this->idRol = $idRol;
    }

    public function setRoDescripcion($roDescripcion)
    {
        $this->roDescripcion = $roDescripcion;
    }

    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }


    //Getters
    public function getIdRol()
    {
        $this->idRol;
    }

    public function getRoDescripcion()
    {
        $this->roDescripcion;
    }

    public function getMensaje()
    {
        $this->mensaje;
    }


    //Methods
    public function setValues($idRol, $roDescripcion)
    {
        $this->setIdRol($idRol);
        $this->setRoDescripcion($roDescripcion);
    }

    public function Load()
    {
        $res = false;
        $database = new Database();
        $query = "SELECT * FROM 'rol' WHERE idrol = " . $this->getIdRol();

        if ($database->Start()) {
            $status = $database->Execute($query);
            if ($status > 0) {
                $row = $database->Register();
                $this->setValues($row['idrol'], $row['rodescripcion']);
                $res = true;
            }
        } else {
            $this->setMensaje("Rol->Load: " . $database->getError());
        }
        return $res;
    }

    public function Insert()
    {
        $res = false;
        $database = new Database();
        $query = "INSERT INTO rol (rodescripcion) VALUES ('" . $this->getRoDescripcion() . "');";

        if ($database->Start()) {
            if ($database->Execute($query)) {
                $this->setIdRol($database);
                $res = true;
            } else {
                $this->setMensaje("Rol->Insert: " . $database->getError());
            }
        } else {
            $this->setMensaje("Rol->Insert: " . $database->getError());
        }
        return $res;
    }

    public function Modify()
    {
        $res = false;
        $database = new Database();
        $query = "UPDATE rol SET rodescripcion = '{$this->getRoDescripcion()} WHERE idrol = {$this->getIdRol()}";

        if ($database->Start()) {
            if ($database->Execute($query) > -1) {
                $res = true;
            } else {
                $this->setMensaje("Rol->Modify: " . $database->getError());
            }
        } else {
            $this->setMensaje("Rol->Modify: " . $database->getError());
        }
        return $res;
    }

    public function Delete()
    {
        $res = false;
        $database = new Database();
        $query = "DELETE FROM 'rol' WHERE idrol = " . $this->getIdRol();

        if ($database->Start()) {
            if ($database->Execute($query)) {
                $res = true;
            } else {
                $this->setMensaje("Rol->Delete: " . $database->getError());
            }
        } else {
            $this->setMensaje("Rol->Delete: " . $database->getError());
        }
        return $res;
    }

    public function List($condition = "")
    {
        $array = array();
        $database = new Database();
        $query = "SELECT * FROM rol ";

        if ($condition != "") {
            $query .= " WHERE " . $condition;
        }
        $res = $database->Execute($query);
        if ($res > 0) {
            while ($row = $database->Register()) {
                $obj = new Rol();
                $obj->setValues($row['idrol'], $row['rodescripcion']);
                array_push($array, $obj);
            }
        } else {
            $this->setMensaje("Rol->List: " . $database->getError());
        }
        return $array;
    }
}

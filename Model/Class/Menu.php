<?php

class Menu
{
    private $idMenu;
    private $meNombre;
    private $meDescripcion;
    private $idPadre;
    private $meDeshabilitado;
    private $mensaje;

    //Magic Methods
    public function __construct()
    {
        $this->idMenu = "";
        $this->meNombre = "";
        $this->meDescripcion = "";
        $this->idPadre = "";
        $this->meDeshabilitado = "";
        $this->mensaje = "";
    }


    //Setters
    public function setIdMenu($idMenu)
    {
        $this->idMenu = $idMenu;
    }

    public function setMeNombre($meNombre)
    {
        $this->meNombre = $meNombre;
    }

    public function setMeDescripcion($meDescripcion)
    {
        $this->meDescripcion = $meDescripcion;
    }

    public function setIdPadre($idPadre)
    {
        $this->idPadre = $idPadre;
    }

    public function setMeDeshabilitado($meDeshabilitado)
    {
        $this->meDeshabilitado = $meDeshabilitado;
    }

    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }


    //Getters
    public function getIdMenu()
    {
        return $this->idMenu;
    }

    public function getMeNombre()
    {
        return $this->meNombre;
    }

    public function getMeDescripcion()
    {
        return $this->meDescripcion;
    }

    public function getIdPadre()
    {
        return $this->idPadre;
    }

    public function getMeDeshabilitado()
    {
        return $this->meDeshabilitado;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }


    //Methods
    public function setValues($idMenu, $meNombre, $meDescripcion, $idPadre, $meDeshabilitado)
    {
        $this->setIdMenu($idMenu);
        $this->setMeNombre($meNombre);
        $this->setMeDescripcion($meDescripcion);
        $this->setIdPadre($idPadre);
        $this->setMeDeshabilitado($meDeshabilitado);
    }

    public function Load()
    {
        $res = false;
        $database = new Database();
        $query = "SELECT * FROM menu WHERE idmenu = " . $this->getIdMenu();

        if ($database->Start()) {
            $status = $database->Execute($query);
            if ($status > 0) {
                $row = $database->Register();
                $this->setValues($row['idmenu'], $row['menombre'], $row['medescripcion'], $row['idpadre'], $row['medeshabilitado']);
                $res = true;
            }
        } else {
            $this->setMensaje("Menu->Load: " . $database->getError());
        }
        return $res;
    }

    public function Insert()
    {
        $res = false;
        $database = new Database();
        $query = "INSERT INTO menu (menombre, medescripcion, idpadre, medeshabilitado) VALUES  ('" . $this->getMeNombre() . "','" . $this->getMeDescripcion() . "'," . $this->getIdPadre() . ", null);";
        if ($database->Start()) {
            if ($database->Execute($query)) {
                $this->setIdMenu($database);
                $res = true;
            } else {
                $this->setMensaje("Menu->Insert: " . $database->getError());
            }
        } else {
            $this->setMensaje("Menu->Insert: " . $database->getError());
        }
        return $res;
    }

    public function Modify()
    {
        $res = false;
        $database = new Database();
        $query = "UPDATE menu SET menombre = '{$this->getMeNombre()}', medescripcion = '{$this->getMeDescripcion()}'";
        if($this->getIdPadre() != null){
            $query .= ", idpadre = {$this->getIdPadre()}";
        }
        if($this->getMeDeshabilitado() != null){
            $query .= ', medeshabilitado= {$this->getMeDeshabilitado()}';
        }
        $query .= ' WHERE idmenu = ' . $this->getIdMenu();
        if ($database->Start()) {
            if ($database->Execute($query) > -1) {
                $res = true;
            } else {
                $this->setMensaje("Menu->Modify: " . $database->getError());
            }
        } else {
            $this->setMensaje("Menu->Modify: " . $database->getError());
        }
        return $res;
    }

    public function Delete()
    {
        $res = false;
        $database = new Database();
        $query = "DELETE FROM menu WHERE idmenu = " . $this->getIdMenu();
        if ($database->Start()) {
            if ($database->Execute($query)) {
                $res = true;
            } else {
                $this->setMensaje("Menu->Delete: " . $database->getError());
            }
        } else {
            $this->setMensaje("Menu->Delete: " . $database->getError());
        }
        return $res;
    }

    public function List($condition = "")
    {
        $array = array();
        $database = new Database();
        $query = "SELECT * FROM menu";
        if ($condition != "") {
            $query .= " WHERE " . $condition;
        }
        if ($database->Start()) {
            if ($database->Execute($query)) {
                while ($row = $database->Register()) {
                    $obj = new Menu();
                    $obj->setValues($row['idmenu'], $row['menombre'], $row['medescripcion'], $row['idpadre'], $row['medeshabilitado']);
                    array_push($array, $obj);
                }
            } else {
                $this->setMensaje("Menu->List: " . $database->getError());
            }
        }
        return $array;
    }

    public function State($condition = "")
    {
        $res = false;
        $database = new Database();
        $query = " UPDATE menu SET medeshabilitado = '" . $condition . "' WHERE idmenu = " . $this->getIdMenu();
        if ($database->Start()) {
            if ($database->Execute($query)) {
                $res = true;
            } else {
                $this->setMensaje("Menu->State: " . $database->getError());
            }
        } else {
            $this->setMensaje("Menu->State: " . $database->getError());
        }
        return $res;
    }
}

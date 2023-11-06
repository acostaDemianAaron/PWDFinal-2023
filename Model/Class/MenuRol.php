<?php

class MenuRol
{
    private $objMenu;
    private $objRol;
    private $mensaje;

    //Magic Methods
    public function __construct()
    {
        $this->objMenu = NULL;
        $this->objRol = NULL;
        $this->mensaje = "";
    }


    //Setters
    public function setObjMenu($objMenu)
    {
        $this->objMenu = $objMenu;
    }

    public function setObjRol($objRol)
    {
        $this->objRol = $objRol;
    }

    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }


    //Getters
    /**
     * @return Menu
     */
    public function getObjMenu()
    {
        $this->objMenu;
    }

    /**
     * @return Rol
     */
    public function getObjRol()
    {
        $this->objRol;
    }

    public function getMensaje()
    {
        $this->mensaje;
    }


    //Methods
    public function setValues($objMenu, $objRol)
    {
        $this->setObjMenu($objMenu);
        $this->setObjRol($objRol);
    }

    public function Load()
    {
        $res = false;
        $database = new Database();
        $query = " SELECT * FROM 'menurol' WHERE idmenu = " . $this->getObjMenu()->getIdMenu();
        if ($this->getObjRol()->getIdRol() != NULL) $query .= " AND idrol= " . $this->getObjRol()->getIdRol();

        if ($database->Start()) {
            $status = $database->Execute($query);
            if ($status > 0) {
                $objMenu = NULL;
                $objRol = NULL;
                $row = $database->Register();

                if ($row['idmenu'] != NULL) {
                    $objMenu = new Menu();
                    $objMenu->setIdMenu($row['idmenu']);
                    $objMenu->Load();
                }

                if ($row['idrol'] != NULL) {
                    $objRol = new Rol();
                    $objRol->setIdRol($row['idrol']);
                    $objRol->Load();
                }

                $this->setValues($objMenu, $objRol);
                $res = true;
            }
        } else {
            $this->setMensaje("MenuRol->Load: " . $database->getError());
        }
        return $res;
    }

    public function Insert()
    {
        $res = false;
        $database = new Database();
        $query = "INSERT INTO menurol (idmenu,idrol)  VALUES(" . $this->getObjMenu()->getIdMenu() . "," . $this->getObjRol()->getIdRol() . ");";

        if ($database->Start()) {
            if ($database->Execute($query)) {
                $res = true;
            } else {
                $this->setMensaje("MenuRol->Insert: " . $database->getError());
            }
        } else {
            $this->setMensaje("MenuRol->Insert: " . $database->getError());
        }
        return $res;
    }

    public function Modify()
    {
        $res = false;
        $database = new Database();
        $query = " UPDATE menurol SET idrol = " . $this->getObjMenu()->getIdMenu() . " WHERE idmenu =" . $this->getObjRol()->getIdRol();

        if ($database->Start()) {
            if ($database->Execute($query) > -1) {
                $res = true;
            } else {
                $this->setMensaje("MenuRol->Modify: " . $database->getError());
            }
        } else {
            $this->setMensaje("MenuRol->Modify: " . $database->getError());
        }
        return $res;
    }

    public function Delete()
    {
        $res = false;
        $database = new Database();
        $query = "DELETE FROM menurol WHERE idmenu = " . $this->getObjMenu()->getIdMenu() . " AND idrol = " . $this->getObjRol()->getIdRol();

        if ($database->Start()) {
            if ($database->Execute($query)) {
                $res = true;
            } else {
                $this->setMensaje("MenuRol->Delete: " . $database->getError());
            }
        } else {
            $this->setMensaje("MenuRol->Delete: " . $database->getError());
        }
        return $res;
    }

    public function List($condition = "")
    {
        $array = array();
        $database = new Database();
        $query = "SELECT * FROM menurol ";

        if ($condition != "") {
            $query .= "WHERE " . $condition;
        }
        $res = $database->Execute($query);
        if ($res > 0) {
            while ($row = $database->Register()) {
                $objMenu = NULL;
                $objRol = NULL;

                if ($row['idmenu'] != NULL) {
                    $objMenu = new Menu();
                    $objMenu->setIdMenu($row['idmenu']);
                    $objMenu->Load();
                }

                if ($row['idrol'] != NULL) {
                    $objRol = new Rol();
                    $objRol->setIdRol($row['idrol']);
                    $objRol->Load();
                }

                $obj = new MenuRol();
                $obj->setValues($objMenu, $objRol);
                array_push($array, $obj);
            }
        } else {
            $this->setMensaje("MenuRol->List: " . $database->getError());
        }
        return $array;
    }
}

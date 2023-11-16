<?php

class Compra
{
    private $idCompra;
    private $coFecha;
    private $objUsuario;
    private $mensaje;

    //Magic Methods
    public function __construct()
    {
        $this->idCompra = "";
        $this->coFecha = "";
        $this->objUsuario = NULL;
        $this->mensaje = "";
    }


    //Setters
    public function setIdCompra($idCompra)
    {
        $this->idCompra = $idCompra;
    }

    public function setCoFecha($coFecha)
    {
        $this->coFecha = $coFecha;
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
    public function getIdCompra()
    {
        return $this->idCompra;
    }

    public function getCoFecha()
    {
        return $this->coFecha;
    }

    /**
     * @return Usuario
     */
    public function getObjUsuario()
    {
        return $this->objUsuario;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }


    //Methods
    public function setValues($idCompra, $coFecha, $objUsuario)
    {
        $this->setIdCompra($idCompra);
        $this->setCoFecha($coFecha);
        $this->setObjUsuario($objUsuario);
    }


    public function Load()
    {
        $res = false;
        $database = new Database();
        $query = "SELECT * FROM compra WHERE idcompra = " . $this->getIdCompra();

        if ($database->Start()) {
            $status = $database->Execute($query);
            if ($status > 0) {
                $objUsuario = NULL;
                $row = $database->Register();
                if ($row['idusuario'] != NULL) {
                    $objUsuario = new Usuario();
                    $objUsuario->setIdUsuario($row['idusuario']);
                    $objUsuario->Load();
                }
                $this->setValues($row['idcompra'], $row['cofecha'], $objUsuario);
                $res = true;
            }
        } else {
            $this->setMensaje("Compra->Load: " . $database->getError());
        }
        return $res;
    }

    public function Insert()
    {
        $res = false;
        $database = new Database();
        $query = " INSERT INTO compra (cofecha, idusuario) VALUES ('" . $this->getCoFecha() . "'," . $this->getObjUsuario()->getIdUsuario() . ");";
        if ($database->Start()) {
            if ($database->Execute($query)) {
                $this->setIdCompra($database);
                $res = true;
            } else {
                $this->setMensaje("Compra->Insert: " . $database->getError());
            }
        } else {
            $this->setMensaje("Compra->Insert: " . $database->getError());
        }
        return $res;
    }

    public function Modify()
    {
        $res = false;
        $database = new Database();
        $query = "UPDATE compra SET idcompra = '{$this->getIdCompra()}', cofecha = '{$this->getCoFecha()}', idusuario = '{$this->getObjUsuario()->getIdUsuario()} WHERE idcompra = {$this->getIdCompra()}";

        if ($database->Start()) {
            if ($database->Execute($query) > -1) {
                $res = true;
            } else {
                $this->setMensaje("Compra->Modify: " . $database->getError());
            }
        } else {
            $this->setMensaje("Compra->Modify: " . $database->getError());
        }
        return $res;
    }

    public function Delete()
    {
        $res = false;
        $database = new Database();
        $query = "DELETE FROM compra WHERE idcompra=" . $this->getIdCompra();

        if ($database->Start()) {
            if ($database->Execute($query)) {
                $res = true;
            } else {
                $this->setMensaje("Compra->Delete: " . $database->getError());
            }
        } else {
            $this->setMensaje("Compra->Delete: " . $database->getError());
        }
        return $res;
    }

    public function List($condition = "")
    {
        $array = array();
        $database = new Database();
        $query = "SELECT * FROM compra ";

        if ($condition != "") {
            $query .= "WHERE " . $condition;
        }
        $res = $database->Execute($query);
        if ($res > 0) {
            while ($row = $database->Register()) {
                $obj = new Compra();
                $objUsuario = NULL;

                if ($row['idusuario'] != NULL) {
                    $objUsuario = new Usuario();
                    $objUsuario->setIdUsuario($row['idusuario']);
                    $objUsuario->Load();
                }

                $obj->setValues($row['idcompra'], $row['cofecha'], $objUsuario);
                array_push($array, $obj);
            }
        } else {
            $this->setMensaje("Compra->List: " . $database->getError());
        }

        print_r($query);
        return $array;
    }
}

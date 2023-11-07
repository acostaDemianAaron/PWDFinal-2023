<?php

class CompraEstadoTipo
{
    private $idCompraEstadoTipo;
    private $cetDescripcion;
    private $cetDetalle;
    private $mensaje;

    //Magic Methods
    public function __construct()
    {
        $this->idCompraEstadoTipo = "";
        $this->cetDescripcion = "";
        $this->cetDetalle = "";
        $this->mensaje = "";
    }


    //Setters
    public function setIdCompraEstadoTipo($idCompraEstadoTipo)
    {
        $this->idCompraEstadoTipo = $idCompraEstadoTipo;
    }

    public function setCetDescripcion($cetDescripcion)
    {
        $this->cetDescripcion = $cetDescripcion;
    }

    public function setCetDetalle($cetDetalle)
    {
        $this->cetDetalle = $cetDetalle;
    }

    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }


    //Getters
    public function getIdCompraEstadoTipo()
    {
        return $this->idCompraEstadoTipo;
    }

    public function getCetDescripcion()
    {
        return $this->cetDescripcion;
    }

    public function getCetDetalle()
    {
        return $this->cetDetalle;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }


    //Methods
    public function setValues($idCompraEstadoTipo, $cetDescripcion, $cetDetalle)
    {
        $this->setIdCompraEstadoTipo($idCompraEstadoTipo);
        $this->setCetDescripcion($cetDescripcion);
        $this->setCetDetalle($cetDetalle);
    }

    public function Load()
    {
        $res = false;
        $database = new Database();
        $query = "SELECT * FROM compraestadotipo WHERE idcompraestadotipo = " . $this->getIdCompraEstadoTipo();
        if ($database->Start()) {
            $status = $database->Execute($query);
            if ($status > 0) {
                $row = $database->Register();
                $this->setValues($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);
                $res = true;
            }
        } else {
            $this->setMensaje("CompraEstadoTipo->Load: " . $database->getError());
        }
        return $res;
    }

    public function Insert()
    {
        $res = false;
        $database = new Database();
        $query = "INSERT INTO compraestadotipo (cetdescripcion, cetdetalle) VALUES ('" . $this->getCetDescripcion() . "','" . $this->getCetDetalle() . "');";

        if ($database->Start()) {
            if ($database->Execute($query)) {
                $this->setIdCompraEstadoTipo($database);
                $res = true;
            } else {
                $this->setMensaje("CompraEstadoTipo->Insert: " . $database->getError());
            }
        } else {
            $this->setMensaje("CompraEstadoTipo->Insert: " . $database->getError());
        }
        return $res;
    }

    public function Modify()
    {
        $res = false;
        $database = new Database();
        $query = "UPDATE 'compraestadotipo' SET idcompraestadotipo = '{$this->getIdCompraEstadoTipo()}', cetdescripcion = '{$this->getCetDescripcion()}', cetdetalle = '{$this->getCetDetalle()} WHERE idcompraestadotipo = {$this->getIdCompraEstadoTipo()}";

        if ($database->Start()) {
            if ($database->Execute($query) > -1) {
                $res = true;
            } else {
                $this->setMensaje("CompraEstadoTipo->Modify: " . $database->getError());
            }
        } else {
            $this->setMensaje("CompraEstadoTipo->Modify: " . $database->getError());
        }
        return $res;
    }

    public function Delete()
    {
        $res = false;
        $database = new Database();
        $query = "DELETE FROM 'compraestadotipo' WHERE idcompraestadotipo = " . $this->getIdCompraEstadoTipo();

        if ($database->Start()) {
            if ($database->Execute($query)) {
                $res = true;
            } else {
                $this->setMensaje("CompraEstadoTipo->Delete: " . $database->getError());
            }
        } else {
            $this->setMensaje("CompraEstadoTipo->Delete: " . $database->getError());
        }
        return $res;
    }

    public function List($condition = "")
    {
        $array = array();
        $database = new Database();
        $query = "SELECT * FROM compraestadotipo ";
        if ($condition != "") {
            $query .= " WHERE " . $condition;
        }
        $res = $database->Execute($query);
        if ($res > 0) {
            while ($row = $database->Register()) {
                $obj = new CompraEstadoTipo();
                $obj->setValues($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);
                array_push($array, $obj);
            }
        } else {
            $this->setMensaje("CompraEstadoTipo->List: " . $database->getError());
        }
        return $array;
    }
}

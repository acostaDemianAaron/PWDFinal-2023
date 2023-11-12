<?php

class CompraEstado
{
    private $idCompraEstado;
    private $objCompra;
    private $objCompraEstadoTipo;
    private $ceFechaIni;
    private $ceFechaFin;
    private $mensaje;


    //Magic Methods
    public function __construct()
    {
        $this->idCompraEstado = "";
        $this->objCompra = NULL;
        $this->objCompraEstadoTipo = NULL;
        $this->ceFechaIni = "";
        $this->ceFechaFin = "";
        $this->mensaje = "";
    }


    //Setters
    public function setIdCompraEstado($idCompraEstado)
    {
        $this->idCompraEstado = $idCompraEstado;
    }

    public function setObjCompra($objCompra)
    {
        $this->objCompra = $objCompra;
    }

    public function setObjCompraEstadoTipo($objCompraEstadoTipo)
    {
        $this->objCompraEstadoTipo = $objCompraEstadoTipo;
    }

    public function setCeFechaIni($ceFechaIni)
    {
        $this->ceFechaIni = $ceFechaIni;
    }

    public function setCeFechaFin($ceFechaFin)
    {
        $this->ceFechaFin = $ceFechaFin;
    }

    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }


    //Getters
    public function getIdCompraEstado()
    {
        return $this->idCompraEstado;
    }

    /**
     * @return Compra
     */
    public function getObjCompra()
    {
        return $this->objCompra;
    }

    /**
     * @return CompraEstadoTipo
     */
    public function getObjCompraEstadoTipo()
    {
        return $this->objCompraEstadoTipo;
    }

    public function getCeFechaIni()
    {
        return $this->ceFechaIni;
    }

    public function getCeFechaFin()
    {
        return $this->ceFechaFin;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }


    //Methods
    public function setValues($idCompraEstado, $objCompra, $objCompraEstadoTipo, $ceFechaIni, $ceFechaFin)
    {
        $this->setIdCompraEstado($idCompraEstado);
        $this->setObjCompra($objCompra);
        $this->setObjCompraEstadoTipo($objCompraEstadoTipo);
        $this->setCeFechaIni($ceFechaIni);
        $this->setCeFechaFin($ceFechaFin);
    }

    public function Load()
    {
        $res = false;
        $database = new Database();
        $query = "SELECT * FROM compraestado WHERE idcompraestado = " . $this->getIdCompraEstado();

        if ($database->Start()) {
            $status = $database->Execute($query);
            if ($status > 0) {
                $objCompra = NULL;
                $objCompraEstadoTipo = NULL;
                $row = $database->Register();

                if ($row['idcompra'] != NULL) {
                    $objCompra = new Compra();
                    $objCompra->setIdCompra($row['idcompra']);
                    $objCompra->Load();
                }

                if ($row['idcompraestadotipo'] != NULL) {
                    $objCompraEstadoTipo = new CompraEstadoTipo();
                    $objCompraEstadoTipo->setIdCompraEstadoTipo($row['idcompraestadotipo']);
                    $objCompraEstadoTipo->Load();
                }
                $this->setValues($row['idcompraestado'], $objCompra, $objCompraEstadoTipo, $row['cefechaini'], $row['cefechafin']);
                $res = true;
            }
        } else {
            $this->setMensaje("CompraEstado->Load: " . $database->getError());
        }
        return $res;
    }

    public function Insert()
    {
        $res = false;
        $database = new Database();
        $query = "INSERT INTO compraestado (idcompra, idcompraestadotipo, cefechaini, cefechafin) VALUES ( {$this->getObjCompra()->getIdCompra()} , {$this->getObjCompraEstadoTipo()->getIdCompraEstadoTipo()} , '{$this->getCeFechaIni()} ',' {$this->getCeFechaFin()} ');";
        if ($database->Start()) {
            if ($database->Execute($query)) {
                $this->setIdCompraEstado($database);
                $res = true;
            } else {
                $this->setMensaje("CompraEstado->Insert: " . $database->getError());
            }
        } else {
            $this->setMensaje("CompraEstado->Insert: " . $database->getError());
        }
        return $res;
    }

    public function Modify()
    {
        $res = false;
        $database = new Database();
        $query = "UPDATE compraestado SET idcompra = '{$this->getObjCompra()->getIdCompra()}', idcompraestadotipo= '{$this->getObjCompraEstadoTipo()->getIdCompraEstadoTipo()}', cefechaini= '{$this->getCeFechaIni()}', cefechafin= '{$this->getCeFechaFin()} WHERE idcompraestado = {$this->getIdCompraEstado()}";

        if ($database->Start()) {
            if ($database->Execute($query) > -1) {
                $res = true;
            } else {
                $this->setMensaje("CompraEstado->Modify: " . $database->getError());
            }
        } else {
            $this->setMensaje("CompraEstado->Modify: " . $database->getError());
        }
        return $res;
    }

    public function Delete()
    {
        $res = false;
        $database = new Database();
        $query = "DELETE FROM compraestado WHERE idcompraestado = " . $this->getIdCompraEstado();

        if ($database->Start()) {
            if ($database->Execute($query)) {
                $res = true;
            } else {
                $this->setMensaje("CompraEstado->Delete: " . $database->getError());
            }
        } else {
            $this->setMensaje("CompraEstado->Delete: " . $database->getError());
        }
        return $res;
    }

    public function List($condition = "")
    {
        $array = array();
        $database = new Database();
        $query = "SELECT * FROM compraestado ";

        if ($condition != "") {
            $query .= "WHERE " . $condition;
        }
        $res = $database->Execute($query);
        if ($res > 0) {
            while ($row = $database->Register()) {
                $objCompra = NULL;
                $objCompraEstadoTipo = NULL;

                if ($row['idcompra'] != NULL) {
                    $objCompra = new Compra();
                    $objCompra->setIdCompra($row['idcompra']);
                    $objCompra->Load();
                }

                if ($row['idcompraestadotipo'] != NULL) {
                    $objCompraEstadoTipo = new CompraEstadoTipo();
                    $objCompraEstadoTipo->setIdCompraEstadoTipo($row['idcompraestadotipo']);
                    $objCompraEstadoTipo->Load();
                }

                $obj = new CompraEstado();
                $obj->setValues($row['idcompraestado'], $objCompra, $objCompraEstadoTipo, $row['cefechaini'], $row['cefechafin']);
                array_push($array, $obj);
            }
        } else {
            $this->setMensaje("CompraEstado->List: " . $database->getError());
        }
        return $array;
    }
}

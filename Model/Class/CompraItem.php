<?php

class CompraItem
{
    private $idCompraItem;
    private $objProducto;
    private $objCompra;
    private $ciCantidad;
    private $mensaje;


    //Magic Methods
    public function __construct()
    {
        $this->idCompraItem = "";
        $this->objProducto = NULL;
        $this->objCompra = NULL;
        $this->ciCantidad = "";
        $this->mensaje = "";
    }


    // Setters
    public function setIdCompraItem($idCompraItem)
    {
        $this->idCompraItem = $idCompraItem;
    }

    public function setObjProducto($objProducto)
    {
        $this->objProducto = $objProducto;
    }

    public function setObjCompra($objCompra)
    {
        $this->objCompra = $objCompra;
    }

    public function setCiCantidad($ciCantidad)
    {
        $this->ciCantidad = $ciCantidad;
    }

    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }


    //Getters
    public function getIdCompraItem()
    {
        return $this->idCompraItem;
    }

    /**
     * @return Producto
     */
    public function getObjProducto()
    {
        return $this->objProducto;
    }

    /**
     * @return Compra
     */
    public function getObjCompra()
    {
        return $this->objCompra;
    }

    public function getCiCantidad()
    {
        return $this->ciCantidad;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }


    //Methods
    public function setValues($idCompraItem, $objProducto, $objCompra, $ciCantidad)
    {
        $this->setIdCompraItem($idCompraItem);
        $this->setObjProducto($objProducto);
        $this->setObjCompra($objCompra);
        $this->setCiCantidad($ciCantidad);
    }

    public function Load()
    {
        $res = false;
        $database = new Database();
        $query = "SELECT * FROM compraitem WHERE idcompraitem = " . $this->getIdCompraItem();

        if ($database->Start()) {
            $status = $database->Execute($query);
            if ($status > 0) {
                $objProducto = NULL;
                $objCompra = NULL;
                $row = $database->Register();

                if ($row['idproducto'] != NULL) {
                    $objProducto = new Producto();
                    $objProducto->setIdProducto($row['idproducto']);
                    $objProducto->Load();
                }

                if ($row['idcompra'] != NULL) {
                    $objCompra = new Compra();
                    $objCompra->setIdCompra($row['idcompra']);
                    $objCompra->Load();
                }
                $this->setValues($row['idcompraitem'], $objProducto, $objCompra, $row['cicantidad']);
                $res = true;
            }
        } else {
            $this->setMensaje("CompraItem->Load: " . $database->getError());
        }
        return $res;
    }

    public function Insert()
    {
        $res = false;
        $database = new Database();
        $query = "INSERT INTO compraitem (idproducto, idcompra, cicantidad) VALUES ( {$this->getObjProducto()->getIdProducto()} , {$this->getObjCompra()->getIdCompra()} , {$this->getCiCantidad()})";
        if ($database->Start()) {
            if ($database->Execute($query)) {
                $this->setIdCompraItem($database);
                $res = true;
            } else {
                $this->setMensaje("CompraItem->Insert: " . $database->getError());
            }
        } else {
            $this->setMensaje("CompraItem->Insert: " . $database->getError());
        }
        return $res;
    }

    public function Modify()
    {
        $res = false;
        $database = new Database();
        $query = "UPDATE compraitem SET idcompraitem = '{$this->getIdCompraItem()}, idproducto= '{$this->getObjProducto()->getIdProducto()}, idcompra= '{$this->getObjCompra()->getIdCompra()}, cicantidad= '{$this->getCiCantidad()} WHERE idcompraitem = {$this->getIdCompraItem()}";

        if ($database->Start()) {
            if ($database->Execute($query) > -1) {
                $res = true;
            } else {
                $this->setMensaje("CompraItem->Modify: " . $database->getError());
            }
        } else {
            $this->setMensaje("CompraItem->Modify: " . $database->getError());
        }
        return $res;
    }

    public function Delete()
    {
        $res = false;
        $database = new Database();
        $query = "DELETE FROM compraitem WHERE idcompraitem=" . $this->getIdCompraItem();

        if ($database->Start()) {
            if ($database->Execute($query)) {
                $res = true;
            } else {
                $this->setMensaje("CompraItem->Delete: " . $database->getError());
            }
        } else {
            $this->setMensaje("CompraItem->Delete: " . $database->getError());
        }
        return $res;
    }

    public function List($condition = "")
    {
        $array = array();
        $database = new Database();
        $query = "SELECT * FROM compraitem ";

        if ($condition != "") {
            $query .= "WHERE " . $condition;
        }
        $res = $database->Execute($query);
        if ($res > 0) {
            while ($row = $database->Register()) {
                $objProducto = NULL;
                $objCompra = NULL;

                if ($row['idproducto'] != NULL) {
                    $objProducto = new Producto();
                    $objProducto->setIdProducto($row['idproducto']);
                    $objProducto->Load();
                }

                if ($row['idcompra'] != NULL) {
                    $objCompra = new Compra();
                    $objCompra->setIdCompra($row['idcompra']);
                    $objCompra->Load();
                }

                $obj = new CompraItem();
                $obj->setValues($row['idcompraitem'], $objProducto, $objCompra, $row['cicantidad']);
                array_push($array, $obj);
            }
        } else {
            $this->setMensaje("CompraItem->List: " . $database->getError());
        }
        return $array;
    }

    public function Quantity($condition = "")
    {
        $array = array();
        $database = new Database();
        $res = $database->Execute($condition);
        if ($res > 0) {
            while ($row = $database->Register()) {
                if ($row['cicantidad'] != NULL) {
                    $quantity = $row['cicantidad'];
                }
                array_push($array, $quantity);
            }
        } else {
            $this->setMensaje("CompraItem->Quantity: " . $database->getError());
        }
        return $array;
    }
}

<?php

class Producto
{
    private $idProducto;
    private $proPrecio;
    private $proNombre;
    private $proDetalle;
    private $proCantStock;
    private $mensaje;


    //Magic Methods
    public function __construct()
    {
        $this->idProducto = "";
        $this->proPrecio = "";
        $this->proNombre = "";
        $this->proDetalle = "";
        $this->proCantStock = "";
        $this->mensaje = "";
    }


    //Setters
    public function setIdProducto($idProducto)
    {
        $this->idProducto = $idProducto;
    }

    public function setProPrecio($proPrecio)
    {
        $this->proPrecio = $proPrecio;
    }

    public function setProNombre($proNombre)
    {
        $this->proNombre = $proNombre;
    }

    public function setProDetalle($proDetalle)
    {
        $this->proDetalle = $proDetalle;
    }

    public function setProCantStock($proCantStock)
    {
        $this->proCantStock = $proCantStock;
    }

    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }


    //Getters
    public function getIdProducto()
    {
        return $this->idProducto;
    }

    public function getProPrecio()
    {
        return $this->proPrecio;
    }

    public function getProNombre()
    {
        return $this->proNombre;
    }

    public function getProDetalle()
    {
        return $this->proDetalle;
    }

    public function getProCantStock()
    {
        return $this->proCantStock;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }


    //Methods
    public function setValues($idProducto, $proPrecio, $proNombre, $proDetalle, $proCantStock)
    {
        $this->setIdProducto($idProducto);
        $this->setProPrecio($proPrecio);
        $this->setProNombre($proNombre);
        $this->setProDetalle($proDetalle);
        $this->setProCantStock($proCantStock);
    }

    public function Load()
    {
        $res = false;
        $database = new Database();
        $query = "SELECT * FROM producto WHERE idproducto = '" . $this->getIdProducto() . "'";

        if ($database->Start()) {
            $status = $database->Execute($query);
            if ($status > 0) {
                $row = $database->Register();
                $this->setValues($row['idproducto'], $row['proprecio'], $row['pronombre'], $row['prodetalle'], $row['procantstock']);
                $res = true;
            }
        } else {
            $this->setMensaje("Producto->Load: " . $database->getError());
        }
        return $res;
    }

    public function Insert()
    {
        $res = false;
        $database = new Database();
        $query = "INSERT INTO producto (proprecio, pronombre, prodetalle, procantstock) VALUES (" . $this->getProprecio() . ",'" . $this->getProNombre() . "','" . $this->getProDetalle() . "'," . $this->getProCantStock() . ")";
        if ($database->Start()) {
            if ($database->Execute($query)) {
                $this->setIdProducto($database);
                $res = true;
            } else {
                $this->setMensaje("Producto->Insert: " . $database->getError());
            }
        } else {
            $this->setMensaje("Producto->Insert: " . $database->getError());
        }
        return $res;
    }

    public function Modify()
    {
        $res = false;
        $database = new Database();
        $query = "UPDATE producto SET idproducto = '{$this->getIdProducto()}', proprecio = '{$this->getProPrecio()}', pronombre = '{$this->getProNombre()}', prodetalle = '{$this->getProDetalle()}', procantstock = {$this->getProCantStock()} WHERE idproducto = {$this->getIdProducto()}";
        if ($database->Start()) {
            if ($database->Execute($query) > -1) {
                $res = true;
            } else {
                $this->setMensaje("Producto->Modify: " . $database->getError());
            }
        } else {
            $this->setMensaje("Producto->Modify: " . $database->getError());
        }
        return $res;
    }

    public function Delete()
    {
        $res = false;
        $database = new Database();
        $query = "DELETE FROM producto WHERE idproducto='" . $this->getIdProducto() . "'";

        if ($database->Start()) {
            if ($database->Execute($query)) {
                $res = true;
            } else {
                $this->setMensaje("Producto->Delete: " . $database->getError());
            }
        } else {
            $this->setMensaje("Producto->Delete: " . $database->getError());
        }
        return $res;
    }

    public function List($condition = "")
    {
        $array = array();
        $database = new Database();
        $query = "SELECT * FROM producto ";

        if ($condition != "") {
            $query .= " WHERE " . $condition;
        }
        $res = $database->Execute($query);
        if ($res > 0) {
            while ($row = $database->Register()) {
                $obj = new Producto();
                $obj->setValues($row['idproducto'], $row['proprecio'], $row['pronombre'], $row['prodetalle'],  $row['procantstock']);
                array_push($array, $obj);
            }
        } else {
            $this->setMensaje("Producto->List: " . $database->getError());
        }
        return $array;
    }
}

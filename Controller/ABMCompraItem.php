<?php

class ABMCompraEstado
{
    public function LoadObj($array)
    {
        $obj = NULL;
        if (array_key_exists('idcompraitem', $array) && array_key_exists('idproducto', $array) && array_key_exists('idcompra', $array) && array_key_exists('cicantidad', $array)) {
            $objProducto = new Producto();
            $objProducto->setIdProducto($array['idproducto']);
            $objProducto->Load();

            $objCompra = new Compra();
            $objCompra->setIdCompra($array['idcompra']);
            $objCompra->Load();

            $obj = new CompraItem();
            $obj->setValues($array['idcompraitem'], $objProducto, $objCompra, $array['cicantidad']);
        }
        return $obj;
    }

    public function LoadObjId($array)
    {
        $obj = NULL;
        if (isset($array['idcompraitem'])) {
            $obj = new CompraItem();
            $obj->setIdCompraItem($array['idcompraitem']);
            if (!$obj->Load()) {
                $obj = NULL;
            }
        }
        return $obj;
    }

    public function Verify($array)
    {
        $resp = FALSE;
        if (isset($array['idcompraitem'])) {
            $resp = TRUE;
        }
        return $resp;
    }

    public function Delete($array)
    {
        $resp = FALSE;
        if ($this->Verify($array)) {
            $obj = $this->LoadObjId($array);
            if ($obj != NULL && $obj->Delete()) {
                $resp = TRUE;
            }
        }
        return $resp;
    }

    public function Edit($array)
    {
        $resp = FALSE;
        if ($this->Verify($array)) {
            $obj = $this->LoadObj($array);
            if ($obj != NULL && $obj->Modify()) {
                $resp = TRUE;
            }
        }
        return $resp;
    }

    public function Search($array = null)
    {
        $on = " true ";
        if ($array <> NULL) {
            if (isset($array['idcompraitem']))
                $on .= " and idcompraitem =" . $array['idcompraitem'];
            if (isset($array['idproducto']))
                $on .= " and idproducto = '" . $array['idproducto'] . "'";
            if (isset($array['idcompra']))
                $on .= " and idcompra ='" . $array['idcompra'] . "'";
            if (isset($array['cicantidad']))
                $on .= " and cicantidad ='" . $array['cicantidad'] . "'";
        }
        $obj = new CompraItem();
        $arrayList = $obj->List($on);
        return $arrayList;
    }

    public function Add($array)
    {
        $resp =  FALSE;
        $obj = $this->LoadObj($array);
        if ($obj != NULL && $obj->Insert()) {
            $resp = TRUE;
        }
        return $resp;
    }
}

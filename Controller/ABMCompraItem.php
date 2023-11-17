<?php

class ABMCompraItem
{
    public function LoadObject($array)
    {

        $obj = NULL;
        $objCompraItem = new CompraItem();
        $obj = $this->setData($array);

        return $obj;
    }

    public function setData($array)
    {
        $objCompraItem = new CompraItem();

        foreach ($array as $data) {
            if (array_key_exists('idproducto', $array)) {
                $objProducto = new Producto();
                $objProducto->setIdProducto($array['idproducto']);
                $objProducto->Load();
                $objCompraItem->setObjProducto($objProducto);
            }
            if (array_key_exists('pronombre', $array)) {
                $objProducto = new AbmProducto();
                $objProducto = $objProducto->Search(['pronombre' => $array['pronombre']])[0];
                $objCompraItem->setObjProducto($objProducto);
            }
            if (array_key_exists('idcompra', $array)) {
                $objCompra = new Compra();
                $objCompra->setIdCompra($array['idcompra']);
                $objCompra->Load();
                $objCompraItem->setObjCompra($objCompra);
            }
            if (array_key_exists('cicantidad', $array)) {
                $objCompraItem->setCiCantidad($array['cicantidad']);
            }
        }
        return $objCompraItem;
    }

    public function LoadObjectId($array)
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
            $obj = $this->LoadObject($array);
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
            $obj = $this->LoadObject($array);
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
        $obj = $this->LoadObject($array);
        if ($obj != NULL && $obj->Insert()) {
            $resp = TRUE;
        }
        return $resp;
    }
}

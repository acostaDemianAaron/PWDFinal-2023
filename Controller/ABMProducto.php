<?php
class AbmProducto
{
    public function LoadObj($array)
    {
        $obj = NULL;
        if (array_key_exists('idproducto', $array) && array_key_exists('proprecio', $array) && array_key_exists('pronombre', $array) && array_key_exists('prodetalle', $array) && array_key_exists('procantstock', $array)) {
            $obj = new Producto;
            $obj->setValues($array['idproducto'], $array['proprecio'], $array['pronombre'], $array['prodetalle'], $array['procantstock']);
        }
        return $obj;
    }

    public function LoadObjId($array)
    {
        $obj = NULL;
        if (isset($array['idproducto'])) {
            $obj = new Producto();
            $obj->setIdProducto($array['idproducto']);
            if (!$obj->Load()) {
                $obj = NULL;
            }
        }
        return $obj;
    }

    public function Verify($array)
    {
        $resp = FALSE;
        if (isset($array['idproducto'])) {
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
            if (isset($array['idproducto']))
                $on .= " and idproducto ='" . $array['idproducto'] . "'";
            if (isset($array['proprecio']))
                $on .= " and proprecio =" . $array['proprecio'];
            if (isset($array['pronombre']))
                $on .= " and pronombre ='" . $array['pronombre'] . "'";
            if (isset($array['prodetalle']))
                $on .= " and prodetalle ='" . $array['prodetalle'] . "'";
            if (isset($array['procantstock']))
                $on .= " and procantstock >=" . $array['procantstock'];
        }
        $obj = new Producto();
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
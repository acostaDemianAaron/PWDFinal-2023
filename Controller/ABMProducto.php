<?php
class AbmProducto
{
    public function LoadObject($array)
    { {
            $producto = NULL;
            if ($this->Verify($array)) {
                $producto = new Producto;
                $producto->setIdproducto($array['idproducto']);
                if ($producto->Load()) {
                    $prod = $producto;
                    foreach ($array as $key => $data) {
                        if ($data != null) {
                            $prod = $this->checkData($key, $data, $producto, $prod);
                        }
                    }
                }
            } else if ((array_key_exists('proprecio', $array) && array_key_exists('pronombre', $array) && array_key_exists('prodetalle', $array) || array_key_exists('procantstock', $array))) {
                $producto = new producto();
                $producto->setValues(null, $array['proprecio'], $array['pronombre'], $array['prodetalle'], null); //TODO refactorizar (errores en carga de datos);
            }
            return $producto;
        }
    }

    public function checkData($key, $data, $producto, $prod)
    {

        if ($data != null && $data != "null" && $data != "" && $data != 0) {
            switch ($key) {
                case 'proprecio':
                    if ($producto->getProPrecio() != $data) $prod->setProPrecio($data);
                    break;
                case 'pronombre':
                    if ($producto->getProNombre() != $data) $prod->setProNombre($data);
                    break;
                case 'prodetalle':
                    if ($producto->getProDetalle() != $data) $prod->setProDetalle($data);
                    break;
                case 'procantstock':
                    if ($producto->getProCantStock() != $data) $prod->setProCantStock($data);
                    break;
            }
        }
        return $prod;
    }

    public function LoadObjectId($array)
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
            if (array_key_exists('procantstock', $array)) {
                $obj->setProCantStock($array['procantstock']);
            }
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
        $obj = $this->LoadObject($array);
        if ($obj != NULL && $obj->Insert()) {
            $resp = TRUE;
        }
        return $resp;
    }
}

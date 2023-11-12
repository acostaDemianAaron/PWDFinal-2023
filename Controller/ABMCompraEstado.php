<?php

class ABMCompraEstado
{
    public function LoadObj($array)
    {
        $obj = NULL;
        if (array_key_exists('idcompra', $array)) {
            $objCompra = new Compra();
            $objCompra->setIdCompra($array['idcompra']);
            $objCompra->Load();

            $objCompraEstadoTipo = new CompraEstadoTipo();
            $objCompraEstadoTipo->setIdCompraEstadoTipo($array['idcompraestadotipo']);
            $objCompraEstadoTipo->Load();

            $ceFechaIni = '0000-00-00 00:00:00';
            if (array_key_exists('cefechaini', $array)) {
                $ceFechaIni = $array['cefechaini'];
            }
            $ceFechaFin = '0000-00-00 00:00:00';
            if (array_key_exists('cefechafin', $array)) {
                $ceFechaFin = $array['cefechafin'];
            }

            $obj = new CompraEstado;
            $obj->setValues($array['idcompraestado'], $objCompra, $objCompraEstadoTipo, $ceFechaIni, $ceFechaFin);
        }
        return $obj;
    }

    public function LoadObjId($array)
    {
        $obj = NULL;
        if (isset($array['idcompraestado'])) {
            $obj = new CompraEstado();
            $obj->setIdCompraEstado($array['idcompraestado']);
            if (!$obj->Load()) {
                $obj = NULL;
            }
        }
        return $obj;
    }

    public function Verify($array)
    {
        $resp = FALSE;
        if (isset($array['idcompraestado'])) {
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
            if (isset($array['idcompraestado'])) {
                $on .= " and idcompraestado =" . $array['idcompraestado'];
            }
            if (isset($array['idcompra'])) {
                $on .= " and idcompra =" . $array['idcompra'];
            }
            if (isset($array['idcompraestadotipo'])) {
                $on .= " and idcompraestadotipo ='" . $array['idcompraestadotipo'] . "'";
            }
            if (isset($array['cefechaini'])) {
                $on .= " and cefechaini ='" . $array['cefechaini'] . "'";
            }
            if (isset($array['cefechafin'])) {
                $on .= " and cefechafin ='" . $array['cefechafin'] . "'";
            }
        }
        $obj = new CompraEstado;
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

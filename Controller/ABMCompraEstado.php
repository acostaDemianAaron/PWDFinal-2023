<?php

class ABMCompraEstado
{
    public function LoadObject($array)
    {
        $obj = NULL;
        $objCompraEstado = new CompraEstado();
        $objCompraEstado = $this->setData($array);
        if ($objCompraEstado->Load()) {
            $obj = $objCompraEstado;
        }
        if (array_key_exists('cefechafin', $array)) {
            $objCompraEstado->setCeFechaFin($array['cefechafin']);
        }
        // if (array_key_exists('idcompra', $array) && array_key_exists('idcompraestado', $array) && array_key_exists('idcompraestadotipo', $array)) {
        //     $objCompra = new Compra();
        //     $objCompra->setIdCompra($array['idcompra']);
        //     $objCompra->Load();

        //     $objCompraEstadoTipo = new CompraEstadoTipo();
        //     $objCompraEstadoTipo->setIdCompraEstadoTipo($array['idcompraestadotipo']);
        //     $objCompraEstadoTipo->Load();

        //     $ceFechaIni = NULL;
        //     if (array_key_exists('cefechaini', $array)) {
        //         $ceFechaIni = $array['cefechaini'];
        //     }
        //     $ceFechaFin = NULL;
        //     if (array_key_exists('cefechafin', $array)) {
        //         $ceFechaFin = $array['cefechafin'];
        //     }

        //     $obj = new CompraEstado;
        //     $obj->setValues($array['idcompraestado'], $objCompra, $objCompraEstadoTipo, $ceFechaIni, $ceFechaFin);
        //     $obj->Load();
        // } else if (array_key_exists('idcompra', $array)) {
        //     $objCompra = new Compra();
        //     $objCompra->setIdCompra($array['idcompra']);
        //     $objCompra->Load();

        //     $obj = new CompraEstado();
        //     $obj->setObjCompra($objCompra);
        //     $obj->Load();
        // }
        return $obj;
    }


    public function LoadObjectId($array)
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
                $on .= " and cefechafin IS " . $array['cefechafin'];
            }
        }
        $obj = new CompraEstado;
        $arrayList = $obj->List($on);
        return $arrayList;
    }

    public function Add($array)
    {
        $resp =  FALSE;
        $obj = $this->setData($array);
        if ($obj != NULL && $obj->Insert()) {
            $resp = TRUE;
        }
        return $resp;
    }

    public function setData($array){
        $objCompraEstado = new CompraEstado();
        foreach($array as $data){
            if (array_key_exists('idcompraestado', $array)) {
                $objCompraEstado->setIdCompraEstado($array['idcompraestado']);
            }
            if (array_key_exists('idcompra', $array)) {
                $objCompra = new Compra();
                $objCompra->setIdCompra($array['idcompra']);
                $objCompra->Load();
                $objCompraEstado->setObjCompra($objCompra);
            }
            if (array_key_exists('idcompraestadotipo', $array)) {
                $objCompraEstadoTipo = new CompraEstadoTipo();
                $objCompraEstadoTipo->setIdCompraEstadoTipo($array['idcompraestadotipo']);
                $objCompraEstadoTipo->Load();
                $objCompraEstado->setObjCompraEstadoTipo($objCompraEstadoTipo);
            }
            if (array_key_exists('cefechaini', $array)) {
                $objCompraEstado->setCeFechaIni($array['cefechaini']);
            }
            if (array_key_exists('cefechafin', $array)) {
                $objCompraEstado->setCeFechaFin($array['cefechafin']);
            }
        }
        return $objCompraEstado;
    }
}

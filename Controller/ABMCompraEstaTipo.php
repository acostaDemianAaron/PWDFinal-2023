<?php

class ABMCompraEstadoTipo
{

    public function LoadObject($array)
    {
        $obj = NULL;
        if (array_key_exists('idcompraestadotipo', $array) && array_key_exists('cetdescripcion', $array) && array_key_exists('cetdetalle', $array)) {
            $obj = new CompraEstadoTipo();
            $obj->setValues($array['idcompraestadotipo'], $array['cetdescripcion'], $array['cetdetalle']);
        }
        return $obj;
    }

    public function LoadObjectId($array)
    {
        $obj = NULL;
        if (isset($array['idcompraestadotipo'])) {
            $obj = new CompraEstadoTipo();
            $obj->setIdCompraEstadoTipo($array['idcompraestadotipo']);
            if (!$obj->Load()) {
                $obj = NULL;
            }
        }
        return $obj;
    }

    public function Verify($array)
    {
        $resp = FALSE;
        if (isset($array['idcompraestadotipo'])) {
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
            if (isset($array['idcompraestadotipo']))
                $on .= " and idcompraestadotipo =" . $array['idcompraestadotipo'];
            if (isset($array['cetdescripcion']))
                $on .= " and cetdescripcion =" . $array['cetdescripcion'];
            if (isset($array['cetdetalle']))
                $on .= " and cetdetalle ='" . $array['cetdetalle'] . "'";
        }
        $obj = new CompraEstadoTipo();
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

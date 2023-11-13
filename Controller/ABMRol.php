<?php

class ABMRol
{
    /**
     * @param Array
     * @return Null|Rol
     */
    public function LoadObject($array)
    {
        $rol = NULL;
        if (array_key_exists('idrol', $array) && array_key_exists('roldescripcion', $array)) {
            $rol = new Rol();
            $rol->setValues($array['idrol'], $array['roldescripcion']);
        }
        return $rol;
    }

    /** 
     * @param Array
     * @return Boolean
     */
    public function LoadObjectId($array)
    {
        $rol = NULL;
        if (isset($array['idrol'])) {
            $rol = new Rol();
            $rol->setIdRol($array['idrol']);
            if (!$rol->Load()) {
                $rol = NULL;
            }
        }
        return $rol;
    }

    /** 
     * @param Array
     * @return Boolean
     */
    public function Verify($array)
    {
        $res = FALSE;
        if (isset($array['idrol'])) {
            $res = TRUE;
        }
        return $res;
    }

        /** 
     * @param Array
     * @return Boolean
     */
    public function Add($array)
    {
        $res = FALSE;
        $rol = $this->LoadObject($array);
        if ($rol != NULL && $rol->Insert()) {
            $res = TRUE;
        }
        return $res;
    }

    /** 
     * @param Array
     * @return Boolean
     */
    public function Delete($array)
    {
        $res = FALSE;
        if ($this->Verify($array)) {
            $rol = $this->LoadObjectId($array);
            if ($rol != NULL && $rol->Delete()) {
                $res = TRUE;
            }
        }
        return $res;
    }


    /**
     * @param Array
     * @return Boolean
     */
    public function Edit($array)
    {
        $res = FALSE;
        if ($this->Verify($array)) {
            $rol = $this->Search($array);
            $rol = $this->LoadObject($array);
            if ($rol != NULL && $rol->Modify()) {
                $res = TRUE;
            }
        }
        return $res;
    }

    /** 
     * @param Array
     * @return Boolean|Array|String
     */
    public function Search($array = NULL)
    {
        $on = " true ";
        if ($array <> NULL) {
            if ($this->Verify($array))
                $on .= " and idrol =" . $array['idrol'];
        }
        $rol = new Rol();
        $arrayList = $rol->List($on);
        return $arrayList;
    }
}
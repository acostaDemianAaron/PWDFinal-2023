<?php

class ABMMenuRol
{

    /** 
     * @param Array
     * @return Boolean|Object
     */
    public function LoadObject($array)
    {
        if(array_key_exists('idrol', $array) && array_key_exists('idmenu', $array))
        {
            $object = new MenuRol();
            $objectMenu = new Menu();
            $objectRol = new Rol();
            if(isset($array['idmenu']))
            {
                $objectMenu->setIdMenu($array['idmenu']);
                $objectMenu->Load();
            }
            if(isset($array['idrol']))
            {
                $objectRol->setIdRol($array['idrol']);
                $objectRol->Load();
            }
            $object->setValues($objectMenu, $objectRol);
        }
        return $object;
    }

    /** 
     * @param Array
     * @return Boolean
     */
    public function Verify($array)
    {
        $resp = false;
        if(isset($array['idrol']))
        {
            $resp = true;
        }
        return $resp;
    }

    /** 
     * @param Array
     * @return Boolean
     */
    public function Add($array)
    {
        $resp = false;
        $object = $this->LoadObject($array);
        if($object != null and $object->Insert())
        {
            $resp = true;
        }
        return $resp;
    }

    /** 
     * @param Array
     * @return Boolean
     */
    public function Edit($array)
    {
        $resp = false;
        if($this->Verify($array))
        {
            $object = $this->LoadObject($array);
            if($object != null and $object->Modify())
            {
                $resp = true;
            }
        }
        return $resp;
    }

    /** 
     * @param Array
     * @return Boolean|Array
     */
    public function Search($array = "")
    {
        $where = " true ";
        if($array != null)
        {
            if(isset($array['idrol']))
            {
                $where .= " and idrol =" . $array['idrol'];
            }
            if (isset($array['idmenu']))
            {
                $where .= " and idmenu =" . $array['idmenu'];
            }
        }
        $object = new MenuRol();
        $array = $object->list($where);
        return $array;
    }
}
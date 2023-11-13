<?php
class ABMMenu
{
    /** 
     * Carga el objecto con todos los parames
     * @param Array
     * @return Null|Menu
     */
    public function LoadObject($array)
    {
        $object = Null;
        if (array_key_exists('idmenu', $array) && array_key_exists('menombre', $array) && array_key_exists('medescripcion', $array) && array_key_exists('idpadre', $array) && array_key_exists('medeshabilitado', $array)) {
            $object = new Menu();
            $object->setValues($array['idmenu'], $array['menombre'], $array['medescripcion'], $array['idpadre'], null);
        }
        return $object;
    }

    /** 
     * @param Array
     * @return Null|Menu
     */
    public function LoadObjectId($array)
    {
        $object = new Menu();
        if($this->Verify($array)){
            $object->setIdMenu($array['idmenu']);
            if(!$object->Load()){
                $object = NULL;
            }
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
        if(isset($array['idmenu']))
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
    public function Delete($array)
    {
        $resp = false;
        if($this->Verify($array))
        {
            $object = $this->LoadObject($array);
            if($object != null and $object->State()){
                $resp = true;
            }
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
        $object = $this->LoadObject($array);
        if($object != null and $object->Modify()){
            $resp = true;
        }
        return $resp;
    }

    /** 
     * @param Array
     * @return Boolean|Array|String
     */
    public function Search($array = [])
    {
        $where = " true ";
        if($array != [])
        {
            if(isset($array['idmenu']))
            {
                $where .= " and idmenu =" . $array['idmenu'];
            }
            if(isset($array['idpadre']))
            {
                $where .= " and idpadre =" . $array['idpadre'];
            }
        }

        $object = new Menu();
        $array = $object->List($where);
        return $array;
    }

}
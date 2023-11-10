<?php
class ABMMenu
{
    public function LoadObject($data)
    {
        $object = new Menu();
        if(array_key_exists('idMenu', $data))
        {
            $object->setIdMenu($data['idMenu']);
            $object->Load();
            foreach ($data as $key => $value)
            {
                echo "HERE" . $key;
                if($value != "null")
                {
                    switch ($key)
                    {
                        case 'menombre':
                            $object->setMeNombre($value);
                            break;
                        case 'medescripcion':
                            $object->setMeDescripcion($value);
                            break;
                        case 'idpadre':
                            $padreMenu = new Menu();
                            $padreMenu->setIdMenu($value);
                            $padreMenu->Load();

                            $object->setIdPadre($padreMenu);
                            break;
                    }
                }
            }
        }

        return $object;
    }

    public function LoadObjectEnKey($argument)
    {
        $object = new Menu();
        if(isset($argument['idmenu'])){
            $object->setIdMenu($argument['idmenu']);
            $object->Load();
        }
        return $object;
    }

    public function SetearEnKey($argument)
    {
        $resp = false;
        if(isset($argument['idmenu']))
        {
            $resp = true;
        }
        return $resp;
    }

    public function Register($argument)
    {
        $resp = false;
        $object = $this->LoadObject($argument);

        if($object != null and $object->Insert())
        {
            $resp = true;
        }
        return $resp;
    }

    public function Drop($argument)
    {
        $resp = false;
        if($this->SetearEnKey($argument))
        {
            $object = $this->LoadObject($argument);
            if($object != null and $object->Delete()){
                $resp = true;
            }
        }
        return $resp;
    }

    public function Modify($argument)
    {
        $resp = false;
        $object = $this->LoadObject($argument);
        if($object != null and $object->Modify()){
            $resp = true;
        }
        return $resp;
    }

    public function List($argument = "")
    {
        $where = " true ";
        if($argument != null)
        {
            if(isset($argument['idmenu']))
            {
                $where .= " and idmenu =" . $argument['idmenu'];
            }
        }

        $object = new Menu();
        $array = $object->List($where);
        return $array;
    }

}
<?php
class ABMUsuarioRol
{
    public function LoadObject($argument)
    {
        if(array_key_exists('idrol', $argument) && array_key_exists('idusuario', $argument))
        {
            $objectRol = new Rol();
            $objectRol->setIdRol($argument['idrol']);
            $objectRol->Load();
            $objectUser = new Usuario();
            $objectUser->setIdUsuario($argument['idusuario']);
            $objectUser->Load();
            $objectUserRol = new UsuarioRol();
            $objectUserRol->setValues($objectUser, $objectRol);
        }
        return $objectUserRol;
    }

    public function LoadObjectEnKey($argument) 
    {
        $object = new UsuarioRol();
        if(isset($argument['idusuario']))
        {
            $object->getObjUsuario()->setIdUsuario($argument['idusuario']);
            $object->Load();
        }
        return $object;
    }

    public function SetearEnKey($argument)
    {
        $resp = false;
        if(isset($argument['idusuario']))
        {
            $resp = true;
        }
        return $resp;
    }

    public function Add($argument)
    {
        $resp = false;
        $object = $this->LoadObject($argument);
        if ($object != null)
        {
            if($object->Insert())
            {
                $resp = true;
            }
        }
        return $resp;
    }

    public function Drop($argument)
    {
        $resp = false;
        if($this->SetearEnKey($argument))
        {
            $object = $this->LoadObjectEnKey($argument);
            if($object != null and $object->Delete())
            {
                $resp = true;
            }
        }
        return $resp;
    }

    public function Modify($argument)
    {
        $resp = false;
        if($this->SetearEnKey($argument))
        {
            $object = $this->LoadObjectEnKey($argument);
            if($object->getObjRol()->getIdRol() != $argument['idrol'])
            {
                $object->getObjRol()->setIdRol($argument['idrol']);
                $resp = $object->Modify();
            }
        }
        return $resp;
    }

    public function List($argument)
    {
        $where = " true ";
        if($argument <> NULL)
        {
            if(isset($argument['idusuario']))
            {
                $where .= " and idusuario='" . $argument['idusuario'] . "'";
            }
            if(isset($argument['idrol']))
            {
                $where .= " and idrol='" . $argument['idrol'] . "'";
            }
        }
        $array = UsuarioRol::List($where, "");
        return $array;
    }
}
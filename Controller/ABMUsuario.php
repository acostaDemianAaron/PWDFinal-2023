<?php
class ABMUsuario
{
    public function LoadObject($data)
    {
        $object = new Usuario();
        if(array_key_exists('idusuario', $data))
        {
            $object->setIdUsuario($data['idusuario']);
            $object->Load();
            foreach($data as $key => $value)
            {
                if($value != null)
                {
                    switch($key)
                    {
                        case 'usnombre':
                            $object->setUsNombre($value);
                            break;
                        case 'uspass':
                            $object->setUsPass($value);
                            break;
                        case 'usmail':
                            $object->setUsMail($value);
                            break;
                        case 'usdeshabilitado':
                            $object->setUsDeshabilitado($value);
                            break;
                    }
                }
            }
        }
        return $object;
    }

    public function LoadObjectEnKey($data)
    {
        $object = new Usuario();
        if(isset($data['idusuario']))
        {
            $object->setIdUsuario($data['idusuario']);
            $object->Load();
        }
        return $object;
    }

    public function SetearEnKey($data)
    {
        $resp = false;
        if(isset($data['idusuario']))
        {
            $resp = true;
        }
        return $resp;
    }

    public function Register($data)
    {
        $resp = false;
        $object = new Usuario();
        if (isset($data['idusuario']))
        {
            $object->setIdUsuario($data['idusuario']);
        }

        $object->setUsNombre($data['usnombre']);
        $object->setUsPass($data['uspass']);
        $object->setUsMail($data['usmail']);
        if($object->Insert())
        {
            $data['idusuario'] = $object->getIdUsuario();
            if($this->RegisterRole($data, $object))
            {
                $resp = true;
            }
        }
        return $resp;
    }

    public function RegisterRole($data, $objUsuario)
    {
        $usRol = new UsuarioRol();
        $rol = new Rol();
        $rol->setIdRol($data['idrol']);
        $rol->Load();
        $usRol->setValues($objUsuario, $rol);
        $resp = $usRol->Insert($data);
        return $resp;
    }

    public function Drop($data)
    {
        $resp = false;
        if($this->SetearEnKey($data))
        {
            $object = $this->LoadObjectEnKey($data);
            if($object->getIdUsuario() != null && $object->Delete())
            {
                $resp = true;
            }
        }
        return $resp;
    }

    public function Modify($data)
    {
        $resp = false;
        if($this->SetearEnKey($data))
        {
            $object = $this->LoadObject($data);
            if($object->Modify())
            {
                $resp = true;
            }
        }

        if(isset($data['idrol']))
        {
            $usRol = new ABMUsuarioRol();
            $resp = $resp || $usRol->Modify($data);
        }
        return $resp;
    }

    public function List($data = "")
    {
        $where = " true ";
        if($data <> NULL)
        {
            if(isset($data['idusuario']))
            {
                $where .= " and idusuario=" . $data['idusuario'];
            }
            if(isset($data['usnombre']))
            {
                $where .= " and usnombre='" . $data['usnombre'] . "'";
            }
            if(isset($data['uspass']))
            {
                $where .= " and uspass='" . $data['uspass'] . "'";
            }
            if(isset($data['usmail']))
            {
                $where .= " and usmail='" . $data['usmail'] . "'";
            }
        }
        $object = new Usuario();
        $array = $object->List($where);
        return $array;
    }
}
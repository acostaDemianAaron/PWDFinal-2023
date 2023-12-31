<?php
class ABMUsuarioRol
{
    /** 
     * @param Array
     * @return Null|UsuarioRol
     */
    public function LoadObject($array)
    {
        $usuarioRol = NULL;
        $usuario = NULL;
        $rol = NULL;

        if (array_key_exists('idusuario', $array) && $array['idusuario'] != NULL) {
            $usuario = new Usuario();
            $usuario->setIdUsuario($array['idusuario']);
            $usuario->Load();
        }
        if (array_key_exists('idrol', $array) && $array['idrol'] != NULL) {
            $rol = new Rol();
            $rol->setIdRol($array['idrol']);
            $rol->Load();
        }

        $usuarioRol = new UsuarioRol();
        $usuarioRol->setValues($rol, $usuario);
        return $usuarioRol;
    }


    /** 
     * @param array
     * @return Boolean
     */
    public function Verify($array)
    {
        $res = FALSE;
        if (isset($array['idusuario']) || isset($array['idrol'])) {
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
        $usuarioRol = $this->LoadObject($array);
        if ($usuarioRol != NULL && $usuarioRol->Insert()) {
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
            $usuarioRol = $this->LoadObject($array);
            if ($usuarioRol != NULL && $usuarioRol->Delete()) {
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
            $usuarioRol = $this->Search($array);
            $usuarioRol = $this->LoadObject($array);
            if ($usuarioRol != NULL && $usuarioRol->Modify()) {
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
            if($this->Verify($array))
            {
                $on .= " and idusuario ='" . $array['idusuario'] . "'";
            }
        }

        $usuarioRol = new UsuarioRol();
        $arrayList = $usuarioRol->List($on);
        return $arrayList;
    }


    public function RolDescrip($arrayUsuarios){
        $rolesUs = [];
        foreach ($arrayUsuarios as $us) {
            $param['idusuario'] = $us->getIdUsuario();
            array_push($rolesUs, $this->Search($param)); //esto me devuelve un array de objetos usuario +rol
        }
        $rolesDesc = [];
        foreach ($rolesUs as $rolUs) {
            $roles = [];
            //aca me devuelve el array de roles de cada usuario:
            foreach ($rolUs as $rolU) {
                $rol = $rolU->getObjRol()->getRoDescripcion();
                array_push($roles, $rol);
            }
            array_push($rolesDesc, $roles);
        }
        return $rolesDesc;
    }
}
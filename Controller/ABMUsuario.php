<?php
class ABMUsuario
{
    /** 
     * @param Array
     * @return Null|Usuario
     */
    public function LoadObject($array)
    {
        $usuario = NULL;
        if ($this->Verify($array)) 
        {
            $usuario = new Usuario;
            $usuario->setIdUsuario($array['idusuario']);
            if ($usuario->Load()) {
                $sus = new Usuario;
                $sus->setIdUsuario($usuario->getIdUsuario());
                foreach ($array as $key => $data) {
                    if ($data != null) {
                        $sus = $this->checkData($key, $data, $usuario, $sus);
                    }
                }
                $usuario = $sus;
            } 
        }else if ((array_key_exists('usnombre', $array) && array_key_exists('uspass', $array) && array_key_exists('usmail', $array) || array_key_exists('usdeshabilitado', $array))) {
                $usuario = new Usuario();
                $usuario->setValues(null, $array['usnombre'], $array['uspass'], $array['usmail'], null); //TODO refactorizar (errores en carga de datos);
        }
        return $usuario;
    }

    public function checkData($key, $data, $usuario, $sus)
    {

        if ($data != null && $data != "null") {
            switch ($key) {
                case 'usnombre':
                    if ($usuario->getUsNombre() != $data) $sus->setUsNombre($data);
                    break;
                case 'uspass':
                    $sus->setUsPass($data);
                    break;
                case 'usmail':
                    if ($usuario->getUsMail() != $data) $sus->setUsMail($data);
                    break;
                case 'usdeshabilitado':
                    if ($usuario->getUsDeshabilitado()) $sus->setUsDeshabilitado($data);
                    break;
            }
        }

        return $sus;
    }

    /** 
     * @param Array
     * @return NULL|Usuario
     */
    public function LoadObjectId($array)
    {
        $usuario = NULL;
        if (isset($array['idusuario'])) {
            $usuario = new Usuario();
            $usuario->setIdUsuario($array['idusuario']);
            if (!$usuario->Load()) {
                $usuario = NULL;
            }
        }
        return $usuario;
    }

    /** 
     * @param Array
     * @return Boolean
     */
    public function Verify($array)
    {
        $res = FALSE;
        if (isset($array['idusuario'])) {
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
        $usuario = $this->LoadObject($array);
        if ($usuario != NULL && $usuario->Insert()) {
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
            $usuario = $this->LoadObjectId($array);
            if ($usuario != NULL && $usuario->Delete()) {
                $res =  TRUE;
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
            $usuario = $this->Search($array);
            $usuario = $this->LoadObject($array);
            if ($usuario != NULL && $usuario->Modify()) {
                $res = TRUE;
            }
        }
        return $res;
    }

    /** 
     * @param Array
     * @return Boolean|Array|String
     */
    public function Search($array = null)
    {
        $on = " true ";
        if ($array <> NULL) {
            if (isset($array['idusuario']))
                $on .= " and idusuario ='" . $array['idusuario'] . "'";
            if (isset($array['usnombre']))
                $on .= " and usnombre ='" . $array['usnombre'] . "'";
            if (isset($array['uspass']))
                $on .= " and uspass ='" . $array['uspass'] . "'";
            if (isset($array['usmail']))
                $on .= " and usmail ='" . $array['usmail'] . "'";
            if (isset($array['usdeshabilitado']))
                $on .= " and usdeshabilitado ='" . $array['usdeshabilitado'] . "'";
        }
        $usuario = new Usuario();
        $arrayList = $usuario->List($on);
        return $arrayList;
    }
}

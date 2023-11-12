<?
class ABMCompra{
   /**
    * @param Array
    * @return Null|Object
    */
   public function LoadObject($params = []){
      $res = null;
      
      if($this->Verify()){
         $objCompra = $this->LoadObjectId($params);
         $abmUsuario = new ABMUsuario;
         $objUsuario = $abmUsuario->LoadObjectId($params);
         $objCompra->setObjUsuario($objUsuario);
         if($objCompra->Load()){
            $res = $objCompra;
         }
      }

      return $res;
   }

   /**
    * Load Object by its ID
    * @param Array
    * @return Null|Compra
    */
   public function LoadObjectId($params = []){
      $res = null;
      if($this->Verify()){
         $instance = new Compra;
         $instance->SetIdCompra();
         if($instance->Load()){
            $res = $instance;
         }
      }
      return $res;
   }

   /**
    * Verify if primary key is set
    * @param Array
    * @return Boolean
    */
   public function Verify($params = []){
      return array_key_exists('idcompra', $params);
   }

   /**
    * @param Array
    * @return Boolean
    */
   public function Delete($param = []){
      $res = false;
      if($this->Verify($param)){
         $objCompra = new Compra();
         $res = $objCompra->Delete($params);
      }
      return $res;
   }

   /**
    * Search object by params, could be primary, forean or even both keys.
    * @param Array
    * @return Array
    */
   public function Search($params = []){
      $condition = '';
      $objCompra = new Compra();

      foreach($params as $key => $param){
         switch($key){
            case ' idcompra': $condition .= ' idcompra = ' . $param; break;
            case ' idusuario': $condition .= ' idusuario = ' . $param; break;
            default: $condition = ' true'; break;
         }
      }
      
      return $objCompra->List($condition);
   }
}
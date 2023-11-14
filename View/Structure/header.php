<?php

class Header{
   protected $title = "";
   protected $dirs = [];
   protected $rol = 0;
   
   /**
    * Construct header by parameters.
    * @param String $title
    * @param Array $dirs
    * @param Integer $rol
    */
   function __construct($title, $dirs, $rol)
   {
      // TODO refactor
      if(array_key_exists('usnombre', $_SESSION)){
         $usuario = new ABMUsuario;
         $usuarioRol = new ABMUsuarioRol;

         $idUsuario = $usuario->Search(['usnombre' => $_SESSION['usnombre']])[0]->getIdUsuario();
         // print_r($idUsuario);
         
         $rol = $usuarioRol->Search(['idusuario' => $idUsuario])[0]->getObjRol()->getIdRol();
      }
      // Arrow function for easier call inside heredoc.
      $loadMenu = fn($dirs, $rol) => $this->LoadMenues($dirs, $rol);
      $accountMenu = fn($idrol) => $this->accountButtons($idrol);

      // HereDoc
      echo 
      <<<HTML

      <!DOCTYPE html>
      <!-- Integrations -->
      <head>
         <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <!-- Bootstrap -->
         <link rel="stylesheet" href="{$dirs['LIBS']}Bootstrap-5.3.2/css/bootstrap.min.css">
         <script src="{$dirs['LIBS']}Bootstrap-5.3.2/js/bootstrap.min.js"></script>
         <script src="{$dirs['LIBS']}Bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>
         <!-- Jquery -->
         <script src="{$dirs['LIBS']}JQuery-3.7.1/jquery-3.7.1.min.js"></script>
         <!-- EasyUI -->
         <script src="{$dirs['LIBS']}JQuery-EasyUI-1.6.6/jquery.min.js"></script>
         <script src="{$dirs['LIBS']}JQuery-EasyUI-1.6.6/jquery.easyui.min.js"></script>
         <link rel="stylesheet" type="text/css" href="{$dirs['LIBS']}JQuery-EasyUI-1.6.6/themes/default/easyui.css">
         <link rel="stylesheet" type="text/css" href="{$dirs['LIBS']}JQuery-EasyUI-1.6.6/themes/icon.css">
         <link rel="stylesheet" type="text/css" href="{$dirs['LIBS']}JQuery-EasyUI-1.6.6/themes/color.css">
         <!-- Font Awesome -->
         <link rel="stylesheet" href="{$dirs['LIBS']}FontAwesome-6.4.2/css/all.min.css">
         <script src="{$dirs['LIBS']}FontAwesome-6.4.2/js/all.min.js"></script>
         <title>{$title}</title>
      </head>

      <body data-bs-theme="dark">
         <div class="cointainer">
            <header>
               <div class="px-3 py-2 border-bottom">
                  <div class="container">
                     <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                        <a href="{$dirs['INDEX']}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                           <i class="fa-solid  fa-laptop fa-2xl px-2"></i> <!-- Icon -->
                           <span class="fs-4">E-commerce</span>
                        </a>
                        <!-- Test page (Only visible for admin) -->
                        <a href="{$dirs['ROOT']}Test/test.php" class="nav-link px-2">
                           <div><i class="fa-solid fa-gauge me-1"></i>Test</div>
                        </a>

                        <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                           <li>
                           <a href="{$dirs['INDEX']}" class="nav-link text-secondary">
                              Home
                           </a>
                           </li>
                           <li>
                              <!-- TODO DIR -->
                              <a href="{$dirs['INDEX']}adminDashboard.php" class="nav-link px-2">
                                 <div><i class="fa-solid fa-gauge me-1"></i>Dashboard</div>
                              </a>
                           </li>
                           <!-- Load every menu for the current Session -->
                           {$loadMenu($dirs,$rol)}
                           <li>
                           <!-- Profile button -->
                           <a href="#" class="nav-link px-2">
                              <div><i class="fa-solid fa-user me-1"></i>Profile</div>
                           </a>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
               <!-- If there's no session, show LogIn/Register, in other case show LogOut and Profile -->
               <div class="px-3 py-2 border-bottom mb-3">
                  <div class="container d-flex flex-wrap justify-content-center">
                     <form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search">
                        <input type="search" class="form-control" name="search-input" placeholder="Search..." aria-label="Search">
                     </form>

                     <div class="text-end">
                        {$accountMenu($rol)}
                     </div>
                  </div>
               </div>
            </header>
         </div>

         <!-- Theme Changer button -->
         <div class="position-fixed bottom-0 end-0 mb-3 me-3">
            <button class="btn btn-dark btn-outline-light" id="toggle-theme"><i class="fa-regular fa-moon fs-4"></i></button>
         </div>

         <script>
            // Toggle theme
            $("button#toggle-theme").on("click", function(){
               if (document.querySelector("body").getAttribute('data-bs-theme') == 'dark') {
                  document.querySelector("body").setAttribute('data-bs-theme','light')
               } else {
                  document.querySelector("body").setAttribute('data-bs-theme','dark')
               }
            })
         </script>
      </body>

      HTML;
   }

   // Methods
   /**
    * Get the ID of the menues by the MenuRol table
    * @param Integer $idrol
    */
   private function GetMenuesRol($idrol){
      $abmMenuRol = new ABMMenuRol;
      return $abmMenuRol->Search(['idrol' => $idrol]);
   }

   /**
    * Get the menues by the IDs found in objects found by GetMenuRol
    * @param Array $menuRolArray Array that contains MenuRol objects
    * @return Array $menuesArray Array that contains Menu objects
    */
   private function GetMenues($menuRolArray){
      $abmMenu = new ABMMenu;
      $menuesArray = [];
      foreach($menuRolArray as $menurol){
         array_push($menuesArray, $abmMenu->Search(['idmenu' => $menurol->getObjMenu()->getIdMenu()])[0]);
      }
      return $menuesArray;
   }

   /**
    * Load every dropdown item from the array of children the menu has.
    * @param Array $children Array of menu's that need to be a dropdown item.
    * @return Heredoc $dropdown HTML code of the dropdown items.
    */
   private function LoadDropdown($children){
      $dropdown = "";
      foreach($children as $child){
         $dropdown .= <<<HTML
         <li><a class="dropdown-item" href="{$child->getMeDescripcion()}">{$child->getMeNombre()}</a></li>
         HTML;
      }
      return $dropdown;
   }

   /**
    * Load every menu for the present rol id.
    * @param Array $dirs Contains the config directories.
    * @param Integer $idrol Rol of current Session.
    * @return Heredoc $html HTML code of the buttons and dropdown if any.
    */
   private function LoadMenues($dirs, $idrol){
      $html = "";
      // TODO add logic to check Session. Maybe its better in a diff function.
      // Only show if is a verified Session.
      if($idrol != 0){
         $menurolArray = $this->GetMenuesRol($idrol);
         $menuesArray = $this->GetMenues($menurolArray);

         foreach($menuesArray as $menu){
            $abmMenu = new ABMMenu;
            $children = $abmMenu->Search(['idpadre' => $menu->getIdMenu()]);

            // if there is no children, make a redirectable button.
            if($children == []){
               $html .= <<<HTML
               <li>
                  <a href="{$dirs['INDEX']}{$menu->getMeDescripcion()}" class="nav-link px-2">
                     <div><i class="fa-solid fa-gauge me-1"></i>{$menu->getMeNombre()}</div>
                  </a>
               </li>
               HTML;
            } else {
               // If there are children, generate a dropdown button instead.
               $html .= <<<HTML
               <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                     {$menu->getMeNombre()}
                  </button>
                  <ul class="dropdown-menu">
                     <li><span class="dropdown-item-text">Options</span></li>
               HTML;

               $html .= $this->LoadDropdown($children);

               $html .= <<<HTML
                  </ul>
               </div>
               HTML;
            }
         }
      }
      return $html;
   }

   /**
    * Loads the buttons that need to be shown if logged or not.
    * @param Integer $idrol Rol of session.
    * @return Heredoc $html heredoc of buttons.
    */
   private function accountButtons($idrol){
      $html = "";
      if($idrol == 0){
         $html = <<<HTML
            <!-- End of optional buttons -->
            <button type="button" class="btn btn-secondary me-2">Log in</button>
            <button type="button" class="btn btn-primary" disabled>Sign-up</button>
         HTML;
      } else {
         $html = <<<HTML
            <!-- End of optional buttons -->
            <button type="button" class="btn btn-secondary me-2">Log out</button>
            <button type="button" class="btn btn-secondary me-2">Profile</button>
         HTML;
      }
      return $html;
   }
}
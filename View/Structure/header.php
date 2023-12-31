<?php

class Header{
   /**
    * Construct header by parameters.
    * @param string $title Title shown in current tab.
    * @param array $dirs Array that contains Strings of directories.
    * @return void
    */ 
   function __construct(string $title, array $dirs, int $privilege = null)
   {
      if($privilege != null){
         $session = new Session;
         if($session->getUser() != null) {
            $idrol = $this->GetRol($session->getUser()->getIdUsuario());
         } else {
            $idrol = 4;
         }
         if($idrol > $privilege){
            header('Location: ' . $dirs['INDEX'] . '?msg=insufficientPrivilege', true);
         }
      }
      // Load Head with integrations first.
      $this->GetIntegrations($title, $dirs['LIBS']);

      // Load Navbar.
      $this->GetNavbar($dirs);

      // If a msg was sent through GET or POST, show them as a Bootstrap Toast.
      $msg = data_submitted()['msg'] ?? null;
      if($msg != null && gettype($msg) == 'string') $this->ShowMessage($msg);
   }

   // Start of structure methods
   /**
    * Create Head.
    * Uses a title to set in the tab and directions to the libraries.
    * @param string $title
    * @param string $libsDir DIR set at config.
    * @return void
    */
   private function GetIntegrations(string $title, string $libsDir){
      echo <<<HTML
      <!DOCTYPE html>
      <!-- Integrations -->
      <head>
         <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <!-- Bootstrap -->
         <link rel="stylesheet" href="{$libsDir}Bootstrap-5.3.2/css/bootstrap.min.css">
         <script src="{$libsDir}Bootstrap-5.3.2/js/bootstrap.min.js"></script>
         <script src="{$libsDir}Bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>
         <!-- Jquery -->
         <script src="{$libsDir}JQuery-3.7.1/jquery-3.7.1.min.js"></script>
         <!-- EasyUI -->
         <script src="{$libsDir}JQuery-EasyUI-1.6.6/jquery.min.js"></script>
         <script src="{$libsDir}JQuery-EasyUI-1.6.6/jquery.easyui.min.js"></script>
         <link rel="stylesheet" type="text/css" href="{$libsDir}JQuery-EasyUI-1.6.6/themes/default/easyui.css">
         <link rel="stylesheet" type="text/css" href="{$libsDir}JQuery-EasyUI-1.6.6/themes/icon.css">
         <link rel="stylesheet" type="text/css" href="{$libsDir}JQuery-EasyUI-1.6.6/themes/color.css">
         <!-- Font Awesome -->
         <link rel="stylesheet" href="{$libsDir}FontAwesome-6.4.2/css/all.min.css">
         <script src="{$libsDir}FontAwesome-6.4.2/js/all.min.js"></script>
         <title>{$title}</title>
      </head>
      HTML;
   }

   /**
    * Loads the header(Navbar).
    * If there is a session active, the navbar will take care of loading respective buttons and href for each button.
    * @param array $dirs Directories saved on config.
    * @return void
    */
   private function GetNavbar(array $dirs){
      // Useful variables.
      $session = new Session;
      $rol = 0;

      // Check if session is set by the idUsuario.
      if($session->getUser() != null){
         $usuarioRol = new ABMUsuarioRol;
         $rol = $this->GetRol($session->getUser()->getIdUsuario());
         $rol = $usuarioRol->Search(['idusuario' => $session->getUser()->getIdUsuario()])[0]->getObjRol()->getIdRol();
      }

      // Arrow function for easier call inside heredoc.
      $loadMenu = fn($dirs, $idrol) => $this->LoadMenues($dirs, $idrol); // Reference to LoadMenu()
      $accountMenu = fn($dirs, $idrol) => $this->bottomBar($dirs, $idrol); // Reference to bottomBar()

      // Heredoc
      echo <<<HTML
      <body data-bs-theme="dark">
         <div class="cointainer">
            <header>
               <div class="px-3 py-2 border-bottom">
                  <div class="container">
                     <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                        <a href="{$dirs['ROOT']}View/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                           <!-- Logo and Title of website -->
                           <i class="fa-solid  fa-laptop fa-2xl px-2"></i> <!-- Icon -->
                           <span class="fs-4">E-commerce</span>
                        </a>

                        <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                           <li>
                              <a href="{$dirs['ROOT']}View/Store/catalogo.php" class="nav-link px-2">
                                 <div><i class="fa-solid fa-store me-1"></i></i>Store</div>
                              </a>
                           </li>
                           <li>
                              <a href="{$dirs['ROOT']}View/" class="nav-link px-2">
                                 <div><i class="fa-solid fa-house me-1"></i></i>Home</div>
                              </a>
                           </li>
                           <!-- Load on the right every menu for the current Session -->
                           {$loadMenu($dirs, $rol)}
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="px-3 py-2 border-bottom mb-3">
                  <div class="container d-flex flex-wrap justify-content-end">
                     <div class="text-end">
                        {$accountMenu($dirs, $rol)}
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
            // Toggle theme on click
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

   /**
    * Takes care of generating a toast with a message.
    * Information that can be useful to the user viewing the site.
    * Examples for msg: logoutSuccess, logoutError, login, updatedTable.
    * @param string $msg message that will be shown.
    * @return void
    */
   private function ShowMessage($msg){
      //Select messages to be shown.
      $options = [
         "logoutSuccess" => ["title" => "Logout", "msg" => "You've been logged out successfully!"],
         "logoutError" => ["title" => "Logout", "msg" => "There's been an error loggin out.<br>Try again or Contact support."],
         "login" => ["title" => "Login", "msg" => "You've been logged in!"],
         "updatedTable" => ["title" => "Table Update", "msg" => "The table was updated."],
         "store" => ["title" => "Store", "msg" => "You must log in to purchase."],
         "UpdateError" => ["title" => "Update", "msg" => "It wasn't possible to update any field."],
         "insufficientPrivilege" => ["title" => "Can't Load Page", "msg" => "You don't have privileges to open that page."],
         "changedProcess" => ["title" => "Successfull change", "msg" => "The state was changed."],
         "canceledPurchase" => ["title" => "Canceled", "msg" => "The purchase was canceled."]
      ];

      $messages = $options[$msg];

      echo <<<HTML
      <div class="toast-container position-fixed bottom-0 end-0 p-3 my-5">
         <div id="messageToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
               <i class="fa-solid fa-user me-2"></i>
               <strong class="me-auto">{$messages['title']}</strong>
               <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
               {$messages['msg']}
            </div>
         </div>
      </div>

      <script>
         const toastBootstrap = bootstrap.Toast.getOrCreateInstance($("#messageToast"))
         toastBootstrap.show()
      </script>
      HTML;
   }

   // End of structure methods

   // Methods
   /**
    * Find IdRol by Session's usname.
    * @param int $idusuario
    * @return int $idRol
    */
   private function GetRol(int $idusuario){
      $idRol = 0;
      $abmusuarioRol = new ABMUsuarioRol;
      $check = fn($array) => $array[0] ?? null;

      $usuarioRolArray = $abmusuarioRol->Search(['idusuario' => $idusuario]);
      if($check($usuarioRolArray)){
         $idRol = $usuarioRolArray[0]->getObjRol()->getIdRol();
      }

      return $idRol;
   }

   /**
    * Get the ID of the menues by the MenuRol table
    * @param int $idrol
    */
   private function GetMenuesRol(int $idrol){
      $abmMenuRol = new ABMMenuRol;
      return $abmMenuRol->Search(['idrol' => $idrol]);
   }

   /**
    * Get the menues by the IDs found in objects found by GetMenuRol
    * @param array $menuRolArray Array that contains MenuRol objects
    * @return Array $menuesArray Array that contains Menu objects
    */
   private function GetMenues(array $menuRolArray){
      $abmMenu = new ABMMenu;
      $menuesArray = [];
      foreach($menuRolArray as $menurol){
         array_push($menuesArray, $abmMenu->Search(['idmenu' => $menurol->getObjMenu()->getIdMenu()])[0]);
      }
      return $menuesArray;
   }

   /**
    * Load every dropdown item from the array of children the menu has.
    * @param array $children Array of menu's that need to be a dropdown item.
    * @param array $dirs Array of base directories.
    * @return heredoc $dropdown HTML code of the dropdown items.
    */
   private function LoadDropdown(array $children, array $dirs){
      $dropdown = "";
      foreach($children as $child){
         $dropdown .= <<<HTML
         <li><a class="dropdown-item" href="{$dirs['ROOT']}{$child->getMeDescripcion()}">{$child->getMeNombre()}</a></li>
         HTML;
      }
      return $dropdown;
   }

   /**
    * Load every menu for the present rol id.
    * @param array $dirs Contains the config directories.
    * @param int $idrol Rol of current Session.
    * @return heredoc $html HTML code of the buttons and dropdown if any.
    */
   private function LoadMenues(array $dirs, int $idrol){
      $html = "";
      // Only show if is a verified Session.
      if($idrol != 0){
         while($idrol <= 3){
            $menurolArray = $this->GetMenuesRol($idrol);
            $menuesArray = $this->GetMenues($menurolArray);

            foreach($menuesArray as $menu){
               $abmMenu = new ABMMenu;
               $children = $abmMenu->Search(['idpadre' => $menu->getIdMenu()]);

               // if there is no children, make a redirectable button.
               if($children == []){
                  $html .= <<<HTML
                  <li>
                     <a href="{$dirs['ROOT']}{$menu->getMeDescripcion()}" class="nav-link px-2">
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

                  $html .= $this->LoadDropdown($children, $dirs);

                  $html .= <<<HTML
                     </ul>
                  </div>
                  HTML;
               }
            }
            $idrol++;
         }
      }
      return $html;
   }

   /**
    * Loads the buttons that need to be shown if logged or not.
    * @param int $idrol Rol of session.
    * @return heredoc $html heredoc of buttons.
    */
   private function bottomBar(array $dirs, int $idrol){
      $html = "";
      if($idrol == 0){
         $html = <<<HTML
            <!-- End of optional buttons -->
            <a href="{$dirs['ROOT']}View/Login/login.php" class="btn btn-secondary me-2">Log in</a>
         HTML;
      } else {
         $abmMenu = new ABMMenu;
         $profileMenu = $abmMenu->Search(['menombre' => 'Perfil'])[0];
         $html = <<<HTML
            <!-- End of optional buttons -->
            <a href="{$dirs['ROOT']}View/Login/Action/logout.php" class="btn btn-secondary me-2">Log out</a>
            <a href="{$dirs['ROOT']}{$profileMenu->getMeDescripcion()}" class="btn btn-secondary me-2">Profile</a>
         HTML;
      }

      return $html;
   }
}
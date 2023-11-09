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
    * @return HTML
    */
   function __construct($rol)
   {
      // TODO Arreglar header
      // TODO Crear menu dinamicamente con los datos de la bd
      // TODO Implementar cambio de rol (con AJAX para visualizar y debuggear mas rapido)


      // Show Dirs
      // print_r($dirs);

      // Needs authentication process to decide menues.
      return 
      <<<HTML

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
                           <a href="{$dirs['INDEX']}adminDashboard" class="nav-link px-2">
                              <div><i class="fa-solid fa-gauge me-1"></i>Dashboard</div>
                           </a>
                           </li>
                           <li>
                           <!-- TODO DIR -->
                           <a href="#" class="nav-link px-2">
                              <div><i class="fa-solid fa-list me-1"></i>Orders</div>
                           </a>
                           </li>
                           <li>
                           <!-- TODO DIR -->
                           <a href="#" class="nav-link px-2">
                              <div><i class="fa-solid fa-bag-shopping me-1"></i>Products</div>
                           </a>
                           </li>
                           <li>
                           <!-- TODO DIR -->
                           <a href="#" class="nav-link px-2">
                              <div><i class="fa-solid fa-user me-1"></i>Profile</div>
                           </a>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="px-3 py-2 border-bottom mb-3">
                  <div class="container d-flex flex-wrap justify-content-center">
                     <form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search">
                        <input type="search" class="form-control" name="search-input" placeholder="Search..." aria-label="Search">
                     </form>

                     <div class="text-end">
                        <!-- Optional buttons -->
                        <button type="button" class="btn btn-secondary me-2">Log out</button>
                        <!-- End of optional buttons -->
                        <button type="button" class="btn btn-secondary me-2">Log in</button>
                        <button type="button" class="btn btn-primary">Sign-up</button>
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
}
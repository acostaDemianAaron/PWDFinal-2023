<?php
class Header{
   function __construct($title, $dirs, $rol)
   {
      // Show Dirs
      // print_r($dirs);

      // Needs authentication process to decide menues.
      echo 
      <<<HTML
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
         <!-- <script src="{$dirs['LIBS']}JQuery-EasyUI-1.6.6/jquery.min.js"></script>
         <script src="{$dirs['LIBS']}JQuery-EasyUI-1.6.6/jquery.easyui.min.js"></script> -->
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
                        <!-- TODO DIR -->
                        <a href="{$dirs['INDEX']}/test.php" class="nav-link px-2">
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
                           <a href="#" class="nav-link px-2">
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
                        <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
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
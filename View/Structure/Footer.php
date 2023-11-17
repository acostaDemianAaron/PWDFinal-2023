<?php
class Footer {
   function __construct(){
   echo <<<HTML
   <body class="d-flex flex-column min-vh-100">
      <div class="container mt-auto">
         <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <div class="col-md-4 d-flex align-items-center">
               <a href="#" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
                  <i class="fa-solid fa-users-rectangle"></i>
               </a>
               <span class="mb-3 mb-md-0 text-body-secondary">© 2023 Grupo 4</span>
            </div>

            <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
               <li class="mx-3 text-center"><a class="text-body-secondary" href="https://github.com/acostaDemianAaron"><i class="fa-brands fa-square-github fa-2xl"></i><br>Aaron</a></li>
               <li class="mx-3 text-center"><a class="text-body-secondary" href="https://github.com/veraAlan"><i class="fa-brands fa-square-github fa-2xl"></i><br>Alan</a></li>
               <li class="mx-3 text-center"><a class="text-body-secondary" href="https://github.com/SantiagoYaitul"><i class="fa-brands fa-square-github fa-2xl"></i><br>Santiago</a></li>
            </ul>
         </footer>
      </div>
   </body>

   HTML;
   }
}
?>
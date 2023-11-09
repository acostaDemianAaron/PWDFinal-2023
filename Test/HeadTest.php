<?php
class Head{
   public function __construct($title, $dirs)
   {
      // Show Dirs
      // print_r($dirs);
      
      echo <<<HTML

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

      HTML;
   }
}
<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reservas Coltec</title>

        <link rel="shortcut icon" href="Images/logo.png">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="css/custom.css">

        <!-- Bulma CSS -->
        <link rel="stylesheet" href="./css/bulma.min.css">

        <!-- Font Awesome -->
        <script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js"></script>

        <!-- JQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>

  <body>

        <!-- Menu navbar -->
        <?php include "Includes/menu.inc"; ?>


        <!-- Reservas -->
        <?php
            include "Includes/reserva.inc";

            $dao_i = new ItemDao();
            $dao_r = new ReservaDao();

            if (isset($_GET["tag"])){
                $itens = $dao_i->read_by_tipo($_GET["tag"]);
            }else{
                $itens = $dao_i->read_all();
            }

            foreach ($itens as $i){
              echo '<section class="section">';
              echo '<div class="container">';
                echo '<h2 class="title">'. $i->nome .'</h2>';
                $reservas = $dao_r->read_by_place($i->nome);
                print_reservas_por_item($reservas);
              echo '</div>';
              echo '</section>';
            }
        ?>



    <!-- Importando os scripts -->
    <?php require "Includes/scripts.inc"; ?>

  </body>
</html>

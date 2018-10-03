<?php session_start(); ?>

<!DOCTYPE html>
<html>
  <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reserva de Item</title>
        <link rel="stylesheet" href="./css/bulma.min.css">
        <link rel="stylesheet" href="css/custom.css">
        <script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  </head>

  <body>

    <?php include "Includes/menu.inc"; ?>

    <section class="section">

      <div class="container">

        <?php
            if (!isset($_SESSION["login"])){
                echo "<h1 class='title'> Você não está logado! </h1>";
                echo "<p>Entre na plataforma para realizar uma reserva</p>";
            }else{
                    require "Controllers/ItemDao.php";
                    require "Includes/reserva.inc";

                    date_default_timezone_set('America/Sao_Paulo');


                    if (isset($_POST["item"])) { // Está na parte de Dados da Reserva

                        if ($_POST["declaracao"] == ""){
                            carrega_reserva(1); // Não aceitou os termos

                        }else if($_POST["data"] == "" || $_POST["inicio"] == "" || $_POST["termino"] == ""){
                            carrega_reserva(2); // Não preencheu todos os campos

                        }else if (verifica_disponibilidade($_POST["item"], $_POST["tipo-de-reserva"], $_POST["data"], $_POST["inicio"], $_POST["termino"]) == 0){
                            carrega_reserva(3); // Horário indisponível

                        }else{
                            $dao = new ReservaDao();
                            $reserva = new Reserva($_POST["nome"], $_SESSION["matricula"], $_POST["item"], $_POST["tipo-de-reserva"], $_POST["data"], $_POST["inicio"], $_POST["termino"]);
                            $dao->insert($reserva);
                            echo "<section class='section'>
                              <div class='container'>
                                <h1 class='title'> Reserva realizada com sucesso! </h1>
                              </div>
                            </section>";
                        }

                    }else{ // Primeiro acesso ao site
                        carrega_reserva(0);
                    }
                ?>

                <script>
                    var dia = new Date();
                            var dd = dia.getDate();
                            var mm = dia.getMonth()+1; // Janeiro = 0
                            var yyyy = dia.getFullYear();
                            if(dd<10){
                                dd='0'+dd;
                            }
                            if(mm<10){
                                mm='0'+mm;
                            }
                            dia = yyyy + '-' + mm + '-' + dd;

                    $("#dia").append('<input class="input" type="date" name="data" id="input-dia" value="' + dia + '">');
                    $('#reservas-form .radio').on('change', function() {
                        $("#input-dia").remove();
                        if ($('input[name=tipo-de-reserva]:checked', 'form').val() == "Diária"){ // Dia único
                            $("#dia").append('<input class="input" type="date" name="data" id="input-dia" value="' + dia + '">');
                        }else if ($('input[name=tipo-de-reserva]:checked', 'form').val() == "Semanal"){ // Semanal
                            $("#dia").append('<select name="data" id="input-dia" class="input">'
                                + '<option value="1">Segunda</option>'
                                + '<option value="2">Terça</option>'
                                + '<option value="3">Quarta</option>'
                                + '<option value="4">Quinta</option>'
                                + '<option value="5">Sexta</option>'
                                + '<option value="6">Sábado</option>'
                            + '</select>');
                        }

                    });

                </script>

            <?php } require "Includes/scripts.inc"; ?>
  </body>
</html>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">

        <!-- Bootstrap -->
        <link href="<?php echo base_url() . "public_html/bootstrap/css/bootstrap.min.css" ?>" rel="stylesheet">
        <link href="<?php echo base_url() . "public_html/css/reset.csss" ?>" rel="stylesheet">
        <link href="<?php echo base_url() . "public_html/font-awesome-4.6.3/css/font-awesome.min.css" ?>" rel="stylesheet">

        <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>
        <!-- (Optional) Latest compiled and minified JavaScript translation files -->
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/i18n/defaults-*.min.js"></script> -->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js "></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo base_url() . "public_html/bootstrap/js/bootstrap.min.js" ?>"></script>

        <title>Header</title>


    </head>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="col-xs-12">

                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span> 
                        </button>
                        <a class="navbar-brand" href="#">WebSiteName</a>
                    </div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav">
                            <?php if ($usuari["camarer"] == "Y") { ?>
                                <li><a href="<?php echo site_url('Camarer/index'); ?>">Camarer</a></li>
                            <?php } ?>
                            <?php if ($usuari["cuiner"] == "Y") { ?>
                                <li><a href="<?php echo site_url('Cuiner/index'); ?>">Cuiner</a></li>
                            <?php } ?>
                            <?php if ($usuari["administrador"] == "Y") { ?>
                                <li><a href="<?php echo site_url('Administrador/index'); ?>">Administrador</a></li>
                            <?php } ?>
                            <?php if ($usuari["administrador_usuaris"] == "Y") { ?>
                                <li><a href="<?php echo site_url('Administrador_Usuaris/index'); ?>">Administrar usuaris</a></li>
                            <?php } ?>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $usuari["nom"] ?></a></li>
                            <li><a href="<?php echo site_url('Login/sortir'); ?>">Tancar Sessio <span class="glyphicon glyphicon-log-out"></span></a></li>
                        </ul>
                    </div>

                </div>

            </div>

        </nav>



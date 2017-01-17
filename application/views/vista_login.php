<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>

        <meta charset="UTF-8">
        <title>Login</title>

        <!-- Bootstrap -->
        <link href="<?php echo base_url() . "public_html/bootstrap/css/bootstrap.min.css" ?>" rel="stylesheet">
        <link href="<?php echo base_url() . "public_html/css/estil_login.css" ?>" rel="stylesheet">

        <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>
        <!-- (Optional) Latest compiled and minified JavaScript translation files -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/i18n/defaults-*.min.js"></script>


    </head>
    <body>

        <div class="container">

            <div class="row">
                <div class="col-md-4">
                </div>

                <div class="col-md-4">
                    <section class="login-form">
                        <form name="f1" method="post" action="<?php echo site_url('Login/entrar'); ?>" role="login">
                            <img src="http://i.imgur.com/RcmcLv4.png" class="img-responsive" alt="" />
                            <input type="text" name="nom" placeholder="Nom" class="form-control input-lg"/>
                            <input type="password" name="password" placeholder="Password" class="form-control input-lg" />

                            <button type="submit" name="go" class="btn btn-lg btn-primary btn-block">Inicia sessió</button>
                            <div>
                                <a href="#">Crear compte</a> or <a href="#">reset password</a>
                            </div>

                        </form>

                        <div class="form-links">
                            <a href="#">www.website.com</a>
                        </div>
                    </section>  
                </div>

                <div class="col-md-4"></div>

            </div>


        </div>

        <br/>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js "></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo base_url() . "public_html/bootstrap/js/bootstrap.min.js" ?>"></script>


    </div>
</body>
</html>

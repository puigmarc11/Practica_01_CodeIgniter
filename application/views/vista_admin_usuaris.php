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

        <!-- Bootstrap -->
        <link href="<?php echo base_url() . "public_html/bootstrap/css/bootstrap.min.css" ?>" rel="stylesheet">
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>
        <!-- (Optional) Latest compiled and minified JavaScript translation files -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/i18n/defaults-*.min.js"></script>

        <title></title>

        <style>

            table, tr, th, td {
                text-align: center;
            }

        </style>

    </head>
    <body>

        <div class="container">
            <h2>Llistat usuaris </h2>

            <form name='f2' method='post' action="<?php echo site_url('Administrador_Usuaris/edicio') ?>">


                <table class="table table-hover table-bordered table-striped" >
                    <tr>
                        <th>ID</th>
                        <th>EMAIL</th>
                        <th>NOM</th>
                        <th>Camarer</th>
                        <th>Cuiner</th>
                        <th>Administrador</th>
                        <th>Administrador d'usuaris</th>
                        <th>Actiu</th>
                        <th colspan="2">Editar</th>
                    </tr>


                    <?php
                    foreach ($llista_usuaris as $row) {
                        ?>

                        <tr class="<?php echo $row->classe ?>" align="center">
                            <td>
                                <?php echo $row->id ?>
                            </td>
                            <td>
                                <?php echo $row->edicio == true ? "<input type='text' name='mail' value='$row->mail'>" : $row->mail; ?>
                            </td>
                            <td>
                                 <?php echo $row->edicio == true ? "<input type='text' name='nom' value='$row->nom'>" : $row->nom; ?>
                            </td>
                            <td>
                                <input type="checkbox" name="camarer" value="camarer"  <?php echo $row->camarer == "Y" ? " checked " : "" ?><?php echo $row->edicio == true ? "" : " disabled " ?>>
                            </td>
                            <td>
                                <input type="checkbox" name="cuiner" value="cuiner" <?php echo $row->cuiner == "Y" ? " checked " : "" ?><?php echo $row->edicio == true ? "" : " disabled " ?>>
                            </td>
                            <td>
                                <input type="checkbox" name="administrador" value="administrador" <?php echo $row->administrador == "Y" ? " checked " : "" ?><?php echo $row->edicio == true ? "" : " disabled " ?>>
                            </td>
                            <td>
                                <input type="checkbox" name="administrador_usuaris" value="administrador_usuaris" <?php echo $row->administrador_usuaris == "Y" ? " checked " : "" ?><?php echo $row->edicio == true ? "" : " disabled " ?>>
                            </td>
                            <td>
                                <input type="checkbox" name="actiu" value="actiu" <?php echo $row->actiu == "1" ? " checked " : "" ?><?php echo $row->edicio == true ? "" : " disabled " ?>>	
                            </td>
                            <td colspan="<?php echo $row->edicio == true ? "1" : "2" ?>">

                                <?php if ($edicio == false) { ?><a href=" <?php echo site_url('Administrador_Usuaris/edicio/' . $row->id); ?>">Editar</a><?php } else if ($row->edicio == true) { ?>
                                    <a href="#" onclick="document.forms['f2'].submit();">Update</a>
                                <?php } ?>

                            </td>
                            <?php
                            if ($row->edicio) {
                                ?>

                                <td>
                                    <a href="<?php echo site_url('Administrador_Usuaris/eliminar') ?>" >Eliminar</a>
                                </td>
                                <?php
                            }
                            ?>

                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </form>
        </div>

        <div class="container">
            <h2>Crear nou usuari</h2>

            <?php echo form_open('Administrador_Usuaris/validar'); ?>
        <!-- <form name="f1" method="post" action="<?php //echo site_url('Administrador_Usuaris/crear_usuari')      ?>"> -->
            <div class="form-group">

                <label for="mail">Email: <?php echo form_error('mail'); ?></label>
                <input type="text" class="form-control" id="mail" name="mail" value="<?php echo validation_errors() == "" ? "" : set_value('mail'); ?>">
            </div>
            <div class="form-group">
                <label for="nom">Nom: <?php echo form_error('nom'); ?></label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?php echo validation_errors() == "" ? "" : set_value('nom'); ?>">
            </div>
            <div class="form-group">
                <label for="pwd">Password:  <?php echo form_error('password'); ?></label>
                <input type="password" class="form-control" id="password" name="password">

            </div>

            <table class="table table-bordered">
                <tr align="center">
                    <td>Camarer</td>
                    <td>Cuiner</td>
                    <td>Administrador</td>
                    <td>Administrador usuaris</td>          
                </tr>
                <tr align="center">
                    <td><input type="checkbox" name="camarer" value="camarer"></td>
                    <td><input type="checkbox" name="cuiner" value="cuiner"></td>
                    <td><input type="checkbox" name="administrador"></td>
                    <td><input type="checkbox" name="administrador_usuaris"></td>       
                </tr>
            </table>

            <button type="Crear" class="btn btn-default">Submit</button>
        </form>



    </div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js "></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url() . "public_html/bootstrap/js/bootstrap.min.js" ?>"></script>

</body>

</html>
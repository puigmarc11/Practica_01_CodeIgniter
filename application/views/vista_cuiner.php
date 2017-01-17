<style>

    #taulaComanda{
        margin-top: 20px;

    }

    #taulaComanda table,#taulaComanda tr,#taulaComanda th,#taulaComanda td {

        text-align: center;
        vertical-align: middle;

        .text{
            text-align: left;  
        }

    }

    #taulaComanda td.left{
        text-align: left;
    }

    #taulaComanda tr.bbb{
        border: none;
        //background-color: rgba(150,150,100,0.5);
        background-color: goldenrod;
    }

</style>

<div class="container">

    <div class="row">

        <div class="col-xs-12">
            <h3>Comandes</h3>

            Filtre: 
            <form name="f1" method="post" action="<?php echo site_url('Cuiner/filtrar_productes'); ?>">
                <label class="checkbox-inline"><input name="Plat" type="checkbox" value="plats" <?php echo $filtre == NULL ? "checked" : $filtre == "Plat" ? "checked" : "" ?> onclick="document.forms['f1'].submit();">
                    <i class="fa fa-cutlery" aria-hidden="true"></i>
                </label>
                <label class="checkbox-inline"><input name="Beguda" type="checkbox" value="begudes" <?php echo $filtre == NULL ? "checked" : $filtre == "Beguda" ? "checked" : "" ?> onclick="document.forms['f1'].submit();">
                    <i class="fa fa-glass" aria-hidden="true"></i>
                </label>
            </form>

        </div>

        <div class="col-xs-12">

            <form name="f2" method="post" action="<?php echo site_url('Cuiner/cuinar_productes'); ?>">
                <input type="submit" name="cuinar_productes" class="btn btn-lg btn-success btn-block" value="Cuinar productes"/>
                <table id="taulaComanda" class="table table-hover table-bordered">
                    <tr>
                        <th class="hidden-xs">CAT.</th>
                        <th class="hidden-xs">TAULA</th>
                        <th>NOM</th>
                        <th>QUANTITAT</th>

                        <th>ESTAT PROD.</th>
                    </tr>
                    <?php
                    $idA = "";
                    foreach ($comandes as $c) {

                        if ($idA != $c["id"] && $idA != "") {
                            $idA = $c["id"];
                            echo "<tr class='bbb'><td colspan='6'></td></tr>";
                        } else {
                            $idA = $c["id"];
                        }
                        ?>
                        <tr class="<?php echo $c["estat_prod"] === "cuinant" ? "success" : "" ?>">
                            <?php
                            if ($c["categoria"] == "Plat") {
                                ?>  <td class="hidden-xs"><i class="fa fa-cutlery" aria-hidden="true"></i></td> <?php
                            } else {
                                ?>  <td class="hidden-xs"><i class="fa fa-glass" aria-hidden="true"></i></td> <?php }
                            ?>

                            <td class="hidden-xs"><?php echo $c["taula"] . " - (Ordre: " . $c["ordre"] . ")" ?></td>
                            <td class="left"><?php echo $c["producte"] ?></td>
                            <td><?php echo "X " . $c["quantitat"] ?></td>
                            <td>                        
                                <select name="estat_prod[]" class="selectpicker form-control" title="Selecciona una estat">
                                    <option value='no_iniciat' <?php echo $c["estat_prod"] === "no_iniciat" ? "selected" : "" ?> >No iniciat</option>
                                    <option value='cuinant'  <?php echo $c["estat_prod"] === "cuinant" ? "selected" : "" ?> >Cuinant</option>
                                    <option value='preparat'  <?php echo $c["estat_prod"] === "preparat" ? "selected" : "" ?> >Preparat</option>
                                </select>
                            </td>

                        </tr>
                        <input type="hidden" name="id_ordre_comanda[]" value="<?php echo $c["id"] ?>" >
                        <input type="hidden" name="ordre_comanda[]" value="<?php echo $c["ordre"] ?>" >
                        <input type="hidden" name="id_detall_comanda[]" value="<?php echo $c["id_detall_comanda"] ?>" >
                        <?php
                    }
                    ?>
                </table>
            </form>
            
        </div>

    </div>

</div>


</body>
</html>

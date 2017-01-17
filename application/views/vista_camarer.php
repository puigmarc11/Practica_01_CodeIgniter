<style>
    #taulaComanda table,#taulaComanda tr,#taulaComanda th,#taulaComanda td {
        text-align: center;
    }
</style>


<script>

    var plats = [];

    function dibuixarTaula() {

        var s = "";

        s = "<tr><th>ID</th><th>NOM</th><th>QUANTITAT</th></tr>"

        for (var i in plats) {
            s += "<tr><td>" + plats[i][0] + "</td><td>" + plats[i][1] + "</td><td>" + plats[i][2] + "</td></tr>"
        }

        document.getElementById("taulaComanda").innerHTML = s
        document.getElementById("comanda").value = JSON.stringify(plats);
        ;

        var jj =
                console.info(jj);

    }

    function afegirPlats(id, nom, categoria) {

        var trobat = false;


        for (var i in plats) {
            if (plats[i][0] === id) {
                plats[i][2] = plats[i][2] + 1;
                trobat = true;
            }
        }

        if (!trobat) {
            plats.push([id, nom, 1]);
        }

        dibuixarTaula();

    }

    function treurePlats(id) {

        for (var i = 0; i < plats.length; i++) {
            if (plats[i][0] === id) {
                plats[i][2] = plats[i][2] - 1;
                if (plats[i][2] === 0) {
                    plats.splice(i, 1);
                }
            }
        }

        dibuixarTaula();

    }



</script>

<div class="container">

    <div class="row">
        <div class="col-xs-12">
            <h3>Selecciona una taula (<?php echo isset($taulaSeleccionada) ? "TAULA: " . $taulaSeleccionada . "" : "" ?>)</h3>
            <form name="f1" method="post" action="<?php echo site_url('Camarer/seleccionar_taula'); ?>">
                <div class="form-group">

                    <div class="input-group">

                        <select name="taula" class="selectpicker form-control" title="Selecciona una taula" onchange='this.form.submit()'>
                            <?php
                            foreach ($taules as $taula) {

                                if (isset($taulaSeleccionada) && $taulaSeleccionada == $taula["id"]) {
                                    echo "<option value='" . $taula["id"] . "' selected >Taula " . $taula["id"] . "</option>";
                                } else {
                                    echo "<option value='" . $taula["id"] . "'>Taula " . $taula["id"] . "</option>";
                                }
                            }
                            ?>
                        </select>

                        <span class="input-group-btn">
                            <Button type="submit" name="seleccioTaula" class="btn  btn-primary" value="seleccioTaula">Selecciona</button>
                        </span>
                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

<div class="container <?php echo isset($taulaSeleccionada) ? "" : "hidden" ?>">

    <div class="row">

        <div class="col-md-3">

            <h3>Llista productes</h3>
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading" data-toggle="collapse" href="#collapse1">
                        <h4 class="panel-title">
                            <p>PLATS</p>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse">
                        <table width="100%">
                            <?php
                            foreach ($plats as $p) {
                                echo "<tr>";
                                echo "<td class='panel-body col-xs-8'>" . $p["nom"] . "</td>";
                                ?>
                                <td><input type="button" value="+" class="btn  btn-success" onclick="afegirPlats('<?php echo $p["id"] ?>', '<?php echo $p["nom"] ?>', '<?php echo $p["categoria"] ?>')"></td>
                                <td><input type="button" value="-" class="btn  btn-danger" onclick="treurePlats('<?php echo $p["id"] ?>')"></td>
                                <?php
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" data-toggle="collapse" href="#collapse2">
                        <h4 class="panel-title">
                            <p>BEGUDES</p>
                        </h4>
                    </div>
                    <div id="collapse2" class="panel-collapse collapse">
                        <table width="100%">
                            <?php
                            foreach ($begudes as $b) {
                                echo "<tr>";
                                echo "<td class='panel-body col-xs-8'>" . $b["nom"] . "</td>";
                                ?>
                                <td><input type="button" value="+" class="btn  btn-success" onclick="afegirPlats('<?php echo $b["id"] ?>', '<?php echo $b["nom"] ?>', '<?php echo $b["categoria"] ?>')"></td>
                                <td><input type="button" value="-" class="btn  btn-danger" onclick="treurePlats('<?php echo $b["id"] ?>')"></td>
                                <?php
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>

        </div>


        <div class="col-md-8">

            <h3>Productes nova comanda</h3>
            <form name="f2" method="post" action="<?php echo site_url('Camarer/crear_comanda'); ?>">
                <table id="taulaComanda" class="table table-hover table-bordered table-striped">
                    <tr>
                        <th>ID</th>
                        <th>NOM</th>
                        <th>QUANTITAT</th>
                    </tr>
                </table>
                <input type="hidden" id="comanda" name="comanda">
                <input type="submit" name="crear_comanda" class="btn btn-lg btn-primary btn-block" value="Crear comanda"/>
            </form>


        </div>

        <div class="col-md-12">

            <h3>Productes de la taula</h3>
            <table id="taulaComanda" class="table table-hover table-bordered table-striped">
                <tr>
                    <th>ID</th>
                    <th>NOM</th>
                    <th>QUANTITAT</th>
                </tr>
                <?php
                foreach ($productesTaula as $p) {

                    if ($p->estat == "fet") {
                        $classe = "success";
                    } else if ($p->estat == "cuinant") {
                        $classe = "warning";
                    } else {
                        $classe = "danger";
                    }
                    ?>
                    <tr class="<?php echo $classe ?>">
                        <td><?php echo $p->id; ?></td>
                        <td><?php echo $p->producte; ?></td>
                        <td><?php echo $p->quantitat; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>

        </div>

    </div>




</div>


</body>
</html>

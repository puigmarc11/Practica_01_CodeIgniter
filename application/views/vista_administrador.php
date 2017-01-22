<style>
    #taulaComanda table,#taulaComanda tr,#taulaComanda th,#taulaComanda td {
        text-align: center;
    }
</style>

<div class="container">

    <div class="row">

        <div class="col-xs-12 col-md-8">

            <div class="col-xs-12">


                <h2>Taules Ocupades</h2>
                <ul>
                    <?php
                    foreach ($llista_taules_obertes as $row) {
                        ?>
                        <li><a href='<?php echo site_url('Administrador/visualitzar_factura/' . $row->taula) ?>' >Taula <?php echo $row->taula ?> -- Visualitzar factura</a></li>
                        <?php
                    }
                    ?>
                </ul>

            </div>


            <div class="col-xs-12 <?php echo isset($_SESSION["taula_factura"]) ? "" : "hidden" ?>">

                <h3>Productes de la taula</h3>
                <table id="taulaComanda" class="table table-hover table-bordered">
                    <tr>
                        <th colspan="4">Taula <?php echo isset($_SESSION["taula_factura"]) ? $_SESSION["taula_factura"] : "" ?> </th>

                    </tr>
                    <tr>
                        <th>Producte</th>
                        <th>Quantitat</th>
                        <th>Preu/Unitat</th>
                        <th>Preu</th>
                    </tr>
                    <?php
                    $total = 0;

                    foreach ($productesTaula as $p) {
                        ?>
                        <tr>
                            <td><?php echo $p["producte"]; ?></td>
                            <td><?php echo "x " . $p["quantitat"]; ?></td>
                            <td><?php echo $p["preu"] . " €" ?></td>
                            <td><?php echo $p["preu"] * $p["quantitat"] . " €" ?></td>
                        </tr>
                        <?php
                        $total += $p["preu"] * $p["quantitat"];
                    }
                    ?>

                    <tr>
                        <th colspan="3">IVA 10%</th>
                        <th><?php echo $total * 0.1 . " €" ?></th>
                    </tr>
                    <tr>
                        <th colspan="3">TOTAL</th>
                        <th><?php echo $total . " €" ?></th>
                    </tr>
                </table>

                <?php
                if ($_SESSION["historic"] == null) {
                    ?>
                    <form name='f2' method='post' action="<?php echo site_url('Administrador/generar_factura') ?>">
                        <input class="btn btn-primary" type="submit" value="Generar Factura" name="generar">
                    </form>
                    <?php
                } else {
                    ?>
                    <form name='f2' method='post' action="<?php echo site_url('Administrador/generar_pdf') ?>">
                        <input class="btn btn-primary" type="submit" value="Imprimir PDF" name="generar">
                    </form>
                    <?php
                }
                ?>



            </div>


        </div>

        <div class="col-xs-12 col-md-4">

            <h2>Històric de factures</h2>
            <ul>

                <?php
                foreach ($llista_factures as $factura) {

                    echo "<li><a href='" . site_url('Administrador/visualitzar_factura/' . $factura->id . '/historic') . "'>" . $factura->data . " --> $factura->total €" . "</a></li>";
                }
                ?>

            </ul>

        </div>

    </div>

</div>
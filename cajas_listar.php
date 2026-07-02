<?php

include "conexion.php";

$cnn = conection();

/* Consulta */

$sql = "
SELECT

    c.id_caja,
    c.fecha_hora,
    c.detalle_movimiento,
    c.importe,
    fp.descripcion AS formas_pago

FROM cajas c

INNER JOIN formas_pagos fp
    ON c.id_formas_pago = fp.id_formas_pago

WHERE c.deleted = 0

ORDER BY c.fecha_hora DESC,
         c.id_caja DESC
";

$resultado = mysqli_query($cnn, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($cnn));
}

?>

<div class="container mt-4">

    <h2>Registro de Caja</h2>

    <table class="table table-striped table-hover">

        <thead class="table-dark">

            <tr>

                <th>ID</th>
                <th>Fecha y Hora</th>
                <th>Detalle del Movimiento</th>
                <th>Importe</th>
                <th>Forma de Pagos</th>

            </tr>

        </thead>

        <tbody>

        <?php while($fila = mysqli_fetch_assoc($resultado)){ ?>

            <tr>

                <td><?= $fila['id_caja'] ?></td>

                <td><?= date('d/m/Y H:i', strtotime($fila['fecha_hora'])) ?></td>

                <td><?= htmlspecialchars($fila['detalle_movimiento']) ?></td>

                <td>$<?= number_format($fila['importe'], 2, ',', '.') ?></td>

                <td><?= htmlspecialchars($fila['formas_pago']) ?></td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>
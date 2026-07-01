<?php

include "conexion.php";

$cnn = conection();

/* Eliminación lógica */

if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {

    $id = intval($_GET['eliminar']);

    $sqlEliminar = "
        UPDATE compra_detalles
        SET deleted = 1
        WHERE id_compra_detalle = $id
    ";

    mysqli_query($cnn, $sqlEliminar);

    echo "
    <script>
        window.location='index.php?seccion=compra_detalles&accion=listar';
    </script>";
    exit;
}

/* Consulta */

$sql = "
SELECT

    cd.id_compra_detalle,

    c.id_compra,

    p.id_producto,

    cd.cantidad,

    cd.precio_unitario,

    cd.precio_total

FROM compra_detalles cd

INNER JOIN compras c
    ON cd.id_compra = c.id_compra

INNER JOIN productos p
    ON cd.id_producto = p.id_producto

WHERE cd.deleted = 0

ORDER BY cd.id_compra_detalle DESC
";

$resultado = mysqli_query($cnn, $sql);

?>

<div class="container mt-4">

    <h2>Detalle de Compras</h2>

    <a
        href="index.php?seccion=compra_detalles&accion=modificar"
        class="btn btn-success mb-3">
        Nuevo Detalle
    </a>

    <table class="table table-striped table-hover">

        <thead class="table-dark">

            <tr>

                <th>ID</th>
                <th>Compra</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
                <th>Acciones</th>

            </tr>

        </thead>

        <tbody>

        <?php while($fila = mysqli_fetch_assoc($resultado)){ ?>

            <tr>

                <td><?= $fila['id_compra_detalle'] ?></td>

                <td>#<?= $fila['id_compra'] ?></td>

                <td><?= htmlspecialchars($fila['producto']) ?></td>

                <td><?= $fila['cantidad'] ?></td>

                <td>$<?= number_format($fila['precio_unitario'],2) ?></td>

                <td>
                    <strong>
                        $<?= number_format($fila['precio_total'],2) ?>
                    </strong>
                </td>

                <td>

                    <a
                        href="index.php?seccion=compra_detalles&accion=modificar&id=<?= $fila['id_compra_detalle'] ?>"
                        class="btn btn-warning btn-sm">
                        Modificar
                    </a>

                    <a
                        href="index.php?seccion=compra_detalles&accion=listar&eliminar=<?= $fila['id_compra_detalle'] ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Desea eliminar este detalle?')">
                        Eliminar
                    </a>

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>
<?php

include "conexion.php";

$cnn = conection();

/* Eliminación lógica */

if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {

    $id_compra = intval($_GET['eliminar']);

    $sqlEliminar = "
    UPDATE compras
    SET deleted = 1
    WHERE id_compra = $id_compra
    ";

    mysqli_query($cnn, $sqlEliminar);

    echo "
    <script>
        window.location='index.php?seccion=compras&accion=listar';
    </script>";
    exit;
}

/* Consulta */

$sql = "
SELECT
    c.id_compra,
    u.usuario,
    p.proveedor,
    td.descripcion AS tipo_documento,
    c.numero_documento,
    c.monto_total,
    c.fecha_registro
FROM compras c

INNER JOIN usuarios u
    ON c.id_usuario = u.id_usuario

INNER JOIN proveedores p
    ON c.id_proveedor = p.id_proveedor

INNER JOIN tipos_documentos td
    ON c.id_tipo_documento = td.id_tipo_documento

WHERE c.deleted = 0
";

$resultado = mysqli_query($cnn, $sql);

?>

<div class="container mt-4">

    <h2>Compras</h2>

    <a
        href="index.php?seccion=compras&accion=modificar"
        class="btn btn-success mb-3">
        Nueva Compra
    </a>

    <table class="table table-striped">

        <thead>

            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Proveedor</th>
                <th>Tipo Documento</th>
                <th>N° Documento</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>

        </thead>

        <tbody>

        <?php while($fila = mysqli_fetch_assoc($resultado)){ ?>

            <tr>

                <td><?= $fila['id_compra'] ?></td>
                <td><?= htmlspecialchars($fila['usuario']) ?></td>
                <td><?= htmlspecialchars($fila['proveedor']) ?></td>
                <td><?= htmlspecialchars($fila['tipo_documento']) ?></td>
                <td><?= htmlspecialchars($fila['numero_documento']) ?></td>
                <td>$ <?= number_format($fila['monto_total'],2) ?></td>
                <td><?= $fila['fecha_registro'] ?></td>

                <td>

                    <a
                    href="index.php?seccion=compras&accion=modificar&id=<?= $fila['id_compra'] ?>"
                    class="btn btn-warning btn-sm">
                    Modificar
                    </a>

                    <a
                    href="index.php?seccion=compras&accion=listar&eliminar=<?= $fila['id_compra'] ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('¿Eliminar compra?')">
                    Eliminar
                    </a>

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>
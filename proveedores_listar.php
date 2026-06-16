<?php

include "conexion.php";

$cnn = conection();

/* Eliminación lógica */

if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {

    $id_proveedor = intval($_GET['eliminar']);

    $sql_eliminar = "
    UPDATE proveedores
    SET deleted = 1
    WHERE id_proveedor = $id_proveedor
    ";

    if (mysqli_query($cnn, $sql_eliminar)) {

        echo "
        <script>
            window.location='index.php?seccion=proveedores&accion=listar';
        </script>";
        exit;
    }
}

/* Consulta */

$sql = "
SELECT
    id_proveedor,
    proveedor,
    documento,
    telefono,
    correo,
    proveedor_activo
FROM proveedores
WHERE deleted = 0
";

$resultado = mysqli_query($cnn, $sql);

?>

<div class="container mt-4">

    <h2>Proveedores</h2>

    <a
        href="index.php?seccion=proveedores&accion=modificar"
        class="btn btn-success mb-3">
        Nuevo Proveedor
    </a>

    <table class="table table-striped">

        <thead>

            <tr>
                <th>ID</th>
                <th>Proveedor</th>
                <th>Documento</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>

        </thead>

        <tbody>

        <?php while($fila = mysqli_fetch_assoc($resultado)){ ?>

            <tr>

                <td><?= $fila['id_proveedor'] ?></td>

                <td><?= htmlspecialchars($fila['proveedor']) ?></td>

                <td><?= htmlspecialchars($fila['documento']) ?></td>

                <td><?= htmlspecialchars($fila['telefono']) ?></td>

                <td><?= htmlspecialchars($fila['correo']) ?></td>

                <td>
                    <?= ($fila['proveedor_activo']) ? 'Sí' : 'No' ?>
                </td>

                <td>

                    <a
                        href="index.php?seccion=proveedores&accion=modificar&id=<?= $fila['id_proveedor'] ?>"
                        class="btn btn-warning btn-sm">
                        Modificar
                    </a>

                    <a
                        href="index.php?seccion=proveedores&accion=listar&eliminar=<?= $fila['id_proveedor'] ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Desea eliminar este proveedor?')">
                        Eliminar
                    </a>

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>
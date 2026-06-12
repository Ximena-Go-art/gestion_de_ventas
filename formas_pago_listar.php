<?php

include "conexion.php";

$cnn = conection();

/* Obtener formas de pago activas */

$sql = "
SELECT
    id_formas_pago,
    descripcion
FROM formas_pago
WHERE deleted = 0
";

/* Eliminación lógica */

if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {

    $id_formas_pago = intval($_GET['eliminar']);

    $sql_eliminar = "
    UPDATE formas_pago
    SET deleted = 1
    WHERE id_formas_pago = $id_formas_pago
    ";

    if (mysqli_query($cnn, $sql_eliminar)) {

        echo "<script>window.location='index.php?seccion=formas_pago&accion=listar ';</script>";
        exit;

    } else {

        echo "
        <div class='alert alert-danger'>
            Error al eliminar: " . mysqli_error($cnn) . "
        </div>";
    }
}

$resultado = mysqli_query($cnn, $sql);

?>

<div class="container mt-4">

    <h2>Formas de Pago</h2>

    <a
        href="index.php?seccion=formas_pago&accion=modificar"
        class="btn btn-success mb-3">
        Nueva Forma de Pago
    </a>

    <table class="table table-striped">

        <thead>

            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>

        </thead>

        <tbody>

            <?php while($fila = mysqli_fetch_assoc($resultado)){ ?>

            <tr>

                <td><?= $fila['id_formas_pago'] ?></td>

                <td><?= htmlspecialchars($fila['descripcion']) ?></td>

                <td>

                    <a
                        href="index.php?seccion=formas_pago&accion=modificar&id=<?= $fila['id_formas_pago'] ?>"
                        class="btn btn-warning btn-sm">
                        Modificar
                    </a>

                    <a
                        href="index.php?seccion=formas_pago&accion=listar&eliminar=<?= $fila['id_formas_pago'] ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Desea eliminar esta forma de pago?')">
                        Eliminar
                    </a>

                </td>

            </tr>

            <?php } ?>

        </tbody>

    </table>

</div>
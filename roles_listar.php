<?php

include "conexion.php";

$cnn = conection();

/* Consulta */

$sql = "
SELECT
    id_rol,
    nombre
FROM roles
WHERE deleted = 0
";

/* Eliminación lógica */

if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {

    $id_rol = intval($_GET['eliminar']);

    $sql_eliminar = "
    UPDATE roles
    SET deleted = 1
    WHERE id_rol = $id_rol
    ";

    if (mysqli_query($cnn, $sql_eliminar)) {

        echo "<script>window.location='index.php?seccion=roles&accion=listar ';</script>";
        exit;

    } else {

        echo "<div class='alert alert-danger'>
                Error al eliminar: " . mysqli_error($cnn) . "
              </div>";
    }
}

$resultado = mysqli_query($cnn, $sql);

?>

<div class="container mt-4">

    <h2>Roles</h2>

    <a
        href="index.php?seccion=roles&accion=modificar"
        class="btn btn-success mb-3">
        Nuevo Rol
    </a>

    <table class="table table-striped">

        <thead>

            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>

        </thead>

        <tbody>

            <?php while($fila = mysqli_fetch_assoc($resultado)){ ?>

            <tr>

                <td><?= $fila['id_rol'] ?></td>

                <td><?= htmlspecialchars($fila['nombre']) ?></td>

                <td>

                    <a
                        href="index.php?seccion=roles&accion=modificar&id=<?= $fila['id_rol'] ?>"
                        class="btn btn-warning btn-sm">
                        Modificar
                    </a>

                    <a
                        href="index.php?seccion=roles&accion=listar&eliminar=<?= $fila['id_rol'] ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Desea eliminar este rol?')">
                        Eliminar
                    </a>

                </td>

            </tr>

            <?php } ?>

        </tbody>

    </table>

</div>
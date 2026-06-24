<?php
include "conexion.php";
$cnn = conection();

$sql = "SELECT
            u.*,
            r.nombre AS rol
        FROM usuarios u
        LEFT JOIN roles r
            ON u.id_rol = r.id_rol
        WHERE u.deleted = 0";

$result = mysqli_query($cnn, $sql);

if (isset($_GET['ideliminar'])) {

    $idEliminar = $_GET['ideliminar'];

    $sql = "UPDATE usuarios
            SET deleted = 1
            WHERE id_usuario = $idEliminar";

    $resp = mysqli_query($cnn, $sql);

    if (!$resp) {
        die("Error: " . mysqli_error($cnn));
    } else {
        echo "<script>
            alert('Usuario eliminado correctamente.');
            window.location.href='index.php?seccion=usuarios&accion=listar';
        </script>";
    }
}
?>

<div class="container pt-4">

    <div class="row">

        <div class="col-6">
            <h1>Usuarios</h1>
        </div>

        <div class="col-6 text-end">
            <a href="index.php?seccion=usuarios&accion=modificar"
               class="btn btn-primary">
                Nuevo Usuario
            </a>
        </div>

    </div>

    <table class="table table-striped mt-3">

        <thead>

            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>

        </thead>

        <tbody>

            <?php while($fila = mysqli_fetch_assoc($result)){ ?>

                <tr>

                    <td><?php echo $fila['id_usuario']; ?></td>

                    <td><?php echo $fila['usuario']; ?></td>

                    <td><?php echo $fila['email']; ?></td>

                    <td><?php echo $fila['rol']; ?></td>

                    <td>
                        <?php
                        echo ($fila['actividad_usuario'] == 1)
                            ? 'Sí'
                            : 'No';
                        ?>
                    </td>

                    <td>

                        <a href="index.php?seccion=usuarios&accion=modificar&id=<?php echo $fila['id_usuario']; ?>"
                           class="btn btn-warning btn-sm">
                            Modificar
                        </a>

                        <a href='index.php?seccion=usuarios&accion=listar&ideliminar=<?php echo $fila['id_usuario']; ?>'
                            class='btn btn-sm btn-danger'
                            onclick="return confirm('¿Eliminar usuario?');">
                             Eliminar
                        </a>

                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>

</div>
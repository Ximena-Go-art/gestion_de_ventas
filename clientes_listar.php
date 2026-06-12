<?php
include "conexion.php";
$cnn = conection();

/* Eliminación lógica */

if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {

    $id_cliente = intval($_GET['eliminar']);

    $sql_eliminar = "
    UPDATE clientes
    SET deleted = 1
    WHERE id_cliente = $id_cliente
    ";

    if (mysqli_query($cnn, $sql_eliminar)) {

        echo "
            <script>
                window.location='index.php?seccion=clientes&accion=listar';
         </script>";
    } else {

        echo "<div class='alert alert-danger'>
                Error al eliminar: " . mysqli_error($cnn) . "
              </div>";
    }
}

/* Consulta */

$sql = "
SELECT
    id_cliente,
    cliente,
    documento
FROM clientes
WHERE deleted = 0
";

$resultado = mysqli_query($cnn, $sql);

?>

<div class="container mt-4">

    <h2>Clientes</h2>

    <a
        href="index.php?seccion=clientes&accion=modificar"
        class="btn btn-success mb-3">
        Nuevo Cliente
    </a>

    <table class="table table-striped">

        <thead>

            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Documento</th>
                <th>Acciones</th>
            </tr>

        </thead>

        <tbody>

            <?php while($fila = mysqli_fetch_assoc($resultado)){ ?>

            <tr>

                <td><?= $fila['id_cliente'] ?></td>

                <td><?= htmlspecialchars($fila['cliente']) ?></td>

                <td><?= htmlspecialchars($fila['documento']) ?></td>

                <td>

                    <a
                        href="index.php?seccion=clientes&accion=modificar&id=<?= $fila['id_cliente'] ?>"
                        class="btn btn-warning btn-sm">
                        Modificar
                    </a>

                    <a
                        href="index.php?seccion=clientes&accion=listar&eliminar=<?= $fila['id_cliente'] ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Desea eliminar este cliente?')">
                        Eliminar
                    </a>

                </td>

            </tr>

            <?php } ?>

        </tbody>

    </table>

</div>
<?php
include "conexion.php";
$cnn = conection();

/* ============================
   LISTADO DE REGISTROS
============================ */

$sql = "SELECT
            r.*,
            u.usuario
        FROM registros r
        LEFT JOIN usuarios u
            ON r.id_usuario = u.id_usuario
        WHERE r.deleted = 0
        ORDER BY r.fecha_hora DESC";

$result = mysqli_query($cnn, $sql);

/* ============================
   ELIMINAR (BAJA LÓGICA)
============================ */

if (isset($_GET['ideliminar'])) {

    $idEliminar = intval($_GET['ideliminar']);

    $sql = "UPDATE registros
            SET deleted = 1
            WHERE id_registros = $idEliminar";

    $resp = mysqli_query($cnn, $sql);

    if (!$resp) {

        die("Error: " . mysqli_error($cnn));

    } else {

        echo "<script>

            alert('Registro eliminado correctamente.');

            window.location.href='index.php?seccion=registros&accion=listar';

        </script>";

    }

}
?>

<div class="container pt-4">

    <div class="row">

        <div class="col-6">

            <h1>Registros del Sistema</h1>

        </div>

    </div>

    <table class="table table-striped table-hover mt-3">

        <thead class="table-dark">

            <tr>

                <th>ID</th>

                <th>Fecha y Hora</th>

                <th>Usuario</th>

                <th>Sección</th>

                <th>Acción</th>

                <th>Link</th>

                <th>Sistema Operativo</th>

                <th width="100">Acciones</th>

            </tr>

        </thead>

        <tbody>

        <?php

        if(mysqli_num_rows($result)>0){

            while($fila=mysqli_fetch_assoc($result)){

        ?>

            <tr>

                <td>

                    <?php echo $fila['id_registros']; ?>

                </td>

                <td>

                    <?php echo date("d/m/Y H:i:s", strtotime($fila['fecha_hora'])); ?>

                </td>

                <td>

                    <?php echo $fila['usuario']; ?>

                </td>

                <td>

                    <?php echo $fila['seccion']; ?>

                </td>

                <td>

                    <?php echo $fila['accion']; ?>

                </td>

                <td>

                    <small>

                        <?php echo $fila['link']; ?>

                    </small>

                </td>

                <td>

                    <?php echo $fila['S.O']; ?>

                </td>

                <td>

                    <a
                        href="index.php?seccion=registros&accion=listar&ideliminar=<?php echo $fila['id_registros']; ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Eliminar este registro?');">

                        Eliminar

                    </a>

                </td>

            </tr>

        <?php

            }

        }else{

        ?>

            <tr>

                <td colspan="8" class="text-center">

                    No existen registros.

                </td>

            </tr>

        <?php

        }

        ?>

        </tbody>

    </table>

</div>
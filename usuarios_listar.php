<?php
include "conexion.php";
$cnn = conection();

/* ============================
   LISTADO DE USUARIOS
============================ */

$sql = "SELECT
            u.*,
            r.nombre AS rol
        FROM usuarios u
        LEFT JOIN roles r
            ON u.id_rol = r.id_rol
        WHERE u.deleted = 0
        ORDER BY u.usuario ASC";

$result = mysqli_query($cnn, $sql);

/* ============================
   ELIMINAR (BAJA LÓGICA)
============================ */

if (isset($_GET['ideliminar'])) {

    $idEliminar = intval($_GET['ideliminar']);

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

            <a
                href="index.php?seccion=usuarios&accion=modificar"
                class="btn btn-primary">

                Nuevo Usuario

            </a>

        </div>

    </div>

    <table class="table table-striped table-hover mt-3">

        <thead class="table-dark">

            <tr>

                <th>ID</th>

                <th>Usuario</th>

                <th>Email</th>

                <th>Rol</th>

                <th>Fecha Registro</th>

                <th>Activo</th>

                <th width="180">Acciones</th>

            </tr>

        </thead>

        <tbody>

        <?php

        if(mysqli_num_rows($result)>0){

            while($fila=mysqli_fetch_assoc($result)){

        ?>

            <tr>

                <td>

                    <?php echo $fila['id_usuario']; ?>

                </td>

                <td>

                    <?php echo $fila['usuario']; ?>

                </td>

                <td>

                    <?php echo $fila['email']; ?>

                </td>

                <td>

                    <?php
                    echo ($fila['rol']!="")
                        ? $fila['rol']
                        : "Sin rol";
                    ?>

                </td>

                <td>

                    <?php
                    echo date(
                        "d/m/Y H:i",
                        strtotime($fila['fecha_registro'])
                    );
                    ?>

                </td>

                <td>

                    <?php

                    if($fila['actividad_usuario']==1){

                        echo "<span class='badge bg-success'>
                                Sí
                              </span>";

                    }else{

                        echo "<span class='badge bg-danger'>
                                No
                              </span>";

                    }

                    ?>

                </td>

                <td>

                    <a
                        href="index.php?seccion=usuarios&accion=modificar&id=<?php echo $fila['id_usuario']; ?>"
                        class="btn btn-warning btn-sm">

                        Modificar

                    </a>

                    <a
                        href="index.php?seccion=usuarios&accion=listar&ideliminar=<?php echo $fila['id_usuario']; ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Está seguro que desea eliminar este usuario?');">

                        Eliminar

                    </a>

                </td>

            </tr>

        <?php

            }

        }else{

        ?>

            <tr>

                <td colspan="7" class="text-center">

                    No existen usuarios registrados.

                </td>

            </tr>

        <?php

        }

        ?>

        </tbody>

    </table>

</div>
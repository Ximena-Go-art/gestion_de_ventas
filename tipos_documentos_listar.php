<?php
include "conexion.php";
$cnn = conection();

/* Consulta */

$sql = "
SELECT
    id_tipo_documento,
    descripcion
FROM tipos_documentos
WHERE deleted = 0
";

/* Eliminación lógica */

if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {

    $id_tipo_documento = intval($_GET['eliminar']);

    $sql_eliminar = "
    UPDATE tipos_documentos
    SET deleted = 1
    WHERE id_tipo_documento = $id_tipo_documento
    ";

    if (mysqli_query($cnn, $sql_eliminar)) {

        echo "<script>window.location='index.php?seccion=tipos_documentos&accion=listar ';</script>";
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

    <h2>Tipos de Documentos</h2>

    <a
        href="index.php?seccion=tipos_documentos&accion=modificar"
        class="btn btn-success mb-3">
        Nuevo Tipo de Documento
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

                <td><?= $fila['id_tipo_documento'] ?></td>

                <td><?= htmlspecialchars($fila['descripcion']) ?></td>

                <td>

                    <a
                        href="index.php?seccion=tipos_documentos&accion=modificar&id=<?= $fila['id_tipo_documento'] ?>"
                        class="btn btn-warning btn-sm">
                        Modificar
                    </a>

                    <a
                        href="index.php?seccion=tipos_documentos&accion=listar&eliminar=<?= $fila['id_tipo_documento'] ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Desea eliminar este tipo de documento?')">
                        Eliminar
                    </a>

                </td>

            </tr>

            <?php } ?>

        </tbody>

    </table>

</div>
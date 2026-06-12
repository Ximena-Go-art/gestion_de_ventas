<?php
include "conexion.php";
$cnn = conection();

/* Variables iniciales */

$datos = [
    'id_tipo_documento' => '',
    'descripcion' => ''
];

/* Guardar */

if (isset($_POST['btnGuardar'])) {

    $id_tipo_documento = intval($_POST['id_tipo_documento']);

    $descripcion = mysqli_real_escape_string(
        $cnn,
        trim($_POST['descripcion'])
    );

    /* Nuevo */

    if ($id_tipo_documento == 0) {

        $sql = "
        INSERT INTO tipos_documentos
        (
            descripcion
        )
        VALUES
        (
            '$descripcion'
        )";

    } else {

        /* Modificar */

        $sql = "
        UPDATE tipos_documentos
        SET descripcion = '$descripcion'
        WHERE id_tipo_documento = $id_tipo_documento";
    }

    $resultado = mysqli_query($cnn, $sql);

    if ($resultado) {

        echo "
        <script>
             window.location='index.php?seccion=tipos_documentos&accion=listar';
        </script>";

    } else {

        echo "Error al guardar: " . mysqli_error($cnn);
    }
}

/* Cargar datos */

if (isset($_GET['id'])) {

    $id_tipo_documento = intval($_GET['id']);

    $sql = "
    SELECT *
    FROM tipos_documentos
    WHERE id_tipo_documento = $id_tipo_documento
    ";

    $resultado = mysqli_query($cnn, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {

        $datos = mysqli_fetch_assoc($resultado);

    } else {

        echo "
        <div class='alert alert-danger'>
            No se encontró el tipo de documento.
        </div>";
    }
}

?>

<div class="container pt-4">

    <div class="row">

        <div class="col-6">
            <h1>Tipos de Documentos</h1>
        </div>

        <div class="col-6 text-end">

            <a
                href="index.php?seccion=tipos_documentos&accion=listar"
                class="btn btn-secondary">
                Volver
            </a>

        </div>

        <div class="col-12">

            <form method="POST" class="mt-4">

                <input
                    type="hidden"
                    name="id_tipo_documento"
                    value="<?= $datos['id_tipo_documento'] ?>">

                <div class="mb-3">

                    <label
                        for="descripcion"
                        class="form-label">
                        Descripción
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="descripcion"
                        name="descripcion"
                        value="<?= htmlspecialchars($datos['descripcion']) ?>"
                        required>

                </div>

                <button
                    type="submit"
                    name="btnGuardar"
                    class="btn btn-primary">
                    Guardar
                </button>

            </form>

        </div>

    </div>

</div>
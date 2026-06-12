<?php

include "conexion.php";

$cnn = conection();

/* Variables iniciales */

$datos = [
    'id_rol' => '',
    'nombre' => ''
];

/* Guardar */

if (isset($_POST['btnGuardar'])) {

    $id_rol = intval($_POST['id_rol']);

    $nombre = mysqli_real_escape_string(
        $cnn,
        trim($_POST['nombre'])
    );

    /* Nuevo */

    if ($id_rol == 0) {

        $sql = "
        INSERT INTO roles
        (
            nombre
        )
        VALUES
        (
            '$nombre'
        )";

    } else {

        /* Modificar */

        $sql = "
        UPDATE roles
        SET nombre = '$nombre'
        WHERE id_rol = $id_rol";
    }

    $resultado = mysqli_query($cnn, $sql);

    if ($resultado) {

        echo "
        <script>
             window.location='index.php?seccion=roles&accion=listar';
        </script>";
        exit;

    } else {

        echo "Error al guardar: " . mysqli_error($cnn);
    }
}

/* Cargar datos */

if (isset($_GET['id'])) {

    $id_rol = intval($_GET['id']);

    $sql = "
    SELECT *
    FROM roles
    WHERE id_rol = $id_rol
    ";

    $resultado = mysqli_query($cnn, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {

        $datos = mysqli_fetch_assoc($resultado);

    } else {

        echo "
        <div class='alert alert-danger'>
            No se encontró el rol.
        </div>";
    }
}

?>

<div class="container pt-4">

    <div class="row">

        <div class="col-6">
            <h1>Roles</h1>
        </div>

        <div class="col-6 text-end">

            <a
                href="index.php?seccion=roles&accion=listar"
                class="btn btn-secondary">
                Volver
            </a>

        </div>

        <div class="col-12">

            <form method="POST" class="mt-4">

                <input
                    type="hidden"
                    name="id_rol"
                    value="<?= $datos['id_rol'] ?>">

                <div class="mb-3">

                    <label
                        for="nombre"
                        class="form-label">
                        Nombre del Rol
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="nombre"
                        name="nombre"
                        value="<?= htmlspecialchars($datos['nombre']) ?>"
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
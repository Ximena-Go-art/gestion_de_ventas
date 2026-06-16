<?php

include "conexion.php";

$cnn = conection();

/* Variables iniciales */

$datos = [
    'id_proveedor' => '',
    'proveedor' => '',
    'documento' => '',
    'telefono' => '',
    'correo' => '',
    'proveedor_activo' => 1
];

/* Guardar */

if (isset($_POST['btnGuardar'])) {

    $id_proveedor = intval($_POST['id_proveedor']);

    $proveedor = mysqli_real_escape_string(
        $cnn,
        trim($_POST['proveedor'])
    );

    $documento = mysqli_real_escape_string(
        $cnn,
        trim($_POST['documento'])
    );

    $telefono = mysqli_real_escape_string(
        $cnn,
        trim($_POST['telefono'])
    );

    $correo = mysqli_real_escape_string(
        $cnn,
        trim($_POST['correo'])
    );

    $proveedor_activo =
        isset($_POST['proveedor_activo']) ? 1 : 0;

    /* Nuevo */

    if ($id_proveedor == 0) {

        $sql = "
        INSERT INTO proveedores
        (
            proveedor,
            documento,
            telefono,
            correo,
            proveedor_activo
        )
        VALUES
        (
            '$proveedor',
            '$documento',
            '$telefono',
            '$correo',
            $proveedor_activo
        )";

    } else {

        /* Modificar */

        $sql = "
        UPDATE proveedores
        SET
            proveedor = '$proveedor',
            documento = '$documento',
            telefono = '$telefono',
            correo = '$correo',
            proveedor_activo = $proveedor_activo
        WHERE id_proveedor = $id_proveedor";
    }

    $resultado = mysqli_query($cnn, $sql);

    if ($resultado) {

        echo "
        <script>
            window.location='index.php?seccion=proveedores&accion=listar';
        </script>";

        exit;

    } else {

        echo "Error al guardar: " . mysqli_error($cnn);
    }
}

/* Cargar datos */

if (isset($_GET['id'])) {

    $id_proveedor = intval($_GET['id']);

    $sql = "
    SELECT *
    FROM proveedores
    WHERE id_proveedor = $id_proveedor
    ";

    $resultado = mysqli_query($cnn, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {

        $datos = mysqli_fetch_assoc($resultado);
    }
}

?>

<div class="container pt-4">

    <div class="row">

        <div class="col-6">
            <h1>Proveedores</h1>
        </div>

        <div class="col-6 text-end">

            <a
                href="index.php?seccion=proveedores&accion=listar"
                class="btn btn-secondary">
                Volver
            </a>

        </div>

        <div class="col-12">

            <form method="POST" class="mt-4">

                <input
                    type="hidden"
                    name="id_proveedor"
                    value="<?= $datos['id_proveedor'] ?>">

                <div class="mb-3">

                    <label class="form-label">
                        Proveedor
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="proveedor"
                        value="<?= htmlspecialchars($datos['proveedor']) ?>"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Documento
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="documento"
                        value="<?= htmlspecialchars($datos['documento']) ?>">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Teléfono
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="telefono"
                        value="<?= htmlspecialchars($datos['telefono']) ?>">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Correo
                    </label>

                    <input
                        type="email"
                        class="form-control"
                        name="correo"
                        value="<?= htmlspecialchars($datos['correo']) ?>">

                </div>

                <div class="form-check mb-3">

                    <input
                        type="checkbox"
                        class="form-check-input"
                        name="proveedor_activo"
                        <?= ($datos['proveedor_activo']) ? 'checked' : '' ?>>

                    <label class="form-check-label">
                        Proveedor Activo
                    </label>

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
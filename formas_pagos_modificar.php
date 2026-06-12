<?php

// ========================================
// CONEXIÓN A LA BASE DE DATOS
// ========================================
include "conexion.php";
$cnn = conection();


// ========================================
// INICIALIZACIÓN DE VARIABLES
// ========================================
$datos = [
    'id_formas_pago' => '',
    'descripcion' => ''
];


// ========================================
// PROCESO DE GUARDADO
// ========================================
if (isset($_POST['btnGuardar'])) {

    $id_formas_pago = intval($_POST['id_formas_pago']);
    $descripcion = mysqli_real_escape_string(
        $cnn,
        trim($_POST['descripcion'])
    );

    // ========================================
    // NUEVO REGISTRO
    // ========================================
    if ($id_formas_pago == 0) {

        $sql = "
        INSERT INTO formas_pago
        (
            descripcion
        )
        VALUES
        (
            '$descripcion'
        )";

    } else {

        // ========================================
        // MODIFICACIÓN
        // ========================================
        $sql = "
        UPDATE formas_pago
        SET
            descripcion = '$descripcion'
        WHERE id_formas_pago = $id_formas_pago";
    }

    $resultado = mysqli_query($cnn, $sql);

    if ($resultado) {

        echo "
        <script>
             window.location='index.php?seccion=formas_pago&accion=listar';
        </script>";
        exit;

    } else {

        echo "Error al guardar: " . mysqli_error($cnn);
    }
}


// ========================================
// CARGA DE DATOS PARA MODIFICACIÓN
// ========================================
if (isset($_GET['id'])) {

    $id_formas_pago = intval($_GET['id']);

    $sql = "
        SELECT *
        FROM formas_pago
        WHERE id_formas_pago = $id_formas_pago
    ";

    $resultado = mysqli_query($cnn, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {

        $datos = mysqli_fetch_assoc($resultado);

    } else {

        echo "
        <div class='alert alert-danger'>
            No se encontró la forma de pago.
        </div>";
    }
}

?>

<!-- =======================================
     VISTA: FORMULARIO DE ALTA Y MODIFICACIÓN
======================================== -->

<div class="container pt-4">

    <div class="row">

        <div class="col-6">
            <h1>Formas de Pago - Modificar</h1>
        </div>

        <div class="col-6 text-end">
            <a href="index.php?seccion=formas_pago&accion=listar"
               class="btn btn-secondary">
                Volver
            </a>
        </div>

        <div class="col-12">

            <form method="POST" class="mt-4">

                <input
                    type="hidden"
                    name="id_formas_pago"
                    value="<?= $datos['id_formas_pago'] ?>">

                <div class="mb-3">

                    <label for="descripcion" class="form-label">
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
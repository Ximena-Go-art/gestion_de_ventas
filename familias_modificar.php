<?php

// ========================================
// CONEXIÓN A LA BASE DE DATOS
// ========================================
include "conexion.php";
$cnn = conection();


// ========================================
// INICIALIZACIÓN DE VARIABLES
// Se utilizan para cargar valores vacíos
// cuando se crea una nueva familia.
// ========================================
$datos = [
    'id_familia' => '',
    'familia' => '',
    'descripcion' => ''
];


// ========================================
// PROCESO DE GUARDADO
// Se ejecuta al enviar el formulario.
// Permite crear o modificar una familia.
// ========================================
if (isset($_POST['btnGuardar'])) {

    // Obtiene y limpia los datos recibidos
    $id_familia = intval($_POST['id_familia']);
    $familia = mysqli_real_escape_string($cnn, trim($_POST['familia']));
    $descripcion = mysqli_real_escape_string($cnn, trim($_POST['descripcion']));

    // ========================================
    // NUEVO REGISTRO
    // Si el ID es 0 o vacío se realiza un INSERT
    // ========================================
    if ($id_familia == 0) {

        $sql = "
        INSERT INTO familias
        (
            familia,
            descripcion
        )
        VALUES
        (
            '$familia',
            '$descripcion'
        )";

    } else {

        // ========================================
        // ACTUALIZACIÓN DE REGISTRO
        // Si existe un ID se actualiza la familia
        // ========================================
        $sql = "
        UPDATE familias
        SET
            familia = '$familia',
            descripcion = '$descripcion'
        WHERE id_familia = $id_familia";
    }

    // Ejecuta la consulta correspondiente
    $resultado = mysqli_query($cnn, $sql);

    // Verifica si la operación fue exitosa
    if ($resultado) {

        // Regresa al listado de familias
        header("Location:index.php?seccion=familias&accion=listar");
        exit;

    } else {

        echo "Error al guardar: " . mysqli_error($cnn);
    }
}


// ========================================
// CARGA DE DATOS PARA MODIFICACIÓN
// Si se recibe un ID por GET se buscan
// los datos de la familia seleccionada.
// ========================================
if (isset($_GET['id'])) {

    $id_familia = intval($_GET['id']);

    $sql = "
        SELECT *
        FROM familias
        WHERE id_familia = $id_familia
    ";

    $resultado = mysqli_query($cnn, $sql);

    // Verifica que la familia exista
    if ($resultado && mysqli_num_rows($resultado) > 0) {

        // Carga los datos en el array para
        // completar automáticamente el formulario
        $datos = mysqli_fetch_assoc($resultado);

    } else {

        echo "
        <div class='alert alert-danger'>
            No se encontró la familia.
        </div>";
    }
}

?>

<!-- =======================================
     VISTA: FORMULARIO DE ALTA Y MODIFICACIÓN
======================================== -->

<div class="container pt-4">

    <div class="row">

        <!-- Título de la pantalla -->
        <div class="col-6">
            <h1>Familias - Modificar</h1>
        </div>

        <!-- Botón de regreso al listado -->
        <div class="col-6 text-end">
            <a href="index.php?seccion=familias&accion=listar"
               class="btn btn-secondary">
                Volver
            </a>
        </div>

        <div class="col-12">

            <!-- Formulario principal -->
            <form method="POST" class="mt-4">

                <!-- ID oculto para identificar
                     si se trata de un alta o modificación -->
                <input
                    type="hidden"
                    name="id_familia"
                    value="<?= $datos['id_familia'] ?>">

                <!-- Campo Familia -->
                <div class="mb-3">

                    <label for="familia" class="form-label">
                        Familia
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="familia"
                        name="familia"
                        value="<?= htmlspecialchars($datos['familia']) ?>"
                        required>

                </div>

                <!-- Campo Descripción -->
                <div class="mb-3">

                    <label for="descripcion" class="form-label">
                        Descripción
                    </label>

                    <textarea
                        class="form-control"
                        id="descripcion"
                        name="descripcion"
                        rows="3"><?= htmlspecialchars($datos['descripcion']) ?></textarea>

                </div>

                <!-- Botón para guardar -->
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
<?php
include "conexion.php";
$cnn = conection();

/* Variables iniciales */

$datos = [
    'id_cliente' => '',
    'cliente' => '',
    'documento' => ''
];


/* Guardar */

if (isset($_POST['btnGuardar'])) {

    $id_cliente = intval($_POST['id_cliente']);

    $cliente = mysqli_real_escape_string(
        $cnn,
        trim($_POST['cliente'])
    );

    $documento = mysqli_real_escape_string(
        $cnn,
        trim($_POST['documento'])
    );


    /* Nuevo */

    if ($id_cliente == 0) {

        $sql = "
        INSERT INTO clientes
        (
            cliente,
            documento
        )
        VALUES
        (
            '$cliente',
            '$documento'
        )";


    } else {

        /* Modificar */

        $sql = "
        UPDATE clientes
        SET
            cliente = '$cliente',
            documento = '$documento'
        WHERE id_cliente = $id_cliente";

    }


    $resultado = mysqli_query($cnn, $sql);


    if ($resultado) {

        echo "
        <script>

        Swal.fire({
            title: '¡Guardado correctamente!',
            text: 'El cliente fue registrado con éxito.',
            icon: 'success',
            confirmButtonText: 'Aceptar'
        }).then((result)=>{

            if(result.isConfirmed){

                window.location='index.php?seccion=clientes&accion=listar';

            }

        });

        </script>";


    } else {


        echo "
        <script>

        Swal.fire({
            title: 'Error',
            text: 'No se pudo guardar el cliente.',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });

        </script>";


    }

}



/* Cargar datos */

if (isset($_GET['id'])) {

    $id_cliente = intval($_GET['id']);

    $sql = "
    SELECT *
    FROM clientes
    WHERE id_cliente = $id_cliente
    ";


    $resultado = mysqli_query($cnn, $sql);


    if ($resultado && mysqli_num_rows($resultado) > 0) {

        $datos = mysqli_fetch_assoc($resultado);


    } else {


        echo "
        <script>

        Swal.fire({
            title: 'Cliente no encontrado',
            text: 'No existe un cliente con ese ID.',
            icon: 'warning',
            confirmButtonText: 'Aceptar'
        });

        </script>";

    }

}
?>

<div class="container pt-4">

    <div class="row">

        <div class="col-6">
            <h1>Clientes</h1>
        </div>

        <div class="col-6 text-end">

            <a
                href="index.php?seccion=clientes&accion=listar"
                class="btn btn-secondary">
                Volver
            </a>

        </div>

        <div class="col-12">

            <form method="POST" class="mt-4">

                <input
                    type="hidden"
                    name="id_cliente"
                    value="<?= $datos['id_cliente'] ?>">

                <div class="mb-3">

                    <label
                        for="cliente"
                        class="form-label">
                        Cliente
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="cliente"
                        name="cliente"
                        value="<?= htmlspecialchars($datos['cliente']) ?>"
                        required>

                </div>

                <div class="mb-3">

                    <label
                        for="documento"
                        class="form-label">
                        Documento
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="documento"
                        name="documento"
                        value="<?= htmlspecialchars($datos['documento']) ?>"
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
<?php

include "conexion.php";

$cnn = conection();

/* Combos */

$compras = mysqli_query(
    $cnn,
    "SELECT id_compra, numero_documento
     FROM compras
     WHERE deleted = 0"
);

$productos = mysqli_query(
    $cnn,
    "SELECT id_producto, nombre
     FROM productos
     WHERE deleted = 0"
);

/* Datos */

$datos = [
    'id_compra_detalle' => '',
    'id_compra' => '',
    'id_producto' => '',
    'cantidad' => '',
    'precio_unitario' => '',
    'precio_total' => ''
];

/* Guardar */

if (isset($_POST['btnGuardar'])) {

    $id_compra_detalle = intval($_POST['id_compra_detalle']);

    $id_compra = intval($_POST['id_compra']);

    $id_producto = intval($_POST['id_producto']);

    $cantidad = intval($_POST['cantidad']);

    $precio_unitario = floatval($_POST['precio_unitario']);

    $precio_total = floatval($_POST['precio_total']);

    if ($id_compra_detalle == 0) {

        $sql = "
        INSERT INTO compra_detalles
        (
            id_compra,
            id_producto,
            cantidad,
            precio_unitario,
            precio_total
        )
        VALUES
        (
            $id_compra,
            $id_producto,
            $cantidad,
            $precio_unitario,
            $precio_total
        )";

    } else {

        $sql = "
        UPDATE compra_detalles
        SET
            id_compra = $id_compra,
            id_producto = $id_producto,
            cantidad = $cantidad,
            precio_unitario = $precio_unitario,
            precio_total = $precio_total
        WHERE id_compra_detalle = $id_compra_detalle";
    }

    $resultado = mysqli_query($cnn, $sql);

    if ($resultado) {

        echo "
        <script>
            window.location='index.php?seccion=compra_detalles&accion=listar';
        </script>";

        exit;
    }

    echo mysqli_error($cnn);
}

/* Cargar */

if (isset($_GET['id'])) {

    $id = intval($_GET['id']);

    $sql = "
        SELECT *
        FROM compra_detalles
        WHERE id_compra_detalle = $id
    ";

    $resultado = mysqli_query($cnn, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {

        $datos = mysqli_fetch_assoc($resultado);

    }

}

?>

<div class="container pt-4">

<h2>Detalle de Compra</h2>

<form method="POST">

<input
type="hidden"
name="id_compra_detalle"
value="<?= $datos['id_compra_detalle'] ?>">

<div class="mb-3">

<label>Compra</label>

<select
name="id_compra"
class="form-control"
required>

<?php while($c = mysqli_fetch_assoc($compras)){ ?>

<option
value="<?= $c['id_compra'] ?>"
<?= ($datos['id_compra']==$c['id_compra']) ? 'selected' : '' ?>>

<?= htmlspecialchars($c['numero_documento']) ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label>Producto</label>

<select
name="id_producto"
class="form-control"
required>

<?php while($p = mysqli_fetch_assoc($productos)){ ?>

<option
value="<?= $p['id_producto'] ?>"
<?= ($datos['id_producto']==$p['id_producto']) ? 'selected' : '' ?>>

<?= htmlspecialchars($p['nombre']) ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label>Cantidad</label>

<input
type="number"
name="cantidad"
class="form-control"
value="<?= $datos['cantidad'] ?>"
required>

</div>

<div class="mb-3">

<label>Precio Unitario</label>

<input
type="number"
step="0.01"
name="precio_unitario"
class="form-control"
value="<?= $datos['precio_unitario'] ?>"
required>

</div>

<div class="mb-3">

<label>Precio Total</label>

<input
type="number"
step="0.01"
name="precio_total"
class="form-control"
value="<?= $datos['precio_total'] ?>"
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
<?php

include "conexion.php";

$cnn = conection();

/* Combos */

$usuarios =
mysqli_query(
    $cnn,
    "SELECT id_usuario, usuario
     FROM usuarios
     WHERE deleted = 0"
);

$proveedores =
mysqli_query(
    $cnn,
    "SELECT id_proveedor, proveedor
     FROM proveedores
     WHERE deleted = 0"
);

$tipos =
mysqli_query(
    $cnn,
    "SELECT id_tipo_documento, descripcion
     FROM tipos_documentos
     WHERE deleted = 0"
);

/* Datos */

$datos = [
    'id_compra' => '',
    'id_usuario' => '',
    'id_proveedor' => '',
    'id_tipo_documento' => '',
    'numero_documento' => '',
    'monto_total' => '',
    'fecha_registro' => date('Y-m-d')
];

/* Guardar */

if (isset($_POST['btnGuardar'])) {

    $id_compra = intval($_POST['id_compra']);

    $id_usuario = intval($_POST['id_usuario']);
    $id_proveedor = intval($_POST['id_proveedor']);
    $id_tipo_documento = intval($_POST['id_tipo_documento']);

    $numero_documento =
    mysqli_real_escape_string(
        $cnn,
        trim($_POST['numero_documento'])
    );

    $monto_total =
    floatval($_POST['monto_total']);

    $fecha_registro =
    $_POST['fecha_registro'];

    if ($id_compra == 0) {

        $sql = "
        INSERT INTO compras
        (
            id_usuario,
            id_proveedor,
            id_tipo_documento,
            numero_documento,
            monto_total,
            fecha_registro
        )
        VALUES
        (
            $id_usuario,
            $id_proveedor,
            $id_tipo_documento,
            '$numero_documento',
            $monto_total,
            '$fecha_registro'
        )";

    } else {

        $sql = "
        UPDATE compras
        SET
            id_usuario = $id_usuario,
            id_proveedor = $id_proveedor,
            id_tipo_documento = $id_tipo_documento,
            numero_documento = '$numero_documento',
            monto_total = $monto_total,
            fecha_registro = '$fecha_registro'
        WHERE id_compra = $id_compra";
    }

    $resultado = mysqli_query($cnn, $sql);

    if ($resultado) {

        echo "
        <script>
        window.location='index.php?seccion=compras&accion=listar';
        </script>";
        exit;
    }

    echo mysqli_error($cnn);
}

/* Cargar */

if (isset($_GET['id'])) {

    $id_compra = intval($_GET['id']);

    $sql = "
    SELECT *
    FROM compras
    WHERE id_compra = $id_compra
    ";

    $resultado = mysqli_query($cnn, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {

        $datos = mysqli_fetch_assoc($resultado);
    }
}

?>

<div class="container pt-4">

<h2>Compras</h2>

<form method="POST">

<input
type="hidden"
name="id_compra"
value="<?= $datos['id_compra'] ?>">

<div class="mb-3">

<label>Usuario</label>

<select
name="id_usuario"
class="form-control">

<?php while($u = mysqli_fetch_assoc($usuarios)){ ?>

<option
value="<?= $u['id_usuario'] ?>"
<?= ($datos['id_usuario']==$u['id_usuario']) ? 'selected' : '' ?>>

<?= htmlspecialchars($u['usuario']) ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label>Proveedor</label>

<select
name="id_proveedor"
class="form-control">

<?php while($p = mysqli_fetch_assoc($proveedores)){ ?>

<option
value="<?= $p['id_proveedor'] ?>"
<?= ($datos['id_proveedor']==$p['id_proveedor']) ? 'selected' : '' ?>>

<?= htmlspecialchars($p['proveedor']) ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label>Tipo Documento</label>

<select
name="id_tipo_documento"
class="form-control">

<?php while($t = mysqli_fetch_assoc($tipos)){ ?>

<option
value="<?= $t['id_tipo_documento'] ?>"
<?= ($datos['id_tipo_documento']==$t['id_tipo_documento']) ? 'selected' : '' ?>>

<?= htmlspecialchars($t['descripcion']) ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label>Número Documento</label>

<input
type="text"
name="numero_documento"
class="form-control"
value="<?= htmlspecialchars($datos['numero_documento']) ?>">

</div>

<div class="mb-3">

<label>Monto Total</label>

<input
type="number"
step="0.01"
name="monto_total"
class="form-control"
value="<?= $datos['monto_total'] ?>">

</div>

<div class="mb-3">

<label>Fecha</label>

<input
type="date"
name="fecha_registro"
class="form-control"
value="<?= substr($datos['fecha_registro'],0,10) ?>">

</div>

<button
type="submit"
name="btnGuardar"
class="btn btn-primary">
Guardar
</button>

</form>

</div>
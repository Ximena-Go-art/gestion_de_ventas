<?php

include "conexion.php";

$cnn = conection();

/* Combos */

$usuarios = mysqli_query(
    $cnn,
    "SELECT id_usuario, usuario
     FROM usuarios
     WHERE deleted = 0"
);

$clientes = mysqli_query(
    $cnn,
    "SELECT id_cliente, cliente
     FROM clientes
     WHERE deleted = 0"
);

$tipos = mysqli_query(
    $cnn,
    "SELECT id_tipo_documento, descripcion
     FROM tipos_documentos
     WHERE deleted = 0"
);

$formas = mysqli_query(
    $cnn,
    "SELECT id_formas_pago, descripcion
     FROM formas_pago
     WHERE deleted = 0"
);

/* Datos iniciales */

$datos = [
    'id_ventas' => '',
    'id_usuario' => '',
    'id_cliente' => '',
    'tipo_documento' => '',
    'id_forma_de_pago' => '',
    'monto_total' => '',
    'monto_pago' => '',
    'monto_cambio' => '',
    'estado' => 'PENDIENTE',
    'fecha_registro' => date('Y-m-d')
];

/* Guardar */

if (isset($_POST['btnGuardar'])) {

    $id_ventas = intval($_POST['id_ventas']);

    $id_usuario = intval($_POST['id_usuario']);
    $id_cliente = intval($_POST['id_cliente']);
    $tipo_documento = intval($_POST['tipo_documento']);
    $id_forma_de_pago = intval($_POST['id_forma_de_pago']);

    $monto_total = floatval($_POST['monto_total']);
    $monto_pago = floatval($_POST['monto_pago']);

    $monto_cambio = $monto_pago - $monto_total;

    $estado = mysqli_real_escape_string(
        $cnn,
        trim($_POST['estado'])
    );

    $fecha_registro = $_POST['fecha_registro'];

    if ($id_ventas == 0) {

        $sql = "
        INSERT INTO ventas
        (
            id_usuario,
            id_cliente,
            tipo_documento,
            id_forma_de_pago,
            monto_total,
            monto_pago,
            monto_cambio,
            estado,
            fecha_registro
        )
        VALUES
        (
            $id_usuario,
            $id_cliente,
            $tipo_documento,
            $id_forma_de_pago,
            $monto_total,
            $monto_pago,
            $monto_cambio,
            '$estado',
            '$fecha_registro'
        )";

    } else {

        $sql = "
        UPDATE ventas
        SET
            id_usuario = $id_usuario,
            id_cliente = $id_cliente,
            tipo_documento = $tipo_documento,
            id_forma_de_pago = $id_forma_de_pago,
            monto_total = $monto_total,
            monto_pago = $monto_pago,
            monto_cambio = $monto_cambio,
            estado = '$estado',
            fecha_registro = '$fecha_registro'
        WHERE id_ventas = $id_ventas";
    }

    $resultado = mysqli_query($cnn, $sql);

    if ($resultado) {

        echo "
        <script>
        window.location='index.php?seccion=ventas&accion=listar';
        </script>";
        exit;
    }

    echo mysqli_error($cnn);
}

/* Cargar datos */

if (isset($_GET['id'])) {

    $id_ventas = intval($_GET['id']);

    $resultado = mysqli_query(
        $cnn,
        "SELECT *
         FROM ventas
         WHERE id_ventas = $id_ventas"
    );

    if ($resultado && mysqli_num_rows($resultado) > 0) {

        $datos = mysqli_fetch_assoc($resultado);
    }
}

?>

<div class="container pt-4">

<h2>Ventas</h2>

<form method="POST">

<input
type="hidden"
name="id_ventas"
value="<?= $datos['id_ventas'] ?>">

<div class="mb-3">

<label>Usuario</label>

<select name="id_usuario" class="form-control">

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

<label>Cliente</label>

<select name="id_cliente" class="form-control">

<?php while($c = mysqli_fetch_assoc($clientes)){ ?>

<option
value="<?= $c['id_cliente'] ?>"
<?= ($datos['id_cliente']==$c['id_cliente']) ? 'selected' : '' ?>>

<?= htmlspecialchars($c['cliente']) ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label>Tipo Documento</label>

<select name="tipo_documento" class="form-control">

<?php while($t = mysqli_fetch_assoc($tipos)){ ?>

<option
value="<?= $t['id_tipo_documento'] ?>"
<?= ($datos['tipo_documento']==$t['id_tipo_documento']) ? 'selected' : '' ?>>

<?= htmlspecialchars($t['descripcion']) ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label>Forma de Pago</label>

<select name="id_forma_de_pago" class="form-control">

<?php while($f = mysqli_fetch_assoc($formas)){ ?>

<option
value="<?= $f['id_formas_pago'] ?>"
<?= ($datos['id_forma_de_pago']==$f['id_formas_pago']) ? 'selected' : '' ?>>

<?= htmlspecialchars($f['descripcion']) ?>

</option>

<?php } ?>

</select>

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

<label>Monto Pago</label>

<input
type="number"
step="0.01"
name="monto_pago"
class="form-control"
value="<?= $datos['monto_pago'] ?>">

</div>

<div class="mb-3">

<label>Estado</label>

<input
type="text"
name="estado"
class="form-control"
value="<?= htmlspecialchars($datos['estado']) ?>">

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
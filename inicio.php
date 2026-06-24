<?php

include "conexion.php";

$cnn = conection();

function contarRegistros($cnn, $tabla, $usarDeleted = true) {
    $tabla = mysqli_real_escape_string($cnn, $tabla);

    $verificarTabla = mysqli_query($cnn, "SHOW TABLES LIKE '$tabla'");

    if (!$verificarTabla || mysqli_num_rows($verificarTabla) === 0) {
        return null;
    }

    $sql = "SELECT COUNT(*) AS total FROM $tabla";

    if ($usarDeleted) {
        $sql .= " WHERE deleted = 0";
    }

    $resultado = mysqli_query($cnn, $sql);

    if (!$resultado) {
        return null;
    }

    $fila = mysqli_fetch_assoc($resultado);

    return isset($fila['total']) ? (int) $fila['total'] : null;
}

//contadores para el dashboard
$totalClientes = contarRegistros($cnn, 'clientes');
$totalProductos = contarRegistros($cnn, 'productos');
$totalFamilias = contarRegistros($cnn, 'familias');
$totalUsuarios = contarRegistros($cnn, 'usuarios', false);

?>
<div class="row">

    <div class="col-md-3 mb-4">
        <div class="card border-primary h-100">
            <div class="card-body text-center">
                <h6>Clientes</h6>
                <h2><?= $totalClientes !== null ? $totalClientes : 'N/D' ?></h2>
                <i class="fas fa-users fa-2x text-primary"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card border-success h-100">
            <div class="card-body text-center">
                <h6>Productos</h6>
                <h2><?= $totalProductos !== null ? $totalProductos : 'N/D' ?></h2>
                <i class="fas fa-box fa-2x text-success"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card border-warning h-100">
            <div class="card-body text-center">
                <h6>Familias</h6>
                <h2><?= $totalFamilias !== null ? $totalFamilias : 'N/D' ?></h2>
                <i class="fas fa-tags fa-2x text-warning"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card border-info h-100">
            <div class="card-body text-center">
                <h6>Usuarios</h6>
                <h2><?= $totalUsuarios !== null ? $totalUsuarios : 'N/D' ?></h2>
                <i class="fas fa-user-shield fa-2x text-info"></i>
            </div>
        </div>
    </div>

</div>
<div class="row">

    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <h5>Clientes</h5>
                <p>Administración de clientes.</p>

                <a
                href="index.php?seccion=clientes&accion=listar"
                class="btn btn-primary">
                Ir a Clientes
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <h5>Productos</h5>
                <p>Administración de productos.</p>

                <a
                href="index.php?seccion=productos&accion=listar"
                class="btn btn-success">
                Ir a Productos
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <h5>Familias</h5>
                <p>Administración de familias.</p>

                <a
                href="index.php?seccion=familias&accion=listar"
                class="btn btn-warning">
                Ir a Familias
                </a>
            </div>
        </div>
    </div>
    

</div>
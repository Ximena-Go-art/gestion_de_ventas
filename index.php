<?php

$seccion = '';
$accion = '';

// Si mandaron algo por GET seccion, lo guardo
if (isset($_GET['seccion'])) {
    $seccion = $_GET['seccion'];
}

// Si mandaron algo por GET accion, lo guardo
if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];
}

$archivo = $seccion . "_" . $accion . ".php";

if (!file_exists($archivo)) {
    $archivo = "inicio.php"; // Archivo por defecto
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Ventas - Cosméticos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container-fluid">
        <div class="row">
            
            <div class="col-md-3 col-lg-2 bg-white border-end p-3 min-vh-100">
                
                <div class="text-center py-3 border-bottom mb-4">
                    <h5 class="fw-bold text-danger m-0">✨ Cosmética</h5>
                </div>

                <div class="list-group list-group-flush">
                    
                    <a href="index.php?seccion=inicio&accion=mostrar" 
                       class="list-group-item list-group-item-action border-0 rounded <?php echo ($seccion == 'inicio' || $seccion == '') ? 'bg-danger-subtle text-danger fw-bold' : ''; ?>">
                       🏠 Inicio
                    </a>

                    <div class="fw-bold text-secondary small text-uppercase mt-4 mb-2 px-3">👥 Personas</div>
                    <a href="index.php?seccion=clientes&accion=listar" 
                       class="list-group-item list-group-item-action border-0 rounded ps-4 <?php echo ($seccion == 'clientes') ? 'bg-danger-subtle text-danger fw-bold' : ''; ?>">
                       Clientes
                    </a>
                    <a href="index.php?seccion=proveedores&accion=listar" 
                       class="list-group-item list-group-item-action border-0 rounded ps-4 <?php echo ($seccion == 'proveedores') ? 'bg-danger-subtle text-danger fw-bold' : ''; ?>">
                       Proveedores
                    </a>
                    <a href="index.php?seccion=usuarios&accion=listar" 
                       class="list-group-item list-group-item-action border-0 rounded ps-4 <?php echo ($seccion == 'usuarios') ? 'bg-danger-subtle text-danger fw-bold' : ''; ?>">
                       Usuarios
                    </a>

                    <div class="fw-bold text-secondary small text-uppercase mt-4 mb-2 px-3">📦 Inventario</div>
                    <a href="index.php?seccion=productos&accion=listar" 
                       class="list-group-item list-group-item-action border-0 rounded ps-4 <?php echo ($seccion == 'productos') ? 'bg-danger-subtle text-danger fw-bold' : ''; ?>">
                       Productos
                    </a>
                    <a href="index.php?seccion=familias&accion=listar" 
                       class="list-group-item list-group-item-action border-0 rounded ps-4 <?php echo ($seccion == 'familias') ? 'bg-danger-subtle text-danger fw-bold' : ''; ?>">
                       Familias
                    </a>

                    <div class="fw-bold text-secondary small text-uppercase mt-4 mb-2 px-3">🛒 Ventas</div>
                    <a href="index.php?seccion=ventas&accion=listar" 
                       class="list-group-item list-group-item-action border-0 rounded ps-4 <?php echo ($seccion == 'ventas') ? 'bg-danger-subtle text-danger fw-bold' : ''; ?>">
                       Ventas
                    </a>
                    <a href="index.php?seccion=ventas_detalles&accion=listar" 
                       class="list-group-item list-group-item-action border-0 rounded ps-4 <?php echo ($seccion == 'ventas_detalles') ? 'bg-danger-subtle text-danger fw-bold' : ''; ?>">
                       Detalle de Ventas
                    </a>

                    <div class="fw-bold text-secondary small text-uppercase mt-4 mb-2 px-3">🚚 Compras</div>
                    <a href="index.php?seccion=compras&accion=listar" 
                       class="list-group-item list-group-item-action border-0 rounded ps-4 <?php echo ($seccion == 'compras') ? 'bg-danger-subtle text-danger fw-bold' : ''; ?>">
                       Compras
                    </a>
                    <a href="index.php?seccion=compra_detalles&accion=listar" 
                       class="list-group-item list-group-item-action border-0 rounded ps-4 <?php echo ($seccion == 'compra_detalles') ? 'bg-danger-subtle text-danger fw-bold' : ''; ?>">
                       Detalle de Compras
                    </a>

                    <div class="fw-bold text-secondary small text-uppercase mt-4 mb-2 px-3">💰 Caja</div>
                    <a href="index.php?seccion=cajas&accion=listar" 
                       class="list-group-item list-group-item-action border-0 rounded ps-4 <?php echo ($seccion == 'cajas') ? 'bg-danger-subtle text-danger fw-bold' : ''; ?>">
                       Caja
                    </a>
                    <a href="index.php?seccion=formas_pago&accion=listar" 
                       class="list-group-item list-group-item-action border-0 rounded ps-4 <?php echo ($seccion == 'formas_pago') ? 'bg-danger-subtle text-danger fw-bold' : ''; ?>">
                       Formas de Pago
                    </a>

                    <div class="fw-bold text-secondary small text-uppercase mt-4 mb-2 px-3">⚙️ Administración</div>
                    <a href="index.php?seccion=roles&accion=listar" 
                       class="list-group-item list-group-item-action border-0 rounded ps-4 <?php echo ($seccion == 'roles') ? 'bg-danger-subtle text-danger fw-bold' : ''; ?>">
                       Roles
                    </a>
                    <a href="index.php?seccion=tipos_documentos&accion=listar" 
                       class="list-group-item list-group-item-action border-0 rounded ps-4 <?php echo ($seccion == 'tipos_documentos') ? 'bg-danger-subtle text-danger fw-bold' : ''; ?>">
                       Tipos de Documentos
                    </a>
                    <a href="index.php?seccion=registros&accion=listar" 
                       class="list-group-item list-group-item-action border-0 rounded ps-4 <?php echo ($seccion == 'registros') ? 'bg-danger-subtle text-danger fw-bold' : ''; ?>">
                       Registros
                    </a>

                </div>
            </div>
            <div class="col-md-9 col-lg-10 p-4">
                
                <div class="d-flex justify-content-end mb-4">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Buscar..." aria-label="Search">
                        <button class="btn btn-outline-danger" type="submit">Buscar</button>
                    </form>
                </div>

                <?php include $archivo; ?>

            </div>
            </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
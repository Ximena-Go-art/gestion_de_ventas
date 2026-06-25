<?php
// Carga la conexión a base de datos y obtiene el enlace activo.
include "conexion.php";
$cnn = conection();

// Consulta principal:
// - Trae todos los campos del producto.
// - Hace LEFT JOIN con familias para mostrar el nombre de la familia.
// - Solo muestra registros no eliminados (deleted = 0).
// - Ordena alfabéticamente por nombre.
$sql = "SELECT
            p.*,
            f.familia AS familia
        FROM productos p
        LEFT JOIN familias f
            ON p.id_familia = f.id_familia
        WHERE p.deleted = 0     
        ORDER BY p.nombre";

$result = mysqli_query($cnn, $sql);

// Eliminación lógica:
// En lugar de borrar físicamente el registro, marca deleted = 1.
// Esto permite conservar histórico en la base de datos.
if (isset($_GET['ideliminar'])) {

    // Obtiene el id del producto enviado por URL.
    $idEliminar = $_GET['ideliminar'];

    $sql = "UPDATE productos
            SET deleted = 1
            WHERE id_producto = $idEliminar";

    $resp = mysqli_query($cnn, $sql);

    if (!$resp) {
        die("Error: " . mysqli_error($cnn));
    } else {
        // Si la actualización fue correcta, avisa y recarga el listado.
        echo "<script>
                alert('Producto eliminado correctamente.');
                window.location.href='index.php?seccion=productos&accion=listar';
              </script>";
        exit;
    }
}
?>

<div class="container pt-4">

    <div class="row">

        <div class="col-6">
            <h1>Productos</h1>
        </div>

        <div class="col-6 text-end">
            <a href="index.php?seccion=productos&accion=modificar"
               class="btn btn-primary">
                Nuevo Producto
            </a>
        </div>

    </div>

    <table class="table table-striped mt-3">

        <!-- Encabezado de columnas de la tabla -->
        <thead>
            <tr>
                <th>ID</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Familia</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

            <!-- Recorre cada producto devuelto por la consulta -->
            <?php while($fila = mysqli_fetch_assoc($result)){ ?>

                <tr>

                    <td><?php echo $fila['id_producto']; ?></td>

                    <td><?php echo $fila['codigo']; ?></td>

                    <td><?php echo $fila['nombre']; ?></td>

                    <td><?php echo $fila['familia']; ?></td>

                    <td>$<?php echo number_format($fila['precio'], 2, ',', '.'); ?></td>

                    <!-- Se muestra con 2 decimales para mantener formato numérico uniforme -->
                    <td><?php echo number_format($fila['stock'], 2, ',', '.'); ?></td>

                    <td>
                        <!-- Convierte el valor 1/0 en un texto legible para el usuario -->
                        <?php echo ($fila['producto_activo'] == 1) ? 'Sí' : 'No'; ?>
                    </td>

                    <td>

                        <!-- Envía al formulario de alta/modificación pasando el id -->
                        <a href="index.php?seccion=productos&accion=modificar&id=<?php echo $fila['id_producto']; ?>"
                           class="btn btn-warning btn-sm">
                            Modificar
                        </a>

                        <!-- Solicita confirmación y ejecuta la eliminación lógica -->
                        <a href="index.php?seccion=productos&accion=listar&ideliminar=<?php echo $fila['id_producto']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('¿Eliminar producto?');">
                            Eliminar
                        </a>

                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>

</div>
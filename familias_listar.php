<?php
// obtenemos el arreglo de familias desde el controlador
include "conexion.php";
$cnn = conection();

//--*--  consulta para obtener los datos de las familias que no han sido eliminados,
$sql = "
SELECT id_familia,
    familia,
    descripcion
FROM familias
WHERE deleted = 0
";

//--*-- ejecutamos la consulta y obtenemos el resultado
if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
    
    //--*-- obtenemos el id de la familia a eliminar
    $id_familia = intval($_GET['eliminar']);
    $sql_eliminar = "UPDATE familias SET deleted = 1 WHERE id_familia = $id_familia";

    //--*-- ejecutamos la consulta de eliminación
    if (mysqli_query($cnn, $sql_eliminar)) {
        header("Location: index.php?seccion=familias&accion=listar");
        exit; 
        //--*-- evitamos que se ejecute el resto del código después de la redirección
    } else {
        //--*-- mostramos un mensaje de error si la eliminación falla
        echo "<div class='alert alert-danger'>Error al eliminar: " . mysqli_error($cnn) . "</div>";
    }
}
//--*-- ejecutamos la consulta y obtenemos el resultado
$resultado = mysqli_query($cnn, $sql);
?>


<!-- vista de listado de familias en formato HTML -->
<div class="container mt-4">
    <!-- Título -->
    <h2>Familias</h2>
    <!-- Botón para agregar nueva familia -->
    <a
      href="index.php?seccion=familias&accion=modificar"
      class="btn btn-success mb-3">
      Nueva Familia
    </a>
    <!-- Tabla para mostrar las familias -->
    <table class="table table-striped">

        <thead>

            <tr>
                <th>ID</th>
                <th>Familia</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>

        </thead>
        <!--*-- verificamos si el resultado tiene filas para mostrar -->
        <tbody>

            <?php while($fila=mysqli_fetch_assoc($resultado)){ ?>

            <tr>
                <!--*-- mostramos los datos de cada familia en una fila de la tabla -->
                <td><?= $fila['id_familia'] ?></td>

                <td><?= $fila['familia'] ?></td>

                <td><?= $fila['descripcion'] ?></td>

                <td>
                    <!-- Botón de modificación -->  
                    <a 
                    href="index.php?seccion=familias&accion=modificar&id=<?= $fila['id_familia'] ?>"
                    class="btn btn-warning btn-sm">
                    Modificar
                    </a>
                    <!-- Botón de eliminación -->
                    <a
                     href="index.php?seccion=familias&accion=listar&eliminar=<?= $fila['id_familia'] ?>"
                        class="btn btn-sm btn-danger"
                         onclick="return confirm('¿Desea eliminar esta familia?')">
                             Eliminar
                    </a>

                </td>

            </tr>

            <?php } ?>

        </tbody>

    </table>

</div>
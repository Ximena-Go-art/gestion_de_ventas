<?php

include "conexion.php";

$cnn = conection();


// ==========================================
// GUARDAR PRODUCTO (ALTA O MODIFICACIÓN)
// ==========================================
if (isset($_POST['btnGuardar'])) {

    $id_producto = $_POST['id_producto'];
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $id_familia = $_POST['id_familia'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    if (empty($id_producto)) {

        $sql = "INSERT INTO productos
                (
                    codigo,
                    nombre,
                    descripcion,
                    id_familia,
                    precio,
                    stock,
                    producto_activo,
                    deleted
                )
                VALUES
                (
                    '$codigo',
                    '$nombre',
                    '$descripcion',
                    '$id_familia',
                    '$precio',
                    '$stock',
                    '" . (isset($_POST['producto_activo']) ? 1 : 0) . "',
                    0
                )";

        $resp = mysqli_query($cnn, $sql);

        if ($resp) {

            $nuevoId = mysqli_insert_id($cnn);

            echo "<script>
                window.location.href='index.php?seccion=productos&accion=modificar&id=$nuevoId';
            </script>";
        }

    } else {

        $sql = "UPDATE productos SET

                    codigo='$codigo',
                    nombre='$nombre',
                    descripcion='$descripcion',
                    id_familia='$id_familia',
                    precio='$precio',
                    stock='$stock',
                    producto_activo='" . (isset($_POST['producto_activo']) ? 1 : 0) . "'

                WHERE id_producto='$id_producto'";

        $resp = mysqli_query($cnn,$sql);

        if($resp){
            echo "<script>mostrarGuardado();</script>";
        }

    }

}


// ==========================================
// CARGAR PRODUCTO
// ==========================================

if(isset($_GET['id'])){

    $idProducto=$_GET['id'];

    $sql="SELECT *
          FROM productos
          WHERE id_producto='$idProducto'";

    $result=mysqli_query($cnn,$sql);

    $campos=mysqli_fetch_assoc($result);

}

?>

<div class="container pt-4">

    <div class="row">

        <div class="col-6">
            <h1>Productos</h1>
        </div>

        <div class="col-6 text-end">

            <a href="index.php?seccion=productos&accion=listar"
               class="btn btn-secondary">

                Volver a la lista

            </a>

        </div>

        <div class="col-12">

            <form method="POST" class="mt-4">

                <input type="hidden"
                       name="id_producto"
                       value="<?php echo isset($campos['id_producto']) ? $campos['id_producto'] : ''; ?>">

                <div class="mb-3">

                    <label class="form-label">
                        Código
                    </label>

                    <input
                        type="text"
                        name="codigo"
                        class="form-control"
                        value="<?php echo isset($campos['codigo']) ? $campos['codigo'] : ''; ?>"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Nombre
                    </label>

                    <input
                        type="text"
                        name="nombre"
                        class="form-control"
                        value="<?php echo isset($campos['nombre']) ? $campos['nombre'] : ''; ?>"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Descripción
                    </label>

                    <textarea
                        name="descripcion"
                        class="form-control"><?php echo isset($campos['descripcion']) ? $campos['descripcion'] : ''; ?></textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Familia
                    </label>

                    <select
                        name="id_familia"
                        class="form-control">

                        <option value="">
                            Seleccione una familia
                        </option>

                        <?php

                        $sqlFamilias="SELECT *
                                      FROM familias
                                      WHERE deleted=0
                                      ORDER BY familia";

                        $resultado=mysqli_query($cnn,$sqlFamilias);

                        while($familia=mysqli_fetch_assoc($resultado)){

                            $selected="";

                            if(isset($campos['id_familia']) &&
                               $campos['id_familia']==$familia['id_familia']){

                                $selected="selected";

                            }

                            echo "<option value='".$familia['id_familia']."' $selected>"
                                    .$familia['familia'].
                                "</option>";

                        }

                        ?>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Precio
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="precio"
                        class="form-control"
                        value="<?php echo isset($campos['precio']) ? $campos['precio'] : ''; ?>"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Stock
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="stock"
                        class="form-control"
                        value="<?php echo isset($campos['stock']) ? $campos['stock'] : ''; ?>">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Activo
                    </label>

                    <input
                        type="checkbox"
                        class="form-check-input"
                        name="producto_activo"
                        value="1"

                        <?php

                        echo (isset($campos['producto_activo']) &&
                              $campos['producto_activo']==1)
                              ? "checked"
                              : "";

                        ?>

                    >

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
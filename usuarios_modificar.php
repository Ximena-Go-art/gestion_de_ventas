<?php

// Se incluye el archivo de conexión a la base de datos
include "conexion.php";

// Se crea la conexión utilizando la función definida en conexion.php
$cnn = conection();


// =====================================================
// GUARDAR USUARIO (ALTA O MODIFICACIÓN)
// =====================================================
if (isset($_POST['btnGuardar'])) {

    // Obtención de los datos enviados desde el formulario
    $id_usuario = $_POST['id_usuario'];
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    // Si no existe id_usuario significa que es un ALTA
    if (empty($id_usuario)) {

        // Inserción de un nuevo usuario
        $sql = 'INSERT INTO usuarios
                (usuario, email, contraseña, id_rol, actividad_usuario, fecha_registro, deleted)
                VALUES (
                    "' . $usuario . '",
                    "' . $email . '",
                    "' . $contrasena . '",
                    "' . $_POST['id_rol'] . '",
                    "' . (isset($_POST['actividad_usuario']) ? 1 : 0) . '",
                    NOW(),
                    0
                )';

        // Ejecución de la consulta
        $resp = mysqli_query($cnn, $sql);

        // Si se guardó correctamente
        if ($resp) {

            // Obtiene el ID generado automáticamente
            $nuevoId = mysqli_insert_id($cnn);

            // Redirecciona al usuario recién creado
            echo "<script>
                window.location.href='index.php?seccion=usuarios&accion=&id=$nuevoId';
            </script>";
        }

    } else {

        // =====================================================
        // MODIFICACIÓN DE USUARIO EXISTENTE
        // =====================================================

        $sql = "UPDATE usuarios SET
                    usuario='$usuario',
                    email='$email',
                    contraseña='$contrasena',
                    id_rol='" . $_POST['id_rol'] . "',
                    actividad_usuario='" . (isset($_POST['actividad_usuario']) ? 1 : 0) . "'
                WHERE id_usuario='$id_usuario'";

        // Ejecución de la actualización
        $resp = mysqli_query($cnn, $sql);

        // Muestra mensaje de confirmación
        if ($resp) {
            echo "<script>mostrarGuardado();</script>";
        }
    }
}


// =====================================================
// CARGA DE DATOS DEL USUARIO A MODIFICAR
// =====================================================
if (isset($_GET['id'])) {

    // Obtiene el ID recibido por URL
    $idUsuario = $_GET['id'];

    // Busca el usuario seleccionado
    $sql = "SELECT * FROM usuarios
            WHERE id_usuario='$idUsuario'";

    $result = mysqli_query($cnn, $sql);

    // Guarda los datos en un array asociativo
    $campos = mysqli_fetch_assoc($result);
}
?>

<div class="container pt-4">
    <div class="row">

        <!-- Título principal -->
        <div class="col-6">
            <h1>Usuarios Modificar</h1>
        </div>

        <!-- Botón para volver al listado -->
        <div class="col-6 text-end">
            <a href="index.php?seccion=usuarios&accion=listar"
               class="btn btn-secondary">
                Volver a la lista
            </a>
        </div>

        <div class="col-12">

            <!-- Formulario principal -->
            <form method="POST" action="" class="mt-4">

                <!-- Campo oculto que almacena el ID del usuario -->
                <input type="hidden"
                       id="id_usuario"
                       name="id_usuario"
                       value="<?php echo isset($campos['id_usuario']) ? $campos['id_usuario'] : ''; ?>">

                <!-- Usuario -->
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text"
                           class="form-control"
                           id="usuario"
                           name="usuario"
                           value="<?php echo isset($campos['usuario']) ? $campos['usuario'] : ''; ?>"
                           required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email"
                           class="form-control"
                           id="email"
                           name="email"
                           value="<?php echo isset($campos['email']) ? $campos['email'] : ''; ?>"
                           required>
                </div>

                <!-- Contraseña -->
                <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password"
                           class="form-control"
                           id="contrasena"
                           name="contrasena"
                           value="<?php echo isset($campos['contraseña']) ? $campos['contraseña'] : ''; ?>"
                           required>
                </div>

                <!-- Selección de Rol -->
                <div class="mb-3">
                    <label for="id_rol" class="form-label">Rol</label>

                    <select name="id_rol"
                            id="id_rol"
                            class="form-control">

                        <option value="">Seleccione un rol</option>

                        <?php

                        // Obtiene todos los roles activos
                        $sqlRoles = "SELECT * FROM roles
                                     WHERE deleted = 0
                                     ORDER BY nombre";

                        $resultadoRoles = mysqli_query($cnn, $sqlRoles);

                        // Recorre cada rol encontrado
                        while ($rol = mysqli_fetch_assoc($resultadoRoles)) {

                            $selected = "";

                            // Marca el rol actual del usuario
                            if (
                                isset($campos['id_rol']) &&
                                $campos['id_rol'] == $rol['id_rol']
                            ) {
                                $selected = "selected";
                            }

                            // Genera cada opción del select
                            echo "<option value='" . $rol['id_rol'] . "' $selected>"
                                 . $rol['nombre'] .
                                 "</option>";
                        }

                        ?>

                    </select>
                </div>

                <!-- Estado activo/inactivo -->
                <div class="mb-3">
                    <label for="actividad_usuario" class="form-label">
                        Activo
                    </label>

                    <input type="checkbox"
                           name="actividad_usuario"
                           id="actividad_usuario"
                           class="form-check-input"
                           value="1"

                           <?php
                           // Si el usuario está activo, deja marcado el checkbox
                           echo (isset($campos['actividad_usuario']) &&
                                 $campos['actividad_usuario'] == 1)
                                 ? 'checked'
                                 : '';
                           ?>>
                </div>

                <!-- Botón guardar -->
                <button type="submit"
                        name="btnGuardar"
                        class="btn btn-primary">
                    Guardar
                </button>

            </form>

        </div>

    </div>
</div>
```

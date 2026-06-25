<?php

include "conexion.php";

$cnn = conection();

/* =====================================
   GUARDAR (ALTA O MODIFICACIÓN)
===================================== */

if (isset($_POST['btnGuardar'])) {

    $id_usuario = isset($_POST['id_usuario']) ? intval($_POST['id_usuario']) : 0;

    $usuario = mysqli_real_escape_string($cnn, $_POST['usuario']);
    $email = mysqli_real_escape_string($cnn, $_POST['email']);
    $contrasena = mysqli_real_escape_string($cnn, $_POST['contrasena']);
    $id_rol = intval($_POST['id_rol']);
    $activo = isset($_POST['actividad_usuario']) ? 1 : 0;

    /* ========= ALTA ========= */

    if ($id_usuario == 0) {

        $sql = "INSERT INTO usuarios
                (
                    usuario,
                    email,
                    contraseña,
                    id_rol,
                    actividad_usuario,
                    fecha_registro,
                    deleted
                )
                VALUES
                (
                    '$usuario',
                    '$email',
                    '$contrasena',
                    '$id_rol',
                    '$activo',
                    NOW(),
                    0
                )";

        $resp = mysqli_query($cnn, $sql);

        if ($resp) {

            $nuevoId = mysqli_insert_id($cnn);

            echo "<script>

                    alert('Usuario guardado correctamente');

                    window.location.href='index.php?seccion=usuarios&accion=modificar&id=$nuevoId';

                  </script>";

            exit;
        } else {

            die("Error: " . mysqli_error($cnn));

        }

    }

    /* ========= MODIFICACIÓN ========= */

    else {

        $sql = "UPDATE usuarios
                SET

                    usuario='$usuario',
                    email='$email',
                    contraseña='$contrasena',
                    id_rol='$id_rol',
                    actividad_usuario='$activo'

                WHERE id_usuario='$id_usuario'";

        $resp = mysqli_query($cnn, $sql);

        if ($resp) {

            echo "<script>

                    alert('Usuario modificado correctamente');

                    window.location.href='index.php?seccion=usuarios&accion=listar';

                  </script>";

            exit;

        } else {

            die("Error: " . mysqli_error($cnn));

        }

    }

}


/* =====================================
   CARGAR DATOS
===================================== */

$campos = [];

if (isset($_GET['id'])) {

    $idUsuario = intval($_GET['id']);

    $sql = "SELECT *
            FROM usuarios
            WHERE id_usuario = $idUsuario";

    $result = mysqli_query($cnn, $sql);

    if (mysqli_num_rows($result) > 0) {

        $campos = mysqli_fetch_assoc($result);

    }

}

?>

<div class="container pt-4">

    <div class="row">

        <div class="col-6">

            <h1>

                <?php

                echo isset($campos['id_usuario'])
                    ? "Modificar Usuario"
                    : "Nuevo Usuario";

                ?>

            </h1>

        </div>

        <div class="col-6 text-end">

            <a href="index.php?seccion=usuarios&accion=listar"
               class="btn btn-secondary">

                Volver

            </a>

        </div>

    </div>

    <form method="POST" class="mt-4">

        <input
            type="hidden"
            name="id_usuario"
            value="<?php echo isset($campos['id_usuario']) ? $campos['id_usuario'] : ''; ?>">

        <div class="mb-3">

            <label class="form-label">

                Usuario

            </label>

            <input
                type="text"
                class="form-control"
                name="usuario"
                required
                value="<?php echo isset($campos['usuario']) ? $campos['usuario'] : ''; ?>">

        </div>

        <div class="mb-3">

            <label class="form-label">

                Email

            </label>

            <input
                type="email"
                class="form-control"
                name="email"
                required
                value="<?php echo isset($campos['email']) ? $campos['email'] : ''; ?>">

        </div>

        <div class="mb-3">

            <label class="form-label">

                Contraseña

            </label>

            <input
                type="password"
                class="form-control"
                name="contrasena"
                required
                value="<?php echo isset($campos['contraseña']) ? $campos['contraseña'] : ''; ?>">

        </div>

        <div class="mb-3">

            <label class="form-label">

                Rol

            </label>

            <select
                name="id_rol"
                class="form-control"
                required>

                <option value="">

                    Seleccione un rol

                </option>

                <?php

                $sqlRoles = "SELECT *
                             FROM roles
                             WHERE deleted = 0
                             ORDER BY nombre";

                $resultadoRoles = mysqli_query($cnn, $sqlRoles);

                while ($rol = mysqli_fetch_assoc($resultadoRoles)) {

                    $selected = "";

                    if (
                        isset($campos['id_rol']) &&
                        $campos['id_rol'] == $rol['id_rol']
                    ) {

                        $selected = "selected";

                    }

                    ?>

                    <option
                        value="<?php echo $rol['id_rol']; ?>"
                        <?php echo $selected; ?>>

                        <?php echo $rol['nombre']; ?>

                    </option>

                    <?php

                }

                ?>

            </select>

        </div>

        <div class="mb-3">

            <label class="form-label">

                Usuario activo

            </label>

            <br>

            <input
                type="checkbox"
                class="form-check-input"
                name="actividad_usuario"
                value="1"

                <?php

                if (
                    isset($campos['actividad_usuario']) &&
                    $campos['actividad_usuario'] == 1
                ) {

                    echo "checked";

                }

                ?>

            >

        </div>

        <button
            type="submit"
            name="btnGuardar"
            class="btn btn-primary">

            Guardar

        </button>

        <a
            href="index.php?seccion=usuarios&accion=listar"
            class="btn btn-secondary">

            Cancelar

        </a>

    </form>

</div>
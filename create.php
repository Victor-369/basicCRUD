<?php
    if (isset($_POST['submit'])) {
        $resultado = [
                        'error' => false,
                        'mensaje' => 'El alumno <i>' . $_POST['nombre'] . '</i> ha sido agregado con éxito.'
                    ];

        $config = include 'config.php';

        try {
            $configMysql = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
            $conexion = new PDO($configMysql, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

            $alumno = array(
                            "nombre"   => $_POST['nombre'],
                            "apellido" => $_POST['apellido'],
                            "email"    => $_POST['email'],
                            "edad"     => $_POST['edad'],
                        );

            $consultaSQL = "INSERT INTO alumnos (nombre, apellido, email, edad)";
            $consultaSQL .= "values (:" . implode(", :", array_keys($alumno)) . ")";

            $sentencia = $conexion->prepare($consultaSQL);
            $sentencia->execute($alumno);

        } catch(PDOException $error) {
            $resultado['error'] = true;
            $resultado['mensaje'] = $error->getMessage();
        }
    }
?>


<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/bootstrap.min.css">
        <script src="./js/bootstrap.bundle.min.js"></script>
        <title>Basic CRUD</title>
    </head>
<body>
    <?php if (isset($resultado)) { ?>
        <div class="container mt-3">
            <div class="row">
                <div class="col">
                    <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
                        <?= $resultado['mensaje'] ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="mt-3">Crea un alumno</h2>
                <hr>
                <form method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" name="apellido" id="apellido" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edad">Edad</label>
                        <input type="number" name="edad" id="edad" class="form-control">
                    </div>
                    <div class="form-group mt-3">
                        <input type="submit" name="submit" class="btn btn-success" value="Enviar">
                        <a class="btn btn-secondary" href="index.php">Regresar al inicio</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
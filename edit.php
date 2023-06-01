<?php
    $config = include 'config.php';

    $resultado = [
                    'error' => false,
                    'mensaje' => ''
                ];

    if (!isset($_GET['id'])) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'El alumno no existe';
    }

    if (isset($_POST['submit'])) {
        try {
            $configMysql = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
            $conexion = new PDO($configMysql, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

            $alumno = [
                        "id"        => $_GET['id'],
                        "nombre"    => $_POST['nombre'],
                        "apellido"  => $_POST['apellido'],
                        "email"     => $_POST['email'],
                        "edad"      => $_POST['edad']
                    ];

            $consultaSQL = "UPDATE alumnos 
                            SET nombre = :nombre,
                                apellido = :apellido,
                                email = :email,
                                edad = :edad,
                                updated_at = NOW()
                            WHERE id = :id";

            $consulta = $conexion->prepare($consultaSQL);
            $consulta->execute($alumno);

        } catch(PDOException $error) {
            $resultado['error'] = true;
            $resultado['mensaje'] = $error->getMessage();
        }
    }

    try {
        $configMysql = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($configMysql, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
            
        $id = $_GET['id'];
        $consultaSQL = "SELECT * FROM alumnos WHERE id =" . $id;

        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->execute();

        $alumno = $sentencia->fetch(PDO::FETCH_ASSOC);

        if (!$alumno) {
            $resultado['error'] = true;
            $resultado['mensaje'] = 'No se ha encontrado el alumno';
        }

    } catch(PDOException $error) {
        $resultado['error'] = true;
        $resultado['mensaje'] = $error->getMessage();
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
    <?php if ($resultado['error']) { ?>
        <div class="container mt-2">
            <div class="row">
            <div class="col">
                <div class="alert alert-danger" role="alert">
                    <?= $resultado['mensaje'] ?>
                </div>
            </div>
            </div>
        </div>
    <?php } ?>

    <?php if (isset($_POST['submit']) && !$resultado['error']) { ?>
        <div class="container mt-3">
            <div class="row">
                <div class="col">
                    <div class="alert alert-success" role="alert">
                        El alumno ha sido actualizado correctamente.
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if (isset($alumno) && $alumno) { ?>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="mt-3">Editando el alumno <i><?= $alumno['nombre'] . ' ' . $alumno['apellido'] ?> </i></h2>
                    <hr>
                    <form method="post">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" value="<?= $alumno['nombre'] ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido</label>
                            <input type="text" name="apellido" id="apellido" value="<?= $alumno['apellido'] ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="<?= $alumno['email'] ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="edad">Edad</label>
                            <input type="text" name="edad" id="edad" value="<?= $alumno['edad'] ?>" class="form-control">
                        </div>
                        <div class="form-group mt-3">
                            <input type="submit" name="submit" class="btn btn-success" value="Actualizar">
                            <a class="btn btn-secondary" href="index.php">Regresar al inicio</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
</body>
</html>

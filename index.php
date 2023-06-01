<?php
    $config = include 'config.php';
    $error = false;

    try {
        $configMysql = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($configMysql, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

        if (isset($_POST['apellido'])) {
            $consultaSQL = "SELECT * FROM alumnos WHERE apellido LIKE '%" . $_POST['apellido'] . "%'";
        } else {
            $consultaSQL = "SELECT * FROM alumnos";
        }

        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->execute();
        
        $alumnos = $sentencia->fetchAll();
    } catch(PDOException $error) {
        $error= $error->getMessage();
    }

    $titulo = isset($_POST['apellido']) ? 'Lista de alumnos (' . $_POST['apellido'] . ')' : 'Lista de alumnos';
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
    <?php if ($error) { ?>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div>
                        <?= $error ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="container">
        <div class="row mt-3">
            <div class="col">
                <a href="create.php" class="btn btn-primary">Crear alumno</a>
                <hr>
                <form method="post">
                    <div class="input-group">
                        <span class="input-group-text">Filtro</span>
                        <input type="text" class="form-control" aria-label="Filtro por apellido" id="apellido" name="apellido" placeholder="Buscar por apellido">                    
                        <button type="submit" name="submit" class="btn btn-info ms-3">Ver resultados</button>
                        <button 
                            type="button" 
                            class="btn btn-secondary ms-3" 
                            onclick="document.getElementById('apellido').value = ''; 
                                    window.location.replace('./index.php');"                
                            >Borrar filtro
                        </button>
                    </div>
                </form>
                <hr>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <h2><?= $titulo ?></h2>
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Edad</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if (isset($alumnos) && $sentencia->rowCount() > 0) {
                            foreach ($alumnos as $fila) {
                    ?>
                                <tr>
                                    <td><?= $fila["id"]; ?></td>
                                    <td><?= $fila["nombre"]; ?></td>
                                    <td><?= $fila["apellido"]; ?></td>
                                    <td><?= $fila["email"]; ?></td>
                                    <td><?= $fila["edad"]; ?></td>
                                    <td>
                                    <a href="<?= 'delete.php?id=' . $fila["id"] ?>">Borrar</a>
                                    <a href="<?= 'edit.php?id=' . $fila["id"] ?>">Editar</a>
                                    </td>
                                </tr>
                    <?php   }
                        } 
                    ?>
                    <tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
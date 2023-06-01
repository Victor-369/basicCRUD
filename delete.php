<?php
  $config = include 'config.php';

  $resultado = [
              'error' => false,
              'mensaje' => ''
              ];

  try {
    $configMysql = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($configMysql, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $id = $_GET['id'];
    $consultaSQL = "DELETE FROM alumnos WHERE id =" . $id;

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();

    header('Location: ./index.php');

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
  <div class="container mt-3">
    <div class="row">
      <div class="col">
        <div class="alert alert-danger" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

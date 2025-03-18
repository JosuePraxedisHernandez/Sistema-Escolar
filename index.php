<?php
    include_once 'Configuraciones/Conexion.php';
    $conexion = Conexion::crearInstancia();

    if ($_POST) {
        $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        $consulta = $conexion->prepare("SELECT *, COUNT(*) AS n_usuario FROM tblUsuarios WHERE usuario= :usuario");
        $consulta->bindParam(':usuario', $usuario);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_LAZY);
        $n_usuario = $resultado['n_usuario'];
        $pass = $resultado['pass'];
        $usuario = $resultado['estatus'];
        
        if ($n_usuario == 1) {
            if($password === $pass){
                if ($usuario == 1) {
                    session_start();
                    $_SESSION['Id'] = $resultado['id'];
                    $_SESSION['Usuario'] = $resultado['usuario'];
                    $_SESSION['Logueado'] = true;
                    header("Location: ./Vistas/index.php");
                } else {
                    session_start();
                    $_SESSION['mensaje'] = "Usuario Inactivo";
                    header("Location: ./index.php");
                }
            }
        } else {
            session_start();
            $_SESSION['mensaje'] = "Usuario no Encontrado";
            header("Location: ./index.php");
        }
    }
?>

<!doctype html>
<html lang="es">
<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <br>
    <div class="Container">
        <div class="row">
            <div class="col-md-5">
            </div>
            <div class="col-md-2">
                <br>
                <form id="login" action="" method="post">
                    <div class="card">
                        <div class="card-header" style="text-align: center;">Inicio de Sesión</div>
                        <div class="card-body">
                            <div class="message" role="alert"></div>
                            <div class="mb-3">
                                <label for="" class="form-label">Usuario</label>
                                <input type="text" class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="Usuario" />
                                <small id="helpId" class="form-text text-muted">Escriba el Usuario</small>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="Password" />
                                <small id="helpId" class="form-text text-muted">Escriba el Password</small>
                            </div>
                            <div id="alerta"></div>
                            <button type="submit" class="btn btn-success col-md-12">Iniciar Sesión</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>
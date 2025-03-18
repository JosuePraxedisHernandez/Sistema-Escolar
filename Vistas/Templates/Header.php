<?php
    session_start();
    $url_base = "http://localhost/Sistema_Escolar/";

    if(!isset($_SESSION['Usuario'])){
        header("Location:".$url_base."index.php");
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
    <header>
        <nav class="navbar navbar-expand navbar-light bg-success">
            <div class="nav navbar-nav">
                <a class="nav-item nav-link active" href="<?php echo $url_base; ?>Vistas/" aria-current="page">Inico</a>
                <a class="nav-item nav-link" href="<?php echo $url_base; ?>Vistas/Secciones/Alumnos/">Alumnos</a>
                <a class="nav-item nav-link" href="<?php echo $url_base; ?>Vistas/Secciones/Cursos/">Cursos</a>
                <a class="nav-item nav-link" href="<?php echo $url_base; ?>Vistas/Secciones/Profesores/">Profesores</a>
                <a class="nav-item nav-link" href="<?php echo $url_base; ?>Vistas/Cerrar.php">Cerrar Sesión</a>
            </div>
        </nav>
    </header>
    <main>
        <section class="container">
<?php
    include('./Templates/Header.php');
    include_once "../Configuraciones/Conexion.php";
    $conexion = Conexion::crearInstancia();

    if (isset($_SESSION['Id'])) {
        $consulta = $conexion->prepare("SELECT * FROM tblUsuarios  WHERE id=:id");
        $consulta->bindParam(':id', $_SESSION['Id']);
        $consulta->execute();
        $listaUsuarios = $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    function obtenerConteo($conexion, $tabla) {
        $consulta = $conexion->prepare("SELECT COUNT(id) AS Total FROM $tabla");
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC)['Total'];
    }

    $alumnos = obtenerConteo($conexion, 'tblAlumnos');
    $cursos = obtenerConteo($conexion, 'tblCursos');
    $profesores = obtenerConteo($conexion, 'tblProfesores');
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row md-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card border-success">
                            <div class="card-body box-profile ">
                                <div class="text-center">
                                    <img src="../Pictures/usuario.png" width="120px" height="60px" class="profile-user-img img-fluid img-circle ">
                                </div>
                                <?php foreach ($listaUsuarios as $usuarios) { ?>
                                    <h3 class="profile-username text-center text-success"><?php echo $usuarios['nombre']; ?></h3>
                                    <p class="text-muted text-center"><?php echo $usuarios['apellido_paterno'] . ' ' . $usuarios['apellido_materno']; ?></p>
                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b style="color: #0B7300;">Tipo de Usuario</b>
                                            <span class="float-right badge rounded-pill bg-danger $badge-color:$white;">
                                                <?php 
                                                    if($usuarios['perfil'] == 1){
                                                        echo "Root";
                                                    }
                                                ?>
                                            </span>
                                        </li>
                                    </ul>
                            </div>
                        </div>
                        <br>
                        <div class="card border-success">
                            <div class="card">
                                <div class="card-header text-center text-white bg-success">DATOS PERSONALES</div>
                                <div class="card-body">
                                    <strong style="color: #0B7300"><i class="bi bi-person"></i> Usuario</strong>
                                    <p class="text-muted"><?php echo $usuarios['usuario']; ?></p>
                                    <strong style="color: #0B7300"><i class="bi bi-envelope"></i> Correo Electrónico</strong>
                                    <p class="text-muted"><?php echo $usuarios['email'];; ?></p>
                                    <strong style="color: #0B7300"><i class="bi bi-telephone"></i> Teléfono</strong>
                                    <p class="text-muted"><?php echo $usuarios['telefono']; ?></p>
                                    <strong style="color: #0B7300"><i class="bi bi-geo-alt"></i> Dirección </strong>
                                    <p class="text-muted"><?php echo $usuarios['direccion']; ?></p>
                                </div>
                            <?php } ?>
                            <div class="card-footer text-muted"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header text-center text-white bg-success">
                                <h2>Sistema Escolar</h2>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="card text-center bg-primary">
                                                <div class="card-body">
                                                    <i class="bi bi-people-fill" style="font-size: 3rem;"></i>
                                                    <h3 class="card-title mt-2">Alumnos</h3>
                                                    <p class="card-text"><strong><?php echo $alumnos; ?></strong></p>
                                                </div>
                                                <div class="card-footer"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card text-center bg-info">
                                                <div class="card-body">
                                                    <i class="bi bi-book-fill" style="font-size: 3rem;"></i>
                                                    <h3 class="card-title mt-2">Cursos</h3>
                                                    <p class="card-text"><strong><?php echo $cursos; ?></strong></p>
                                                </div>
                                                <div class="card-footer"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card text-center bg-secondary">
                                                <div class="card-body">
                                                    <i class="bi bi-person-workspace" style="font-size: 3rem;"></i>
                                                    <h3 class="card-title mt-2">Profesores</h3>
                                                    <p class="card-text"><strong><?php echo $profesores; ?></strong></p>
                                                </div>
                                                <div class="card-footer"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-muted"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include('./Templates/Footer.php'); ?>
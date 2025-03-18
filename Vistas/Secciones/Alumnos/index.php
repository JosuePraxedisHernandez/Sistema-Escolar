<?php
    include('../../Templates/Header.php');
    include_once "../../../Configuraciones/Conexion.php";
    $conexion = Conexion::crearInstancia();

    if (isset($_GET['txtID'])) {
        $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : '';
        $consulta = $conexion->prepare("DELETE FROM tblAlumnos WHERE id=:id");
        $consulta->bindParam(':id', $txtID);
        $consulta->execute();
        header("Location:index.php");
    }

    $consulta = $conexion->prepare("SELECT id, CONCAT(nombre, ' ', apellido_paterno, ' ',  apellido_materno) AS nombre_completo, email, telefono FROM tblAlumnos");
    $consulta->execute();
    $listaAlumnos = $consulta->fetchAll(PDO::FETCH_ASSOC);

    foreach ($listaAlumnos as $clave => $alumno) {
        $consulta = $conexion->prepare("SELECT * FROM tblCursos WHERE id IN (SELECT id_curso FROM tblCurso_Alumno WHERE id_alumno=:idalumno)");
        $consulta->bindParam(':idalumno', $alumno['id']);
        $consulta->execute();
        $cursoAlumno = $consulta->fetchAll();
        $listaAlumnos[$clave]['tblCursos'] = $cursoAlumno;
    }
?>

<br>
<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="Registrar.php" role="button"><i class="bi bi-person-fill-add"></i> Agregar Alumno</a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre Completo</th>
                        <th scope="col">Teléfono </th>
                        <th scope="col">Email</th>
                        <th scope="col">Cursos</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $contador=0;
                    foreach ($listaAlumnos as $alumn) { ?>
                        <tr class="">
                            <td scope="row"> <?php echo $contador = $contador + 1; ?> </td>
                            <td> <?php echo $alumn['nombre_completo']; ?> </td>
                            <td> <?php echo $alumn['telefono']; ?> </td>
                            <td> <?php echo $alumn['email']; ?> </td>
                            <td>
                                <?php foreach($alumn["tblCursos"] as $curso){ ?>
                                        -<a href="../Certificados/certificado.php?idcurso=<?php echo $curso['id'] ?>&idalumno=<?php echo $alumn['id']?>"> <?php echo $curso['nombre']; ?> </a><br>
                                <?php }?>
                            </td>
                            <td>
                                <a name="" id="" class="btn btn-warning" href="./Editar.php?txtID=<?php echo $alumn['id']; ?>" role="button"><i class="bi bi-pencil-square"></i> Editar</a>
                                <a name="" id="" class="btn btn-danger" href="./index.php?txtID=<?php echo $alumn['id']; ?>" role="button"><i class="bi bi-trash-fill"></i> Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include('../../Templates/Footer.php'); ?>
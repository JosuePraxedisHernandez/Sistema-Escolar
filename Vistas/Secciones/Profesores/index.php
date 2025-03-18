<?php
    include('../../Templates/Header.php');
    include_once "../../../Configuraciones/Conexion.php";
    $conexion = Conexion::crearInstancia();

    if(isset($_GET['txtID'])){
        $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : '';
        $consulta = $conexion->prepare("DELETE FROM tblProfesores WHERE id=:id");
        $consulta->bindParam(':id', $txtID);
        $consulta->execute();
        header("Location:index.php");
    }

    $consulta = $conexion->prepare("SELECT id, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS nombre_completo FROM tblProfesores");
    $consulta->execute();
    $listaprofesores = $consulta->fetchAll(PDO::FETCH_ASSOC);

    foreach ($listaprofesores as $clave => $profesor) {
        $consulta = $conexion->prepare("SELECT * FROM tblCursos WHERE id IN (SELECT id_curso FROM tblCurso_Profesor WHERE id_profesor = :idProfesor)");
        $consulta->bindParam(':idProfesor', $profesor['id']);
        $consulta->execute();
        $cursoProfesor = $consulta->fetchAll();
        $listaprofesores[$clave]['tblCursos'] = $cursoProfesor;
    }
?>

<br>
<div class="card">
    <div class="card-header">
    <a name="" id="" class="btn btn-primary" href="Registrar.php" role="button"><i class="bi bi-person-fill-add"></i> Agregar Profesor</a>
    </div>
    <div class="card-body">
        <div
            class="table-responsive">
            <table
                class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre Completo</th>
                        <th scope="col">Curso que Imparte</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $contador=0;
                    foreach ($listaprofesores as $profesor) { ?>
                        <tr class="">
                            <td scope="row"> <?php echo $contador = $contador + 1; ?> </td>
                            <td> <?php echo $profesor['nombre_completo']; ?> </td>
                            <td>
                                <?php foreach($profesor["tblCursos"] as $curso){ ?>
                                        -<a> <?php echo $curso['nombre']; ?> </a><br>
                                <?php }?>
                            </td>
                            <td>
                                <a name="" id="" class="btn btn-warning" href="./Editar.php?txtID=<?php echo $profesor['id']; ?>" role="button"><i class="bi bi-pencil-square"></i> Editar</a>
                                <a name="" id="" class="btn btn-danger" href="./index.php?txtID=<?php echo $profesor['id']; ?>" role="button"><i class="bi bi-trash-fill"></i> Eliminar</a>
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
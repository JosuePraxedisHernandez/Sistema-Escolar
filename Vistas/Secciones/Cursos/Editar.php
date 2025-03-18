<?php 
    include('../../Templates/Header.php');
    include_once "../../../Configuraciones/Conexion.php";
    $conexion = Conexion::crearInstancia();

    if (isset($_GET['txtID'])) {
        $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : '';
        $consulta = $conexion->prepare("SELECT * FROM tblCursos WHERE id=:id");
        $consulta->bindParam(':id', $txtID);
        $consulta->execute();

        $curso = $consulta->fetch(PDO::FETCH_LAZY);
        $nombre_curso = $curso['nombre'];
        $descripcion_curso = $curso['descripcion'];
    }

    if ($_POST) {
        $nombre_curso = (isset($_POST['nombre_curso'])) ? $_POST['nombre_curso'] : '';
        $descripcion_curso = (isset($_POST['descripcion_curso'])) ? $_POST['descripcion_curso'] : '';
        $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : '';
        $consulta = $conexion->prepare("UPDATE tblCursos SET nombre=:nombre, descripcion=:descripcion WHERE id=:id");
        $consulta->bindParam(':nombre', $nombre_curso);
        $consulta->bindParam(':descripcion', $descripcion_curso);
        $consulta->bindParam(':id', $txtID);
        $consulta->execute();
        header("Location:index.php");
    }
?>

<br>
<div class="card">
    <div class="card-header">Cursos</div>
    <div class="card-body">

        <form action="" method="post">
            <input type="hidden" class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" aria-describedby="helpId"/>
            <div class="mb-3">
                <label for="" class="form-label">Nombre</label>
                <input type="text" class="form-control" value="<?php echo $nombre_curso; ?>" name="nombre_curso" id="nombre_curso" aria-describedby="helpId"/>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion_curso" id="descripcion_curso" rows="3"><?php echo $descripcion_curso; ?></textarea>
            </div>
            <button type="submit" class="btn btn-success"><i class="bi bi-pencil-square"></i> Editar Curso</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button"><i class="bi bi-x-circle"></i> Cancelar</a>
        </form>

    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include('../../Templates/Footer.php'); ?>
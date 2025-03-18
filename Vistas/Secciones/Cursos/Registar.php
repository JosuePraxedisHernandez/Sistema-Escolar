<?php 
    include('../../Templates/Header.php');
    include_once "../../../Configuraciones/Conexion.php";
    $conexion = Conexion::crearInstancia();

    if ($_POST) {

        $nombre_curso = isset($_POST['nombre_curso']) ? $_POST['nombre_curso'] : '';
        $descripcion_curso = isset($_POST['descripcion_curso']) ? $_POST['descripcion_curso'] : '';

        $consulta = $conexion->prepare("INSERT INTO tblCursos (id, nombre, descripcion) VALUES (NULL, :nombre, :descripcion)");
        $consulta->bindParam(':nombre', $nombre_curso);
        $consulta->bindParam(':descripcion', $descripcion_curso);
        $consulta->execute();
        header("Location: index.php");
    }
?>

<br>
<div class="card">
    <div class="card-header">Cursos</div>
    <div class="card-body">
        <form action="" method="post">
            <div class="mb-3">
                <label for="" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre_curso" id="nombre_curso" aria-describedby="helpId" placeholder="Escriba el nombre del curso"/>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Descripción </label>
                <textarea class="form-control" name="descripcion_curso" id="descripcion_curso" rows="3" placeholder="Escriba la descripción del curso"></textarea>
            </div>
            <button type="submit" class="btn btn-success"><i class="bi bi-floppy-fill"></i> Agregar Curso</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button"><i class="bi bi-x-circle"></i> Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include('../../Templates/Footer.php'); ?>
<?php
    include('../../Templates/Header.php');
    include_once "../../../Configuraciones/Conexion.php";
    $conexion = Conexion::crearInstancia();

    $consulta = $conexion->prepare("SELECT * FROM tblCursos");
    $consulta->execute();
    $cursos = $consulta->fetchAll();

    if (isset($_GET['txtID'])) {

        $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : '';
        $consulta = $conexion->prepare("SELECT * FROM tblAlumnos WHERE id=:id");
        $consulta->bindParam(':id', $txtID);
        $consulta->execute();

        $alumno = $consulta->fetch(PDO::FETCH_LAZY);
        $nombre = $alumno['nombre'];
        $apellido_paterno = $alumno['apellido_paterno'];
        $apellido_materno = $alumno['apellido_materno'];
        $email = $alumno['email'];
        $telefono = $alumno['telefono'];
        $direccion = $alumno['direccion'];

        $consulta = $conexion->prepare("SELECT c.id FROM tblCurso_Alumno a INNER JOIN tblCursos c ON c.id=a.id_curso WHERE a.id_alumno=:idalumno");
        $consulta->bindParam(':idalumno', $txtID);
        $consulta->execute();
        $cursoAlumno = $consulta->fetchAll(PDO::FETCH_ASSOC);

        foreach ($cursoAlumno as $curso) {
            $arregloCursos[] = $curso['id'];
        }
    }

    if ($_POST) {
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
        $apellido_paterno = isset($_POST['apellido_paterno']) ? $_POST['apellido_paterno'] : '';
        $apellido_materno = isset($_POST['apellido_materno']) ? $_POST['apellido_materno'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
        $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
        $cursos = isset($_POST['cursos']) ? $_POST['cursos'] : '';
        $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : '';

        $consulta = $conexion->prepare("UPDATE tblAlumnos SET nombre=:nombre, apellido_paterno=:apellido_paterno, apellido_materno=:apellido_materno, email=:email, telefono=:telefono, direccion=:direccion WHERE id=:id");
        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':apellido_paterno', $apellido_paterno);
        $consulta->bindParam(':apellido_materno', $apellido_materno);
        $consulta->bindParam(':email', $email);
        $consulta->bindParam(':telefono', $telefono);
        $consulta->bindParam(':direccion', $direccion);
        $consulta->bindParam(':id', $txtID);
        $consulta->execute();

        if (isset($cursos)) {
            $consulta = $conexion->prepare("DELETE FROM tblCurso_Alumno WHERE id_alumno= :idalumno");
            $consulta->bindParam(':idalumno', $txtID);
            $consulta->execute();

            foreach ($cursos as $curso) {
                $consulta = $conexion->prepare("INSERT INTO tblCurso_Alumno (id, id_alumno, id_curso) VALUES (NULL, :idalumno, :idcurso)");
                $consulta->bindParam(':idalumno', $txtID);
                $consulta->bindParam(':idcurso', $curso);
                $consulta->execute();
                $arregloCursos = $curso;
            }
        }
        header("Location:index.php");
    }
?>

<br>
<div class="card">
    <div class="card-header">Alumnos</div>
    <div class="card-body">

        <form action="" method="post">
            <input type="hidden" class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" aria-describedby="helpId"/>
            <div class="mb-3">
                <label for="" class="form-label">Nombre</label>
                <input type="text" class="form-control" value="<?php echo $nombre; ?>" name="nombre" id="nombre" aria-describedby="helpId"/>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Apellido Paterno</label>
                <input type="text" class="form-control" value="<?php echo $apellido_paterno; ?>" name="apellido_paterno" id="apellido_paterno" aria-describedby="helpId"/>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Apellido Materno</label>
                <input type="text" class="form-control" value="<?php echo $apellido_materno; ?>" name="apellido_materno" id="apellido_materno" aria-describedby="helpId"/>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Dirección</label>
                <input type="text" class="form-control" value="<?php echo $direccion; ?>" name="direccion" id="direccion" aria-describedby="helpId"/>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Telefóno</label>
                <input type="text" class="form-control" value="<?php echo $telefono; ?>" name="telefono" id="telefono" aria-describedby="helpId"/>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" value="<?php echo $email; ?>" name="email" id="email" aria-describedby="helpId"/>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Cursos</label>
                <select multiple="multiple" class="form-control" name="cursos[]" id="listacursos">
                    <option>Seleccione una opción</option>
                    <?php foreach ($cursos as $curso) { ?>
                        <option
                            <?php
                                if (!empty($arregloCursos)) {
                                    if (in_array($curso['id'], $arregloCursos)) {
                                        echo 'selected';
                                    }
                                } 
                            ?>
                            value="<?php echo $curso['id']; ?>"> - <?php echo $curso['nombre']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success"><i class="bi bi-pencil-square"></i> Modificar Alumno</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button"><i class="bi bi-x-circle"></i> Cancelar</a>
        </form>

    </div>
    <div class="card-footer text-muted"></div>
</div>

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<script>
    new TomSelect('#listacursos');
</script>

<?php include('../../Templates/Footer.php'); ?>
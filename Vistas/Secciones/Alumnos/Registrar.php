<?php 
    include('../../Templates/Header.php');
    include_once "../../../Configuraciones/Conexion.php";
    $conexion = Conexion::crearInstancia();

    $consulta= $conexion->prepare("SELECT * FROM tblCursos");
    $consulta->execute();
    $cursos = $consulta->fetchAll();

    if ($_POST) {

        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
        $apellido_paterno = isset($_POST['apellido_paterno']) ? $_POST['apellido_paterno'] : '';
        $apellido_materno = isset($_POST['apellido_materno']) ? $_POST['apellido_materno'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
        $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
        $cursos = isset($_POST['cursos']) ? $_POST['cursos'] : '';

        $consulta = $conexion->prepare("INSERT INTO tblAlumnos (id, nombre, apellido_paterno, apellido_materno, email, telefono, direccion) VALUES (NULL, :nombre, :apellido_paterno, :apellido_materno, :email, :telefono, :direccion)");
        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':apellido_paterno', $apellido_paterno);
        $consulta->bindParam(':apellido_materno', $apellido_materno);
        $consulta->bindParam(':email', $email);
        $consulta->bindParam(':telefono', $telefono);
        $consulta->bindParam(':direccion', $direccion);
        $consulta->execute();

        $idAlumno= $conexion->lastInsertId();

        foreach($cursos as $curso){

            $consulta= $conexion->prepare("INSERT INTO tblCurso_Alumno (id, id_alumno, id_curso) VALUES (NULL, :idalumno, :idcurso)");
            $consulta->bindParam(':idalumno', $idAlumno);
            $consulta->bindParam('idcurso', $curso);
            $consulta->execute();
        }
        header("Location: index.php");
    }
?>

<br>
<div class="card">
    <div class="card-header">Alumnos</div>
    <div class="card-body">

        <form class="" action="" method="post">
            <div class="mb-3">
                <label for="" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" id="nombre" aria-describedby="helpId" placeholder="Escriba el nombre del alumno" />
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Apellido Paterno</label>
                <input type="text" class="form-control" name="apellido_paterno" id="apellido_paterno" aria-describedby="helpId" placeholder="Escriba el apellido paterno del alumno" />
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Apellido Materno</label>
                <input type="text" class="form-control" name="apellido_materno" id="apellido_materno" aria-describedby="helpId" placeholder="Escriba el apellido materno del alumno" />
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Dirección</label>
                <input type="text" class="form-control" name="direccion" id="direccion" aria-describedby="helpId" placeholder="Escriba la dirección del alumno" />
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Telefóno</label>
                <input type="text" class="form-control" name="telefono" id="telefono" aria-describedby="helpId" placeholder="Escriba el teléfono  del alumno" />
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" name="email" id="email" aria-describedby="helpId" placeholder="Escriba el correo electrónico del alumno" />
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Cursos</label>
                <select multiple class="form-control" name="cursos[]" id="listacursos">
                    <option>Seleccione una opción</option>
                    <?php
                        $contador=0;
                        foreach ($cursos as $curso) { ?>
                        <option value="<?php echo $curso['id']; ?>"> - <?php echo $contador = $contador + 1; ?> <?php echo $curso['nombre']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success"><i class="bi bi-floppy-fill"></i> Agregar alumno</button>
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
<?php
    include('../../Templates/Header.php');
    include_once "../../../Configuraciones/Conexion.php";
    $conexion = Conexion::crearInstancia();

    if (isset($_GET['txtID'])) {
        $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : '';
        $consulta = $conexion->prepare("DELETE FROM tblCursos WHERE id=:id");
        $consulta->bindParam(':id', $txtID);
        $consulta->execute();
        header("Location:index.php");
    }

    $consulta = $conexion->prepare("SELECT * FROM tblCursos");
    $consulta->execute();
    $listacursos = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>

<br>
<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="Registar.php" role="button"><i class="bi bi-file-earmark-plus"></i> Agregar Curso</a>
    </div>
    <div class="card-body">
        <div
            class="table-responsive">
            <table class="table table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $contador=0;
                    foreach ($listacursos as $curso) { ?>
                        <tr class="">
                            <td scope="row"> <?php echo $contador = $contador + 1; ?> </td>
                            <td> <?php echo $curso['nombre']; ?> </td>
                            <td> <?php echo $curso['descripcion']; ?> </td>
                            <td>
                                <a name="" id="" class="btn btn-warning" href="Editar.php?txtID=<?php echo $curso['id']; ?>" role="button"><i class="bi bi-pencil-square"></i> Editar</a>
                                <a name="" id="" class="btn btn-danger" href="index.php?txtID=<?php echo $curso['id']; ?>" role="button"><i class="bi bi-trash-fill"></i> Eliminar</a>
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
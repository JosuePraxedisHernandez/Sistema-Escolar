<?php 
    require('../../../Librerias/fpdf/fpdf.php'); 
    include_once("../../../Configuraciones/Conexion.php");

    $conexion = Conexion::crearInstancia();

    function agregarTexto($pdf, $texto, $x, $y, $aling='L', $fuente, $size=10, $r=0, $g=0, $b=0){
        $pdf->SetFont ($fuente,'',$size);
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor($r,$g,$b);
        $pdf->Cell(0,10,$texto,0,0,$aling);
    }

    function agregarImagen($pdf, $imagen, $x, $y){
        $pdf->Image($imagen,$x,$y,0);
    }

    $idcurso = isset($_GET['idcurso']) ? $_GET['idcurso'] : ''; 
    $idalumno = isset($_GET['idalumno']) ? $_GET['idalumno'] : ''; 

    $consulta = $conexion->prepare("SELECT a.nombre, a.apellido_paterno, a.apellido_materno, c.nombre as Nombre_Curso FROM tblAlumnos a INNER JOIN tblCursos c ON a.id=:idalumno AND c.id=:idcurso");
    $consulta->bindParam(':idalumno', $idalumno); 
    $consulta->bindParam(':idcurso', $idcurso);
    $consulta->execute(); 
    $alumno = $consulta->fetch(PDO::FETCH_ASSOC); 
    
    $pdf = new FPDF('L','mm',array(338,190));
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    agregarImagen($pdf,'../../../src/Certificado.jpg', 0, 0);
    agregarTexto($pdf, $alumno['nombre']. " ".$alumno['apellido_paterno']." ".$alumno['apellido_materno'], 120, 80, 'L', 'Helvetica', 30, 0, 84, 115);
    agregarTexto($pdf, $alumno['Nombre_Curso'], 20, 105, 'C', 'Helvetica', 20, 0, 84, 115);
    agregarTexto($pdf, date("d/m/Y"), 200, 159, 'C', 'Helvetica', 11, 0, 84, 115);
    $pdf->Output();
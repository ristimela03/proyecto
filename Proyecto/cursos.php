<?php include("template/cabecera.php"); ?>
<?php

include("administrador/config/bd.php");

    $sentenciaSQL= $conexion->prepare("SELECT * FROM cursos");
    $sentenciaSQL->execute();
    $listaCursos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<?php  foreach ($listaCursos as $curso) {?>
    


<div class="col-md-3">
    
<div class="card">

    <img class="card-img-top"  src="./img/<?php echo $curso['Imagen'];?>"  alt=""> 
    

    <div class="card-body">
        <h4 class="card-title"><?php echo $curso['Nombre'];?></h4>
        <p class="card-text"><?php echo $curso['Descripcion'];?> </p>
        <center><a name="" id="" class="btn btn-primary" href="administrador" role="button">Lo quiero</a></center>
</div>

</div>

</div>
<?php } ?>
<br/>





<?php include("template/pie.php"); ?>
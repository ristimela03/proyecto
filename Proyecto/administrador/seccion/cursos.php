<?php include("../template/cabecera.php");?>
<?php

include("../config/bd.php");

$txtId=(isset($_POST['txtId']))?$_POST['txtId']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtDescripcion=(isset($_POST['txtDescripcion']))?$_POST['txtDescripcion']:"";
$txtImagen=(isset($_POST['txtImagen']['name']))?$_POST['txtImagen']['name']:"";

$accion=(isset($_POST['accion']))?$_POST['accion']:"";



switch($accion){
    case "Agregrar":
        $sentenciaSQL= $conexion->prepare("INSERT INTO cursos (Nombre,Descripcion,Imagen) VALUES (:Nombre,:Descripcion,:Imagen);");
        $sentenciaSQL->bindParam(':Nombre',$txtNombre);
        $sentenciaSQL->bindParam(':Descripcion',$txtDescripcion);
    
        $fecha= new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";

        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

        if ($tmpImagen!="") {
            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
        }

        $sentenciaSQL->bindParam(':Imagen',$nombreArchivo);
        $sentenciaSQL->execute();

        header("location:cursos.php");
        break;

    case "Modificar":
        $sentenciaSQL= $conexion->prepare("UPDATE cursos SET Nombre=:Nombre WHERE Id=:Id");
        $sentenciaSQL->bindParam(':Nombre',$txtNombre);
        $sentenciaSQL->bindParam(':Id',$txtId);
        $sentenciaSQL->execute();

        $sentenciaSQL= $conexion->prepare("UPDATE cursos SET Descripcion=:Descripcion WHERE Id=:Id");
        $sentenciaSQL->bindParam(':Descripcion',$txtDescripcion);
        $sentenciaSQL->bindParam(':Id',$txtId);
        $sentenciaSQL->execute();

        if ($txtImagen!="") {

        $fecha= new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

        $sentenciaSQL= $conexion->prepare("SELECT Imagen FROM cursos WHERE Id=:Id");
        $sentenciaSQL->bindParam(':Id',$txtId);
        $sentenciaSQL->execute();
        $curso=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if (isset($curso["Imagen"]) &&($curso["Imagen"]!="Imagen.jpg")) {
            if (file_exists("../../img/".$curso["Imagen"])) {
                unlink("../../img/".$curso["Imagen"]);
            }
        }


        
            $sentenciaSQL= $conexion->prepare("UPDATE cursos SET Imagen=:Imagen WHERE Id=:Id");
            $sentenciaSQL->bindParam(':Imagen',$nombreArchivo);
            $sentenciaSQL->bindParam(':Id',$txtId);
            $sentenciaSQL->execute();

            header("location:cursos.php");
           
        }

        break;
        
    case "Cancelar":
        header("location:cursos.php");
        break;
        
    case "Seleccionar":
        $sentenciaSQL= $conexion->prepare("SELECT * FROM cursos WHERE Id=:Id");
        $sentenciaSQL->bindParam(':Id',$txtId);
        $sentenciaSQL->execute();
        $curso=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre=$curso['Nombre'];
        $txtDescripcion=$curso['Descripcion'];
        $txtImagen=$curso['Imagen'];
        
        break; 

    case "Borrar":
        
        $sentenciaSQL= $conexion->prepare("SELECT Imagen FROM cursos WHERE Id=:Id");
        $sentenciaSQL->bindParam(':Id',$txtId);
        $sentenciaSQL->execute();
        $curso=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if (isset($curso["Imagen"]) &&($curso["Imagen"]!="Imagen.jpg")) {
            if (file_exists("../../img/".$curso["Imagen"])) {
                unlink("../../img/".$curso["Imagen"]);
            }
        }





        $sentenciaSQL= $conexion->prepare("DELETE  FROM cursos WHERE Id=:Id");
        $sentenciaSQL->bindParam(':Id',$txtId);
        $sentenciaSQL->execute();

        header("location:cursos.php");

        //echo "presionado boton Borrar";
        break; 
}

$sentenciaSQL= $conexion->prepare("SELECT * FROM cursos");
$sentenciaSQL->execute();
$listaCursos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>



<div class="col-md-5">
    <div class="card">
        <div class="card-header">
            Datos del curso
        </div>
        <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
    <div class = "form-group">
    <label for="txtId">Id:</label>
    <input type="text" required readonly class="form-control" value="<?php echo $txtId;?>" name="txtId" id="txtId"  placeholder="Id">
    </div>

    <div class = "form-group">
    <label for="txtNombre">Nombre del curso:</label>
    <input type="text" required class="form-control" value="<?php echo $txtNombre;?>" name="txtNombre" id="txtNombre"  placeholder="Nombre del curso">
    </div>

    <div class = "form-group">
    <label for="txtDescripcion">Descripcion del curso:</label>
    <input type="text" required class="form-control" value="<?php echo $txtDescripcion;?>" name="txtDescripcion"  id="txtDescripcion"  placeholder="Descripcion del curso">
    </div>

    <div class = "form-group">
    <label for="txtImagen">Imagen:</label>
   <br/>

    <?php if ($txtImagen!="") { ?>

        <img class="img-thumbnail rounded" src="../../img/"<?php echo $txtImagen;?>width="50" alt="" srcset="">
        
    <?php } ?>


    <input type="file" class="form-control" name="txtImagen" id="txtImagen"  placeholder="Imagen">
    </div>

    <div class="btn-group" role="group" aria-label="">
        <button type="submit" name="accion" <?php echo ($accion=="seleccionar")?"disabled":"";?> value="Agregrar" class="btn btn-success">Agregar</button>
        <button type="submit" name="accion"  value="Modificar" class="btn btn-warning">Modificar</button>
        <button type="submit" name="accion"  value="Cancelar" class="btn btn-info">Cancelar</button>
    </div>
    </form>
    
        </div>
        
    </div>


    
    
    
</div>
<div class="col-md-7">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaCursos as $curso) { ?>
            <tr>
                <td><?php echo $curso['Id'];?> </td>
                <td><?php echo $curso['Nombre'];?></td>
                <td><?php echo $curso['Descripcion'];?></td>
                <td>
                
                <img class="img-thumbnail rounded"src="../../img/<?php echo $curso['Imagen'];?>"width="50" alt="" srcset="">
                
                
                </td>
                
                <td>
 

                <form  method="post">
                    <input type="hidden" name="txtId" id="txtId" value="<?php echo $curso['Id'];?>"> 

                    <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>
                    <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>


                </form>
            
            
            </td>
            </tr>
            <?php } ?>
            
        </tbody>
    </table>
</div>

<?php include("../template/pie.php");?>
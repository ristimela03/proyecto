<?php

session_start();
if($_POST){
    if (($_POST['correo']=="rmenlat@hotmail.com")&&($_POST['contraseña']=="1234")){
        
        $_SESSION['correo']="ok";
        $_SESSION['nombreUsuario']="rmenlat@hotmail.com";
        header('Location:inicio.php');
        
    }else {
        $mensaje="Error: usuario o contraseña incorrectos";


        
    }


    }if ($_POST) {
        if(($_POST['correo']=="rmenlat@gmail.com")&&($_POST['contraseña']=="12345")){
        
            $_SESSION['correo']="ok";
            $_SESSION['nombreUsuario']="rmenlat@gmail.com";
            header('Location:../usuario/index.php');
        }else {
            $mensaje="Error: usuario o contraseña incorrectos";
    
}
    }



?>


<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      
   <div class="container">
       <div class="row">

           <div class="col-md-4">

           </div>

           <div class="col-md-4">
               
           <br/><br/><br/>
               <div class="card">
                   <center><div class="card-header">
                       LOGIN
                   </div></center>
                   <div class="card-body">
                        <?php if(isset($mensaje)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $mensaje?>
                        </div> 
                        <?php } ?>                  
                      <form method="POST">
                      <div class = "form-group">
                      <label> Email:</label>
                      <input type="email" required class="form-control" name="correo"  placeholder="Ingrese email">
                      <small id="emailHelp" class="form-text text-muted">Nunca compartiremos su correo electrónico con nadie más.</small>
                      </div>
                      <div class="form-group">
                      <label >Contraseña:</label>
                      <input type="password" required class="form-control" name="contraseña" placeholder="Ingrese Contraseña">
                      </div>
                      
                      <center><button type="submit" class="btn btn-primary">Iniciar sesion</button></center>
                      </form>
                      
                       
                   </div>
                   
               </div>
               
           </div>
           
       </div>
   </div>
  </body>
</html>
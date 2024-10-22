<?php
session_start();
if (!empty($_SESSION['active'])) {
    header('location: src/');
} else {
    if (!empty($_POST)) {
        $alert = '';
        if (empty($_POST['usuario']) || empty($_POST['clave'])) {
            $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Ingrese usuario y contraseña
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        } else {
            require_once "conexion.php";
            $user = mysqli_real_escape_string($conexion, $_POST['usuario']);
            $clave = md5(mysqli_real_escape_string($conexion, $_POST['clave']));
            $query = mysqli_query($conexion, "SELECT * FROM usuario WHERE usuario = '$user' AND clave = '$clave'");
            mysqli_close($conexion);
            $resultado = mysqli_num_rows($query);
            if ($resultado > 0) {
                $dato = mysqli_fetch_array($query);
                $_SESSION['active'] = true;
                $_SESSION['idUser'] = $dato['idusuario'];
                $_SESSION['nombre'] = $dato['nombre'];
                $_SESSION['user'] = $dato['usuario'];
                header('Location: src/');
            } else {
                $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Contraseña incorrecta
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                session_destroy();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/material-dashboard.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/img/favicon.ico" />
</head>
<body class="otbg">
    <div class="col-md-4 mx-auto">
        <?php echo (isset($alert)) ? $alert : '' ; ?>
							<div class="card" style="margin-top: 90px; width: 380px">
								<div class="card-header text-center mt-4">
									<img class="img-thumbnail" src="assets/img/test.jpg" width="150"/>
                                    <h4 class="card-title mt-3">Bienvenido</h4>
								</div>
								<div class="card-body" style="margin-top: -45px">
									<?php echo isset($alert) ? $alert : ''; ?>
									<form action="" method="post" class="p-3">
										<div class="form-group">
                                            <input type="text" id="exampleInputEmail1" class="form-control" name="usuario"/>
                                            <label class="form-label" for="form2Example1">Usuario</label>
										</div>
										<div class="form-group" style="margin-top: -10px">
                                            <input type="password" id="exampleInputPassword1" class="form-control" name="clave"/>
                                            <label class="form-label" for="form2Example2">Contraseña</label>
										</div>
										<div class="mt-3">
                                            <button type="submit" class="btn btn-primary btn-block mb-4">Ingresar</button>
										</div>

									</form>
								</div>
							</div>
    </div>
    <script src="assets/js/material-dashboard.js"></script>
</body>

</html>
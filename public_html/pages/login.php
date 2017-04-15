<?php
require_once 'inventario/db_connect.php';

session_start();

if(isset($_SESSION['id'])) {
	header('location: agregar_atm.php');	
}

$errors = array();

if($_POST) {		

	$username = $connect->real_escape_string($_POST['username']); // Escapando caracteres especiales
	$password = $connect->real_escape_string($_POST['password']);
    
    echo $username;
    echo $password;
	if(empty($username) || empty($password)) {
		if($username == "") {
			$errors[] = "Se requiere nombre de usuario";
		} 

		if($password == "") {
			$errors[] = "Se requiere contraseña";
		}
	} else {
		$sql = "SELECT * FROM login WHERE username = '$username'";
		$result = $connect->query($sql);
        $rows= $result->num_rows;

		if($rows == 1) {
			//$password = md5($password);
			// exists
			$mainSql = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";
			$mainResult = $connect->query($mainSql);

			if($mainResult->num_rows == 1) {
				$value = $mainResult->fetch_assoc();
				$user_id = $value['id'];
				// set session
				$_SESSION['id'] = $user_id;
				header('location: agregar_atm.php');	
			} else{
				
				$errors[] = "Combinación incorrecta de nombre de usuario y/o contraseña";
			} // /else
		} else {		
			$errors[] = "El nombre de usuario no existe";		
		} // /else
	} // /else not empty username // password
	
} // /if $_POST
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>InventariAPP | Log in</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <!--estilos propios -->
        <link rel="stylesheet" href="../dist/css/styles.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="../plugins/iCheck/square/blue.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- Favicon -->
        <link rel="icon" href="../imagenes/icon.png">
        <link rel="shortcut icon" href="../imagenes/icon.png">

        <!-- Marcador en escritorio de Iphone-->
        <link rel="apple-touch-icon" href="../imagenes/icon.png">
    </head>
    <body class="hold-transition login-page" STYLE="background-color:#00A933">
   

            <!-- inicio cabecera -->
            <header>
                <div class="container">
                    <figure class="inventariapp-logo-container pull-left">
                        <a href="https://interbank.pe/"><img class="inventariapp-logo img-responsive" src="../imagenes/logo.png" width="200" height="200" alt="Logotipo Interbank - Enlace al home de La página"></a>
                    </figure>
                </div>
            </header>
            <!-- fin cabecera -->

            
            
            <div class="login-box">
                <div  class="login-logo">
                    <a href="#"><b>InventariAPP</b></a>
                </div>
                <!-- /.login-logo -->
                <div class="login-box-body">
                    <p class="login-box-msg">Bienvenido a InventariAPP <br> Interbank</p>

<div class="messages">
							<?php if($errors) {
								foreach ($errors as $key => $value) {
									echo '<div class="alert alert-warning" role="alert">
									<i class="glyphicon glyphicon-exclamation-sign"></i>
									'.$value.'</div>';										
									}
								} ?>
						</div>

                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="loginform">
                        <div class="form-group has-feedback">
                            <input id="username" name="username" type="text" class="form-control" placeholder="usuario">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input name="password" id="password" type="password" class="form-control" placeholder="contraseña">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <!-- para darle espacio al boton login -->
                            </div>
                            <div class="col-xs-6">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Iniciemos</button>
                            </div>
                        </div>
                    </form>

                    <!-- /.social-auth-links -->

                    <a href="#" class="text-center">Olvidaste tu contraseña</a>

                </div>
               
            </div>

            <!-- jQuery 2.2.3 -->
            <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
            <!-- Bootstrap 3.3.6 -->
            <script src="../bootstrap/js/bootstrap.min.js"></script>
            <!-- iCheck -->
            <script src="../plugins/iCheck/icheck.min.js"></script>
            <script>
                $(function() {
                    $('input').iCheck({
                        checkboxClass: 'icheckbox_square-blue',
                        radioClass: 'iradio_square-blue',
                        increaseArea: '20%' // optional
                    });
                });
            </script>
    </body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Titulo -->
    <title><?php echo $data['title']; ?></title>

    <!-- Estilos -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/plugins/bootstrap/css/bootstrap.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/plugins/perfectscroll/perfect-scrollbar.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/plugins/pace/pace.css'; ?>" rel="stylesheet">

    
    <!-- Estilos del Tema -->
    <link href="<?php echo BASE_URL . 'Assets/css/main.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/css/custom.css'; ?>" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo BASE_URL . 'Assets/images/favicon.favicon'; ?>" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo BASE_URL . 'Assets/images/favicon.ico'; ?>" />

</head>

<body>
    <div class="app app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
        <div class="app-auth-background">

        </div>
        <div class="app-auth-container">
            <div class="logo">
                <a href="index.html">Neuro</a>
            </div>
            <p class="auth-description">Bienvenido a Neuro, un Gestor de Archivos en la Nube<br>¿No tienes una cuenta? <a href="#" id="registro">Registrate</a></p>

            <form id="formulario" autocomplete="off">
                <div class="auth-credentials m-b-xxl">
                    <label for="correo" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control m-b-md" id="correo" name="correo" aria-describedby="correo" placeholder="example@neuro.com">

                    <label for="clave" class="form-label">Contraseña<span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="clave" name="clave" aria-describedby="clave" placeholder="Contraseña">
                </div>

                <div class="auth-submit">
                    <button type="submit" href="#" class="btn btn-primary">Acceder</button>
                    <a href="#" class="auth-forgot-password float-end">Olvidaste tu contraseña?</a>
                </div>
            </form>
            <div class="divider"></div>
            <div class="auth-alts">
                <a href="#" class="auth-alts-google"></a>
                <a href="#" class="auth-alts-facebook"></a>
                <a href="#" class="auth-alts-twitter"></a>
            </div>
            </form>
        </div>
    </div>
    <div id="modalRegistro" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title-Registro">Nuevo Usuario</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form id="frmRegistro" autocomplete="off">
                    <div class="modal-body">
                        <div class="input-group mb-4">
                            <span class="input-group-text"><i class="material-icons">person</i></span>
                            <input class="form-control" type="text" name="nombre" placeholder="Nombre">
                            <span class="input-group-text"><i class="material-icons">person</i></span>
                            <input class="form-control" type="text" name="apellido" placeholder="Apellido">

                        </div>
                        <div class="input-group mb-4">
                            <span class="input-group-text"><i class="material-icons">email</i></span>
                            <input class="form-control" type="text" name="correo" placeholder="Correo">
                        </div>
                        <div class="input-group mb-4">
                            <span class="input-group-text"><i class="material-icons">phone</i></span>
                            <input class="form-control" type="number" max="999999999" name="telefono" placeholder="Telefono">
                            <span class="input-group-text"><i class="material-icons">location_on</i></span>
                            <input class="form-control" type="text" name="direccion" placeholder="Ciudad">
                        
                        </div>

                        <div class="input-group">
                            <span class="input-group-text"><i class="material-icons">lock</i></span>
                            <input class="form-control" type="password" name="clave" placeholder="Contraseña">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Registrarse</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Javascripts -->
    <script src="<?php echo BASE_URL . 'Assets/plugins/jquery/jquery-3.5.1.min.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'Assets/plugins/bootstrap/js/bootstrap.min.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'Assets/plugins/perfectscroll/perfect-scrollbar.min.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'Assets/plugins/pace/pace.min.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'Assets/js/main.min.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'Assets/js/sweetalert2@11.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'Assets/js/custom.js'; ?>"></script>
    <script>
        const base_url = '<?php echo BASE_URL; ?>';
    </script>
    <script src="<?php echo BASE_URL . 'Assets/js/pages/login.js'; ?>"></script>
</body>

</html>
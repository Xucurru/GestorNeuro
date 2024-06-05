<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">

    <!-- Titulo -->
    <title><?php echo $data['title']; ?></title>

    <!-- Estilos -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">

    <link href="<?php echo BASE_URL . 'Assets/css/select2.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/plugins/bootstrap/css/bootstrap.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/plugins/perfectscroll/perfect-scrollbar.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/plugins/pace/pace.css'; ?>" rel="stylesheet">


    <!-- Estilos personalizados -->
    <link href="<?php echo BASE_URL . 'Assets/css/main.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/plugins/DataTables/datatables.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/css/custom.css'; ?>" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo BASE_URL . 'Assets/images/favicon.ico'; ?>" />

</head>
<?php
if (empty($_SESSION['nombre'])) {
    header("Location: ".BASE_URL);
    exit();
} ?>
<!DOCTYPE html>
<html lang="en">

<body>
    <div class="app align-content-stretch d-flex flex-wrap">
        <div class="app-sidebar">
            <div class="logo">
                <a href="<?php echo BASE_URL.'admin'?>" class="logo-icon"><span class="logo-text">Neuro</span></a>
                <div class="sidebar-user-switcher user-activity-online">
                    <a href="#" id="ad">
                        <img id="perfil" src="<?php echo BASE_URL . 'Assets/images/neuro.png'; ?>">
                        <span class="activity-indicator"></span>
                        <span class="user-info-text"><?php echo $_SESSION['nombre'] ?><br><span class="user-state-info"><?php echo $_SESSION['correo'] ?></span></span>
                    </a>
                </div>
            </div>
            <div class="app-menu">
                <ul class="accordion-menu">
                    <li class="sidebar-title">
                        Apps
                    </li>
                    <?php if ($_SESSION['estado'] == 2) { ?>
                        <li class="active-page">
                            <a href="<?php echo BASE_URL . 'usuarios' ?>" class="active"><i class="material-icons">person</i>Usuarios</a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo BASE_URL . 'admin' ?>"><i class="material-icons-two-tone">cloud_queue</i>Mis archivos</a>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL . 'compartidos' ?>"><i class="material-icons-two-tone">inbox</i>Compartidos<span class="badge rounded-pill badge-danger float-end"></span></a>
                    </li>

                </ul>
            </div>
        </div>
        <div class="app-container">
            <div class="search">
                <form>
                    <input class="form-control" type="text" placeholder="Busca un archivo..." aria-label="Search">
                </form>
                <a href="#" class="toggle-search"><i class="material-icons">close</i></a>
            </div>
            <div class="app-header">
                <nav class="navbar navbar-light navbar-expand-lg">
                    <div class="container-fluid">
                        <div class="navbar-nav" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-icons">first_page</i></a>
                                </li>
                                <li class="nav-item dropdown hidden-on-mobile">
                                    <a class="nav-link dropdown-toggle" href="#" id="addDropdownLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="material-icons">add</i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="d-flex">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link toggle-search" href="#"><i class="material-icons">search</i></a>
                                </li>
                                <li class="nav-item hidden-on-mobile">
                                    <a class="nav-link nav-notifications-toggle" id="notificationsDropDown" href="#" data-bs-toggle="dropdown"><span class="material-icons">person</span></a>
                                    <div class="dropdown-menu dropdown-menu-end notifications-dropdown" aria-labelledby="notificationsDropDown">
                                        <h6 class="dropdown-header">Perfil</h6>
                                        <div class="notifications-dropdown-list">
                                            <a href="#">
                                                <div class="notifications-dropdown-item">
                                                    <div class="notifications-dropdown-item-image">
                                                        <span class="notifications-badge">
                                                            <span class="material-icons">person</span>
                                                        </span>
                                                    </div>
                                                    <div class="notifications-dropdown-item-text">
                                                        <p>Mi Perfil</p>
                                                        <small>Acceder a tu cuenta</small>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="<?php echo BASE_URL . 'principal/salir' ?>">
                                                <div class="notifications-dropdown-item">
                                                    <div class="notifications-dropdown-item-image">
                                                        <span class="notifications-badge">
                                                        <span class="material-icons">logout</span>
                                                        </span>
                                                    </div>
                                                    <div class="notifications-dropdown-item-text">
                                                        <p>Cerrar Sesion</p>
                                                        <small>Salir de Neuro</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="app-content">
                <div class="content-wrapper">
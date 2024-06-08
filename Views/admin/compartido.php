<?php include_once 'Views/template/header.php'; ?>

<div class="app-content">
    <?php include_once 'Views/components/menus.php'; ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Archivos Compartidos</h1>
                        </div>
                        <div class="page-description-actions">
                            <a href="#" class="btn btn-primary" id="btnUpload"><i class="material-icons">add</i>Nueva Carpeta</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($data['archivos'] as $archivo) { ?>
                    <div class="col-md-6">
                        <div class="card file-manager-recent-item archivos" style="cursor: pointer">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <i class="material-icons-outlined text-danger align-middle m-r-sm">description</i>
                                    <a href="#" class="file-manager-recent-item-title flex-fill"><?php echo $archivo['nombre'] ?></a>
                                    <span class="p-h-sm text-muted">hace 4 dias</span>
                                    <a href="#" class="dropdown-toggle file-manager-recent-file-actions" id="file-manager-recent-1" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="file-manager-recent-1">
                                        <li class="compartido" idd="<?php echo $archivo['id_compartido'];?>" style="display: flex; align-items: center;" correo="<?php echo $archivo['correo'];?>" nombre="<?php echo $archivo['nombre'] ?>"><i class="material-icons" style="height: 24px;">person_off</i><a class="dropdown-item" href="#">Dejar de Compartir</a></li>
                                    </ul>
                                </div>
                                
                                <div>Compartido a: <span class="badge badge-info align-self-center"><?php echo $archivo['correo'];?></span></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php include_once 'Views/template/footer.php'; ?>
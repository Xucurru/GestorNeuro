<?php include_once 'Views/template/header.php'; ?>

<div class="app-content">
    <?php include_once 'Views/components/menus.php'; ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Archivos Eliminados</h1>
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
                        <div class="card file-manager-recent-item">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <i class="material-icons-outlined text-danger align-middle m-r-sm">description</i>
                                    <a href="#" class="file-manager-recent-item-title flex-fill"><?php echo $archivo['nombre'] ?></a>
                                    <span class="p-h-sm text-muted"><?php echo $archivo['fecha'] ?></span>
                                    <a href="#" class="dropdown-toggle file-manager-recent-file-actions" id="file-manager-recent-1" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="file-manager-recent-1">
                                    <li style="display: flex; align-items: center;" idr="<?php echo $archivo['id'] ?>" class="restaurar"><i class="material-icons" style="height: 24px;">history</i><a class="dropdown-item" href="#">Restaurar</a></li>
                                    <li style="display: flex; align-items: center;" ided="<?php echo $archivo['id'] ?>" nombre="<?php echo $archivo['nombre'] ?>" class="eliminarDef"><i class="material-icons" style="height: 24px;">delete</i><a class="dropdown-item" href="#">Eliminar Definitivamente</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php include_once 'Views/template/footer.php'; ?>
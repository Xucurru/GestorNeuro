<?php include_once 'Views/template/header.php'; ?>

<div class="app-content">
    <?php include_once 'Views/components/menus.php'; ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1><?php echo $data['carpeta'];?> </h1>
                        </div>
                        <div class="page-description-actions">
                            <a href="#" class="btn btn-primary" id="btnUpload"><i class="material-icons" style="margin-right: -10px;margin-left: -10px;">add</i></a>
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
                                    <span class="p-h-sm text-muted">hace 4 dias</span>
                                    <a href="#" class="dropdown-toggle file-manager-recent-file-actions" id="file-manager-recent-1" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="file-manager-recent-1">
                                        <li style="display: flex; align-items: center;"><i class="material-icons" style="height: 24px;">share</i><a class="dropdown-item compartir" href="#" id="<?php echo $archivo['id'];?>" carpeta="<?php echo $archivo['id_carpeta']?>">Compartir</a></li>
                                        <li style="display: flex; align-items: center;"><i class="material-icons" style="height: 24px;">download</i><a class="dropdown-item" href="<?php echo BASE_URL . 'Assets/archivos/'.$archivo['id_carpeta'].'/'.$archivo['nombre']?>" download="<?php echo $archivo['nombre']?>">Descargar</a></li>
                                        <li style="display: flex; align-items: center;" class="moveto" ida="<?php echo $archivo['id'] ?>" idc="<?php echo $archivo['id_carpeta'] ?>"><i class="material-icons" style="height: 24px;">drive_file_move</i><a class="dropdown-item" href="#">Mover a</a></li>
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
<?php include_once 'Views/components/modal.php'; ?>

<?php include_once 'Views/template/footer.php'; ?>
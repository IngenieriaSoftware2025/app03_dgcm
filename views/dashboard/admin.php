<?php
// views/dashboard/admin.php  (o el fichero que uses para tu dashboard)
?>
<div class="container-fluid mt-4">
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card bg-primary text-white h-100 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">Usuarios</h5>
                        <h2 class="card-text"><?= $usuariosCount ?? 0 ?></h2>
                    </div>
                    <i class="bi bi-people-fill display-4"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white h-100 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">Ventas</h5>
                        <h2 class="card-text"><?= $ventasCount ?? 0 ?></h2>
                    </div>
                    <i class="bi bi-receipt display-4"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark h-100 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">Inventario</h5>
                        <h2 class="card-text"><?= $inventarioCount ?? 0 ?></h2>
                    </div>
                    <i class="bi bi-box-seam display-4"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white h-100 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">Reparaciones</h5>
                        <h2 class="card-text"><?= $reparacionesCount ?? 0 ?></h2>
                    </div>
                    <i class="bi bi-tools display-4"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- aquí podrías añadir gráficos, tablas, últimas actividades, etc. -->
</div>
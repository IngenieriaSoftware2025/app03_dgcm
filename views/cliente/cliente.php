<div class="container-fluid p-4">
    <div class="row">
        <div class="col-12">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <h2><i class="bi bi-person-heart me-2"></i>Panel de Cliente</h2>
                    <p class="mb-0">Bienvenido, <?= $usuario['correo'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- MÓDULOS DE CLIENTE -->
    <div class="row g-4">
        <!-- MIS SERVICIOS -->
        <div class="col-md-6 col-xl-6">
            <div class="card bg-gradient-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>Mis Servicios</h5>
                            <p>Servicios contratados</p>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-bag-check fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="text-white stretched-link" href="/app03_dgcm/servicios">Ver Servicios</a>
                    <i class="bi bi-arrow-right text-white"></i>
                </div>
            </div>
        </div>

        <!-- SOPORTE -->
        <div class="col-md-6 col-xl-6">
            <div class="card bg-gradient-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>Soporte</h5>
                            <p>Solicitar ayuda técnica</p>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-headset fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="text-white stretched-link" href="/app03_dgcm/soporte">Contactar Soporte</a>
                    <i class="bi bi-arrow-right text-white"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-4">
    <div class="row text-center">
        <h3 class="mb-4">Panel de Estadísticas</h3>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-primary shadow h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary">Clientes</h5>
                    <h2 id="totalClientes">0</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-success shadow h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-success">Ventas</h5>
                    <h2 id="totalVentas">0</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-info shadow h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-info">Reparaciones</h5>
                    <h2 id="totalReparaciones">0</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-warning shadow h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-warning">Inventario</h5>
                    <h2 id="totalInventario">0</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-danger shadow h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-danger">Ingresos Ventas (Q)</h5>
                    <h2 id="ingresosVentas">0.00</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-secondary shadow h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-secondary">Ingresos Reparaciones (Q)</h5>
                    <h2 id="ingresosReparaciones">0.00</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/estadisticas/index.js') ?>"></script>
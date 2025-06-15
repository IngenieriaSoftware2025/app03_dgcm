<div class="row justify-content-center p-3">
    <div class="col-lg-12">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">
                    <i class="bi bi-graph-up"></i> Módulo de Gráficas
                </h6>
            </div>
            <div class="card-body">
                <!-- Gráfico de productos más vendidos -->
                <canvas id="miGraficoProductos" width="400" height="200"></canvas>
                <!-- Gráfico de ventas por mes -->
                <canvas id="miGraficoVentas" width="400" height="200"></canvas>
                <!-- Gráfico de clientes con más productos -->
                <canvas id="miGraficoClientes" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/graficas/index.js') ?>"></script>
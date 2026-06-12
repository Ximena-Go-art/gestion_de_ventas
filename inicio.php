<div class="container py-4">
        <h1 class="mb-4">Dashboard</h1>

        <div class="row">
            <!-- Card 1: Ventas -->
            <div class="col-md-3 mb-4">
                <div class="card border-primary h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Ventas Totales</h6>
                                <h3 class="mb-0">$ 45,231</h3>
                                <small class="text-success">
                                    <i class="fas fa-arrow-up"></i> +12.5%
                                </small>
                            </div>
                            <div class="stat-icon text-primary">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Clientes -->
            <div class="col-md-3 mb-4">
                <div class="card border-success h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Clientes</h6>
                                <h3 class="mb-0">1,234</h3>
                                <small class="text-success">
                                    <i class="fas fa-arrow-up"></i> +5.2%
                                </small>
                            </div>
                            <div class="stat-icon text-success">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Productos -->
            <div class="col-md-3 mb-4">
                <div class="card border-warning h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Productos</h6>
                                <h3 class="mb-0">567</h3>
                                <small class="text-danger">
                                    <i class="fas fa-arrow-down"></i> -3.1%
                                </small>
                            </div>
                            <div class="stat-icon text-warning">
                                <i class="fas fa-box"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4: Pedidos -->
            <div class="col-md-3 mb-4">
                <div class="card border-info h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Pedidos Pendientes</h6>
                                <h3 class="mb-0">42</h3>
                                <small class="text-warning">
                                    <i class="fas fa-clock"></i> 8 por atender
                                </small>
                            </div>
                            <div class="stat-icon text-info">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Segunda fila de cards -->
        <div class="row mt-3">
            <!-- Card con imagen -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="https://via.placeholder.com/400x200" class="card-img-top" alt="Producto destacado">
                    <div class="card-body">
                        <h5 class="card-title">Producto Destacado</h5>
                        <p class="card-text">Descripción del producto más vendido del mes.</p>
                        <a href="#" class="btn btn-primary">Ver detalles</a>
                    </div>
                </div>
            </div>

            <!-- Card con lista -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Últimas Ventas</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Producto A</span>
                                <span class="fw-bold">$1,200</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Producto B</span>
                                <span class="fw-bold">$890</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Producto C</span>
                                <span class="fw-bold">$2,300</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Card con progreso -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Meta Mensual</h5>
                        <h2 class="text-center">75%</h2>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-success" style="width: 75%">75%</div>
                        </div>
                        <p class="text-muted text-center">Faltan $25,000 para alcanzar la meta</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
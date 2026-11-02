<?php require_once __DIR__ . '/../layout/header.php'; ?>

<style>
    /* Fondo general */
    body { background-color: #f4f6f9 !important; }

    /* Tarjetas Corporativas */
    .card {
        border: 1px solid #e2e8f0 !important;
        border-radius: 6px !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02), 0 1px 2px rgba(0,0,0,0.01) !important;
        background-color: #ffffff;
    }

    /* Inputs de Filtros */
    .form-control-sm, .form-select-sm {
        border: 1px solid #cbd5e1 !important;
        border-radius: 4px !important;
        color: #1e293b !important;
        font-size: 0.85rem !important;
        background-color: #f8fafc !important;
        box-shadow: none !important;
        transition: all 0.2s ease-in-out !important;
    }
    .form-control-sm:focus, .form-select-sm:focus {
        background-color: #ffffff !important;
        border-color: #6f42c1 !important;
        box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.1) !important;
    }
    .input-group-text {
        background-color: #f8fafc !important;
        border: 1px solid #cbd5e1 !important;
        color: #94a3b8 !important;
    }

    /* Botones Superiores */
    .btn-top {
        border: 1px solid #cbd5e1 !important;
        background-color: #ffffff !important;
        color: #475569 !important;
        font-weight: 500;
        font-size: 0.82rem;
        border-radius: 4px;
        transition: background-color 0.2s;
    }
    .btn-top:hover { background-color: #f1f5f9 !important; }
    .btn-purple {
        background-color: #6f42c1 !important;
        border-color: #6f42c1 !important;
        color: #ffffff !important;
        font-weight: 600;
        border-radius: 4px;
    }
    .btn-purple:hover { background-color: #59339d !important; }

    /* Tabla Premium */
    .table > thead { background-color: #f8fafc; }
    .table > thead > tr > th {
        font-size: 0.70rem !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b !important;
        border-bottom: 1px solid #e2e8f0 !important;
        border-top: 1px solid #e2e8f0 !important;
        padding: 0.85rem 0.5rem;
        white-space: nowrap;
    }
    .table > tbody > tr > td {
        font-size: 0.82rem;
        color: #334155;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        padding: 0.75rem 0.5rem;
    }
    .table > tbody > tr:hover { background-color: #f8fafc; }

    /* Badges (Etiquetas) Soft */
    .badge-frio { background-color: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd; }
    .badge-tibio { background-color: #fef3c7; color: #d97706; border: 1px solid #fde68a; }
    .badge-caliente { background-color: #fee2e2; color: #dc2626; border: 1px solid #fecaca; }
    .badge-mql { background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }

    /* Modal Styling */
    .modal-title-custom { font-size: 0.9rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #3b2853; }
    .form-label-modal { font-size: 0.75rem !important; font-weight: 700 !important; text-transform: uppercase; color: #64748b !important; margin-bottom: 0.25rem !important; }
    
    .sort-icon { font-size: 0.6rem; color: #cbd5e1; margin-left: 2px; }
</style>

<!-- Cabecera y Botones -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0 text-dark">Leads</h5>
    <div class="d-flex gap-2">
        <button class="btn btn-top btn-sm px-3"><span class="text-muted">+ Leads hoy:</span> <strong class="text-dark ms-1">0</strong></button>
        <button class="btn btn-top btn-sm px-3"><i class="bi bi-telephone text-muted me-1"></i> <span class="text-muted">Gestiones hoy:</span> <strong class="text-dark ms-1">0</strong></button>
        <button class="btn btn-top btn-sm px-3"><i class="bi bi-download text-muted me-1"></i> Exportar Excel</button>
        <a href="/crm_callcenter/public/leads/create" class="btn btn-purple btn-sm px-3"><i class="bi bi-plus-lg me-1"></i> Nuevo Lead</a>
    </div>
</div>

<!-- Tarjeta de Filtros -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form action="/crm_callcenter/public/leads" method="GET" id="formFiltros" class="m-0">
            <!-- Barra de búsqueda superior -->
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="busqueda" class="form-control border-start-0 ps-0 form-control-sm" placeholder="Buscar por nombre, teléfono o email..." value="<?php echo htmlspecialchars($data['filtros']['busqueda']); ?>">
                </div>
            </div>
            
            <!-- Controles de filtrado -->
            <div class="row g-2 align-items-center">
                <div class="col-md-3">
                    <select name="temperatura" class="form-select form-select-sm" onchange="document.getElementById('formFiltros').submit();">
                        <option value="Todas" <?php echo $data['filtros']['temperatura'] == 'Todas' ? 'selected' : ''; ?>>Todas las temperaturas</option>
                        <option value="frio" <?php echo $data['filtros']['temperatura'] == 'frio' ? 'selected' : ''; ?>>Frío</option>
                        <option value="tibio" <?php echo $data['filtros']['temperatura'] == 'tibio' ? 'selected' : ''; ?>>Tibio</option>
                        <option value="caliente" <?php echo $data['filtros']['temperatura'] == 'caliente' ? 'selected' : ''; ?>>Caliente</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="mql" class="form-select form-select-sm" onchange="document.getElementById('formFiltros').submit();">
                        <option value="Todos">Todos los MQL</option>
                        <?php foreach($data['catalogos']['mqls'] as $m): ?>
                            <option value="<?php echo $m['id']; ?>" <?php echo $data['filtros']['mql'] == $m['id'] ? 'selected' : ''; ?>><?php echo $m['nivel']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-1 d-flex gap-2">
                    <button type="submit" class="btn btn-top btn-sm w-100">Filtrar</button>
                    <a href="/crm_callcenter/public/leads" class="btn btn-sm btn-link text-muted text-decoration-none w-100" style="font-size: 0.82rem;">Limpiar</a>
                </div>
                
                <!-- Rango de Fechas alineado a la derecha -->
                <div class="col-md-6 d-flex align-items-center justify-content-end gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted small fw-medium">Desde</span>
                        <input type="date" class="form-control form-control-sm text-muted" style="width: 130px;">
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted small fw-medium">Hasta</span>
                        <input type="date" class="form-control form-control-sm text-muted" style="width: 130px;">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tabla Principal -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Fecha Lead <i class="bi bi-caret-down-fill sort-icon"></i></th>
                        <th>Nombre <i class="bi bi-caret-down-fill sort-icon"></i></th>
                        <th>Teléfono <i class="bi bi-caret-down-fill sort-icon"></i></th>
                        <th>Empresa</th>
                        <th>Campaña</th>
                        <th>Canal</th>
                        <th class="text-center">MQL <i class="bi bi-caret-down-fill sort-icon"></i></th>
                        <th class="text-center">Último Estado <i class="bi bi-caret-down-fill sort-icon"></i></th>
                        <th>Agente <i class="bi bi-caret-down-fill sort-icon"></i></th>
                        <th class="text-center">Derivado <i class="bi bi-caret-down-fill sort-icon"></i></th>
                        <th class="text-center pe-4">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($data['leads'])): ?>
                        <tr>
                            <td colspan="11" class="text-center py-5">
                                <i class="bi bi-inbox text-muted opacity-50 mb-2 d-block" style="font-size: 2rem;"></i>
                                <span class="text-muted small">No se encontraron leads con los filtros actuales.</span>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($data['leads'] as $lead): ?>
                            <tr>
                                <td class="ps-4 text-muted small"><?php echo date('Y-m-d', strtotime($lead['fecha_lead'])); ?></td>
                                <td class="fw-bold text-dark"><?php echo $lead['nombre']; ?></td>
                                <td class="text-muted"><?php echo $lead['telefono'] ?? '—'; ?></td>
                                <td class="text-muted small"><?php echo $lead['empresa'] ?? '—'; ?></td>
                                
                                <td class="text-muted small text-truncate" style="max-width: 150px;" title="<?php echo $lead['campana'] ?? ''; ?>">
                                    <?php if(!empty($lead['campana'])): ?>
                                        <i class="bi bi-megaphone-fill opacity-50 me-1" style="font-size:0.7rem;"></i> <?php echo $lead['campana']; ?>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>
                                
                                <td class="text-muted small"><?php echo $lead['canal'] ?? '—'; ?></td>
                                
                                <td class="text-center">
                                    <?php if($lead['mql']): ?>
                                        <span class="badge badge-mql rounded-pill px-3 py-1 fw-medium"><?php echo $lead['mql']; ?></span>
                                    <?php else: ?><span class="text-muted small">—</span><?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php 
                                        $badgeClass = 'badge-frio';
                                        if($lead['temperatura'] == 'tibio') { $badgeClass = 'badge-tibio'; }
                                        if($lead['temperatura'] == 'caliente') { $badgeClass = 'badge-caliente'; }
                                    ?>
                                    <span class="badge <?php echo $badgeClass; ?> rounded-pill px-3 py-1 fw-medium" style="text-transform: capitalize;">
                                        <?php echo $lead['temperatura']; ?>
                                    </span>
                                </td>
                                
                                <td class="text-muted small">
                                    <?php echo $lead['agente'] ?? '<span class="fst-italic opacity-50">Sin asignar</span>'; ?>
                                </td>
                                
                                <td class="text-center">
                                    <?php if($lead['derivado_ventas']): ?>
                                        <span class="badge bg-success rounded-pill px-2 py-1" style="font-size: 0.65rem;">Sí</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger rounded-pill px-2 py-1" style="font-size: 0.65rem;">No</span>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="pe-4">
                                    <div class="d-flex justify-content-center gap-2">
                                        <!-- Botón Llamar -->
                                        <button class="btn btn-outline-success btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; border-color: #bbf7d0;" data-bs-toggle="modal" data-bs-target="#modalSeguimiento" onclick="document.getElementById('lead_id_modal').value = <?php echo $lead['id']; ?>;" title="Registrar Llamada">
                                            <i class="bi bi-telephone"></i>
                                        </button>
                                        <!-- Botón Editar -->
                                        <!-- Botón Editar Lead -->
<a href="/crm_callcenter/public/leads/edit/<?php echo $lead['id']; ?>" class="btn btn-sm btn-outline-primary px-2 py-1" title="Editar Lead">
    <i class="bi bi-pencil"></i>
</a>
                                        <!-- Botón Eliminar -->
                                        <form action="/crm_callcenter/public/leads/delete/<?php echo $lead['id']; ?>" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar permanentemente este Lead?');" class="m-0 p-0">
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; border-color: #fecaca;" title="Eliminar Lead">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- ========================================== -->
<!-- PAGINACIÓN Y CONTADOR DE REGISTROS         -->
<!-- ========================================== -->
<div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top" style="background-color: #ffffff; padding: 15px 20px; border-radius: 0 0 6px 6px;">
    
    <!-- Texto de registros (Izquierda) -->
    <div class="text-muted" style="font-size: 0.85rem;">
        <?php 
            $totalLeads = count($data['leads'] ?? []);
            echo "Mostrando 1 a {$totalLeads} de {$totalLeads} registros"; 
        ?>
    </div>

    <!-- Botones de paginación (Derecha) -->
    <nav aria-label="Navegación de leads">
        <ul class="pagination pagination-sm mb-0">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true" style="background-color: #f1f5f9; color: #64748b; border-color: #e2e8f0;">
                    Anterior
                </a>
            </li>
            <li class="page-item active" aria-current="page">
                <a class="page-link" href="#" style="background-color: #0d6efd; border-color: #0d6efd;">
                    1
                </a>
            </li>
            <li class="page-item disabled">
                <a class="page-link" href="#" style="background-color: #f1f5f9; color: #64748b; border-color: #e2e8f0;">
                    Siguiente
                </a>
            </li>
        </ul>
    </nav>
</div>
        </div>
    </div>
</div>

<!-- MODAL PARA REGISTRO DE LLAMADAS (SEGUIMIENTO) -->
<div class="modal fade" id="modalSeguimiento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 8px;">
            <div class="modal-header bg-light border-bottom-0 pb-3 pt-3">
                <h6 class="modal-title-custom mb-0"><i class="bi bi-headset me-2 text-primary"></i> Registro de Gestión</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/crm_callcenter/public/leads/guardarSeguimiento" method="POST">
                <div class="modal-body pt-2 px-4 pb-4">
                    <input type="hidden" name="lead_id" id="lead_id_modal">
                    
                    <div class="mb-3">
                        <label class="form-label-modal">Resultado de la llamada <span class="text-danger">*</span></label>
                        <select name="estado" class="form-select form-select-sm" required>
                            <option value="">— Seleccionar estado —</option>
                            <option value="Contestó">📞 Contestó - Interesado</option>
                            <option value="No contestó">📵 No contestó</option>
                            <option value="Número equivocado">❌ Número equivocado</option>
                            <option value="Volver a llamar">⏳ Volver a llamar luego</option>
                            <option value="No interesado">⛔ No interesado</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label-modal">Actualizar Temperatura (Opcional)</label>
                        <select name="temperatura" class="form-select form-select-sm">
                            <option value="">— Mantener actual —</option>
                            <option value="frio">❄️ Cambiar a Frío</option>
                            <option value="tibio">🔥 Cambiar a Tibio</option>
                            <option value="caliente">🌶️ Cambiar a Caliente</option>
                        </select>
                    </div>

                    <div class="mb-1">
                        <label class="form-label-modal">Detalles de la gestión <span class="text-danger">*</span></label>
                        <textarea name="comentario" class="form-control form-control-sm" rows="3" required placeholder="Escribe un resumen de lo hablado con el cliente..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top-0 py-2 px-4">
                    <button type="button" class="btn btn-sm btn-top px-3" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-purple px-4">Guardar Seguimiento</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
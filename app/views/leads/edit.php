<?php require_once __DIR__ . '/../layout/header.php'; ?>

<!-- Estilos corporativos -->
<style>
    body { background-color: #f4f6f9 !important; }
    .card { border: 1px solid #e2e8f0 !important; border-radius: 6px !important; box-shadow: 0 2px 4px rgba(0,0,0,0.02), 0 1px 2px rgba(0,0,0,0.01) !important; background-color: #ffffff; }
    .section-title { font-size: 0.75rem; font-weight: 700; color: #3b2853; text-transform: uppercase; letter-spacing: 0.8px; border-bottom: 1px solid #e5e7eb; padding-bottom: 0.5rem; margin-bottom: 1.25rem; margin-top: 1.5rem; }
    .section-title:first-child { margin-top: 0; }
    .form-label { font-size: 0.70rem !important; font-weight: 700 !important; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b !important; margin-bottom: 0.25rem !important; }
    .form-control-sm, .form-select-sm, textarea.form-control { border: 1px solid #cbd5e1 !important; border-radius: 4px !important; color: #1e293b !important; font-size: 0.85rem !important; padding: 0.45rem 0.75rem !important; background-color: #f8fafc !important; box-shadow: none !important; transition: all 0.2s ease-in-out !important; }
    .form-control-sm:focus, .form-select-sm:focus, textarea.form-control:focus { background-color: #ffffff !important; border-color: #6f42c1 !important; box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.1) !important; }
    .form-switch .form-check-input { width: 2.3em !important; height: 1.15em !important; background-color: #ffffff; border: 1.5px solid #cbd5e1 !important; cursor: pointer; transition: all 0.2s ease-in-out; }
    .form-switch .form-check-input:checked { background-color: #3b82f6 !important; border-color: #3b82f6 !important; }
    .form-switch .form-check-input:focus { border-color: #3b82f6 !important; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important; }
    .switch-container { border: 1px solid #e2e8f0 !important; background-color: #f8fafc !important; }
    .btn { border-radius: 4px !important; font-size: 0.85rem !important; font-weight: 600 !important; letter-spacing: 0.3px; }
    .btn-derivar { background-color: #ed8030 !important; border-color: #ed8030 !important; text-transform: uppercase; letter-spacing: 1px !important; }
    .btn-derivar:hover { background-color: #d86d23 !important; }
    .btn-primary { background-color: #6f42c1 !important; border-color: #6f42c1 !important; }
    .btn-primary:hover { background-color: #59339d !important; border-color: #59339d !important; }
    @keyframes shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-4px); } 75% { transform: translateX(4px); } }
    .input-error { animation: shake 0.3s ease-in-out; border-color: #6f42c1 !important; box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.15) !important; }
    .corporate-tooltip .tooltip-inner { background-color: #3b2853 !important; color: #ffffff !important; font-size: 0.80rem; font-weight: 500; padding: 0.5rem 0.75rem; border-radius: 4px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
    .corporate-tooltip .tooltip-arrow::before { border-top-color: #3b2853 !important; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-normal text-dark d-flex align-items-center" style="font-size: 1.35rem;">
        <i class="bi bi-pencil-square me-2"></i> Editar lead
    </h4>
    <a href="/crm_callcenter/public/leads" class="btn btn-sm px-3" style="background-color: #ffffff; border: 1px solid #ced4da; color: #495057; font-weight: 500;">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="row">
    <div class="col-lg-8 col-md-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="/crm_callcenter/public/leads/update/<?php echo $data['lead']['id']; ?>" method="POST">
                    
                    <!-- BLOQUE 1: DATOS DEL CONTACTO -->
                    <div class="section-title">Información del Contacto</div>
                    <div class="row g-3 mb-2">
                        <div class="col-md-4">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control form-control-sm" required value="<?php echo htmlspecialchars($data['lead']['nombre'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 position-relative">
                            <label class="form-label">País de Origen</label>
                            <select name="pais_id" id="pais_id" class="form-select form-select-sm text-muted">
                                <option value="">— Seleccionar —</option>
                                <?php foreach($data['catalogos']['paises'] as $p): ?>
                                    <option value="<?php echo $p['id']; ?>" <?php echo (isset($data['lead']['pais_id']) && $data['lead']['pais_id'] == $p['id']) ? 'selected' : ''; ?>><?php echo $p['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 position-relative">
                            <label class="form-label">Ciudad</label>
                            <!-- AJAX lo llenará, pero guardamos el ID actual para autoseleccionarlo vía JS -->
                            <select name="ciudad_id" id="ciudad_id" class="form-select form-select-sm text-muted" data-selected="<?php echo $data['lead']['ciudad_id'] ?? ''; ?>">
                                <option value="">— Seleccionar —</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control form-control-sm" value="<?php echo htmlspecialchars($data['lead']['email'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Teléfono <span class="text-danger">*</span></label>
                            <input type="text" name="telefono" id="inputTelefono" class="form-control form-control-sm" required value="<?php echo htmlspecialchars($data['lead']['telefono'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Fecha de Ingreso</label>
                            <input type="date" name="fecha_lead" class="form-control form-control-sm text-muted" value="<?php echo $data['lead']['fecha_lead'] ?? ''; ?>">
                        </div>
                    </div>

                    <!-- BLOQUE 2: CLASIFICACIÓN COMERCIAL -->
                    <div class="section-title">2. Clasificación Comercial</div>
                    <div class="row g-3 mb-2">
                        <div class="col-md-4">
                            <label class="form-label">Empresa</label>
                            <select name="empresa_id" id="empresa_id" class="form-select form-select-sm text-muted">
                                <option value="">— Seleccionar —</option>
                                <?php foreach($data['catalogos']['empresas'] as $e): ?>
                                    <option value="<?php echo $e['id']; ?>" <?php echo (isset($data['lead']['empresa_id']) && $data['lead']['empresa_id'] == $e['id']) ? 'selected' : ''; ?>><?php echo $e['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Campaña</label>
                            <select name="campana_id" id="campana_id" class="form-select form-select-sm text-muted" data-selected="<?php echo $data['lead']['campana_id'] ?? ''; ?>">
                                <option value="">— Seleccionar —</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Proyecto</label>
                            <select name="proyecto_id" id="proyecto_id" class="form-select form-select-sm text-muted" data-selected="<?php echo $data['lead']['proyecto_id'] ?? ''; ?>">
                                <option value="">— Seleccionar —</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Canal de Captación</label>
                            <select name="canal_id" class="form-select form-select-sm text-muted">
                                <option value="">— Seleccionar —</option>
                                <?php foreach($data['catalogos']['canales'] as $c): ?>
                                    <option value="<?php echo $c['id']; ?>" <?php echo (isset($data['lead']['canal_id']) && $data['lead']['canal_id'] == $c['id']) ? 'selected' : ''; ?>><?php echo $c['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nivel de Interés (MQL)</label>
                            <select name="mql_id" class="form-select form-select-sm text-muted">
                                <option value="">— Seleccionar —</option>
                                <?php foreach($data['catalogos']['mqls'] as $m): ?>
                                    <option value="<?php echo $m['id']; ?>" <?php echo (isset($data['lead']['mql_id']) && $data['lead']['mql_id'] == $m['id']) ? 'selected' : ''; ?>><?php echo $m['nivel']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Temperatura</label>
                            <select name="temperatura" class="form-select form-select-sm text-muted">
                                <option value="frio" <?php echo (isset($data['lead']['temperatura']) && $data['lead']['temperatura'] == 'frio') ? 'selected' : ''; ?>>Frío</option>
                                <option value="tibio" <?php echo (isset($data['lead']['temperatura']) && $data['lead']['temperatura'] == 'tibio') ? 'selected' : ''; ?>>Tibio</option>
                                <option value="caliente" <?php echo (isset($data['lead']['temperatura']) && $data['lead']['temperatura'] == 'caliente') ? 'selected' : ''; ?>>Caliente</option>
                            </select>
                        </div>
                    </div>

                    <!-- BLOQUE 3: GESTIÓN Y ASIGNACIÓN -->
                    <div class="section-title">3. Gestión de Ventas</div>
                    <div class="row g-3 mb-3 align-items-center">
                        <div class="col-md-4">
                            <label class="form-label">Condición de Pago</label>
                            <select name="tipo_pago" class="form-select form-select-sm text-muted">
                                <option value="">— Seleccionar —</option>
                                <option value="Contado" <?php echo (isset($data['lead']['tipo_pago']) && $data['lead']['tipo_pago'] == 'Contado') ? 'selected' : ''; ?>>Al Contado</option>
                                <option value="Plazo" <?php echo (isset($data['lead']['tipo_pago']) && $data['lead']['tipo_pago'] == 'Plazo') ? 'selected' : ''; ?>>A Plazo</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Agente Responsable <span class="text-danger">*</span></label>
                            <select name="agente_id" class="form-select form-select-sm text-muted" required>
                                <option value="">— Asignar Agente —</option>
                                <?php foreach($data['catalogos']['agentes'] as $a): ?>
                                    <option value="<?php echo $a['id']; ?>" <?php echo (isset($data['lead']['agente_id']) && $data['lead']['agente_id'] == $a['id']) ? 'selected' : ''; ?>><?php echo $a['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 h-100">
                            <label class="form-label d-block text-transparent">&nbsp;</label>
                            <div class="border rounded-2 p-2 px-3 switch-container d-flex flex-column justify-content-center h-100 mt-n1">
                                <div class="form-check form-switch d-flex align-items-center gap-2 mb-1">
                                    <input class="form-check-input mt-0" type="checkbox" role="switch" name="se_envio_mensaje" id="switchMensaje" <?php echo (!empty($data['lead']['se_envio_mensaje'])) ? 'checked' : ''; ?> style="cursor:pointer; transform: scale(1.15); margin-left: 0;">
                                    <label class="form-check-label fw-bold text-dark ms-1" for="switchMensaje" style="cursor:pointer; font-size: 0.85rem;">Se envió mensaje</label>
                                </div>
                                <div class="text-muted" style="font-size: 0.72rem; line-height: 1.25; margin-top: 2px;">
                                    Marca si ya se envió un mensaje al lead (cuenta como 1 seguimiento)
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Comentarios / Observaciones</label>
                        <textarea name="comentario" class="form-control" rows="3" placeholder="Añade detalles relevantes sobre lo que busca el prospecto..."><?php echo htmlspecialchars($data['lead']['comentario'] ?? ''); ?></textarea>
                    </div>

                    <!-- Botón Guardar -->
                    <div class="border-top pt-3 text-end">
                        <button type="submit" class="btn btn-primary px-4 py-2 text-white">
                            <i class="bi bi-save me-1"></i> Actualizar Registro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- COLUMNA DERECHA: Derivación y Seguimientos (ACTUALIZADA) -->
    <div class="col-lg-4 col-md-12">
        
        <?php 
            // 1. Detectar si el lead está derivado
            $isDerivado = isset($data['lead']['derivado_ventas']) && $data['lead']['derivado_ventas'] == 1; 
            
            // 2. Buscar el nombre del vendedor asignado para el cuadro verde
            $vendedorActualNombre = 'Vendedor no encontrado';
            if ($isDerivado && !empty($data['lead']['vendedor_id'])) {
                foreach ($data['catalogos']['vendedores'] as $v) {
                    if ($v['id'] == $data['lead']['vendedor_id']) {
                        $vendedorActualNombre = $v['nombre'];
                        break;
                    }
                }
            }
        ?>

        <!-- Panel Derivación -->
        <div class="card shadow-sm mb-3" style="border: 1px solid #f1c40f; border-radius: 6px;">
            <div class="card-header fw-bold" style="background-color: #fdf5e6; border-bottom: 1px solid #f1c40f; font-size: 0.85rem; color: #333;">
                <?php echo $isDerivado ? 'Reasignar vendedor' : 'Derivar a ventas'; ?>
            </div>
            
            <div class="card-body p-3">
                <form action="/crm_callcenter/public/leads/derivar/<?php echo $data['lead']['id']; ?>" method="POST">
                    
                    <?php if($isDerivado): ?>
                        <!-- Cuadro Verde de Éxito -->
                        <div class="alert mb-3 d-flex align-items-center p-2" style="background-color: #d1e7dd; border: 1px solid #badbcc; color: #0f5132; font-size: 0.85rem; border-radius: 4px;">
                            <i class="bi bi-check-circle me-2"></i>
                            <span>Derivado a: <strong><?php echo htmlspecialchars($vendedorActualNombre); ?></strong></span>
                        </div>
                    <?php endif; ?>

                    <select name="vendedor_id" class="form-select form-select-sm mb-3" required>
                        <option value="">— Seleccionar vendedor —</option>
                        <?php 
                            // Usamos un array para bloquear duplicados que vengan de la base de datos
                            $vendedores_impresos = [];
                            
                            foreach($data['catalogos']['vendedores'] as $v): 
                                // Si el ID del vendedor no se ha impreso aún, lo mostramos
                                if(!in_array($v['id'], $vendedores_impresos)):
                                    $vendedores_impresos[] = $v['id'];
                                    
                                    // Verificamos si es el vendedor asignado actualmente para marcarlo como 'selected'
                                    $seleccionado = ($isDerivado && isset($data['lead']['vendedor_id']) && $data['lead']['vendedor_id'] == $v['id']) ? 'selected' : '';
                        ?>
                                    <option value="<?php echo $v['id']; ?>" <?php echo $seleccionado; ?>>
                                        <?php echo htmlspecialchars($v['nombre']); ?>
                                    </option>
                        <?php 
                                endif;
                            endforeach; 
                        ?>
                    </select>

                    <button type="submit" class="btn w-100 py-2 fw-bold" style="background-color: #ffc107; border: none; color: #000; font-size: 0.85rem;">
                        <i class="bi bi-send me-1"></i> <?php echo $isDerivado ? 'Reasignar' : 'Derivar'; ?>
                    </button>
                </form>
            </div>
        </div>

        <!-- Panel Seguimientos (Desplegable Acordeón) -->
        <div class="card shadow-sm" style="border: 1px solid #e2e8f0; border-radius: 6px;">
            
            <!-- Cabecera siempre visible -->
            <div class="card-header bg-white d-flex justify-content-between align-items-center p-3" style="border-bottom: 1px solid #e2e8f0;">
                <span class="fw-bold text-dark" style="font-size: 0.85rem;">
                    Seguimientos <span class="badge bg-secondary ms-1">0/7</span>
                </span>
                <!-- Botón que activa el colapso apuntando al ID #formSeguimiento -->
                <button type="button" class="btn btn-primary btn-sm px-3" style="font-size: 0.8rem; background-color: #0d6efd; border-color: #0d6efd;" data-bs-toggle="collapse" data-bs-target="#formSeguimiento" aria-expanded="false" aria-controls="formSeguimiento">
                    <i class="bi bi-plus"></i> Agregar
                </button>
            </div>
            
            <!-- Cuerpo del formulario oculto por defecto (clase collapse) -->
            <div class="collapse" id="formSeguimiento">
                <div class="card-body p-3">
                    <form action="/crm_callcenter/public/leads/guardarSeguimiento" method="POST">
                        <input type="hidden" name="lead_id" value="<?php echo $data['lead']['id']; ?>">

                        <div class="mb-3">
                            <label class="form-label" style="font-size: 0.8rem; color: #333; text-transform: none; font-weight: normal;">Estado</label>
                            <select name="estado" class="form-select form-select-sm" required>
                                <option value="contesto">contesto</option>
                                <option value="no_contesto">no contesto</option>
                                <option value="interesado">interesado</option>
                                <option value="no_interesado">no interesado</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-size: 0.8rem; color: #333; text-transform: none; font-weight: normal;">Comentario</label>
                            <textarea name="comentario" class="form-control form-control-sm" rows="3" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" style="font-size: 0.8rem; color: #333; text-transform: none; font-weight: normal;">Próximo contacto</label>
                            <input type="datetime-local" name="proximo_contacto" class="form-control form-control-sm">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2" style="font-size: 0.85rem; font-weight: 500;">
                            Guardar seguimiento
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputTelefono = document.getElementById('inputTelefono');
    const paisSelect = document.getElementById('pais_id');
    const ciudadSelect = document.getElementById('ciudad_id');
    
    const empresaSelect = document.getElementById('empresa_id');
    const campanaSelect = document.getElementById('campana_id');
    const proyectoSelect = document.getElementById('proyecto_id');

    const countryCodes = {
        '1': '+591 ', '2': '+54 ', '3': '+56 ', '4': '+51 ', '5': '+57 ',
        '6': '+52 ', '7': '+593 ', '8': '+598 ', '9': '+595 ', '10': '+34 ', '11': '+1 '
    };

    function showCorporateTooltip(element, message) { /* Tooltip omitido por simplicidad */ }

    // --- LÓGICA AJAX PARA CIUDADES ---
    function fetchCiudades(paisId, preselectedId = null) {
        if(!paisId) {
            ciudadSelect.innerHTML = '<option value="">— Seleccionar —</option>';
            return;
        }
        ciudadSelect.innerHTML = '<option value="">— Cargando datos... —</option>';
        fetch(`/crm_callcenter/public/leads/getCiudades/${paisId}`)
            .then(response => response.json())
            .then(data => {
                ciudadSelect.innerHTML = '<option value="">— Seleccionar —</option>';
                data.forEach(ciudad => {
                    let selected = (preselectedId && preselectedId == ciudad.id) ? 'selected' : '';
                    ciudadSelect.innerHTML += `<option value="${ciudad.id}" ${selected}>${ciudad.nombre}</option>`;
                });
            })
            .catch(error => console.error('Error fetching ciudades:', error));
    }

    // --- LÓGICA AJAX PARA CAMPAÑAS Y PROYECTOS ---
    function fetchCampanasYProyectos(empresaId, preCampana = null, preProyecto = null) {
        if(!empresaId) {
            if(campanaSelect) campanaSelect.innerHTML = '<option value="">— Seleccionar —</option>';
            if(proyectoSelect) proyectoSelect.innerHTML = '<option value="">— Seleccionar —</option>';
            return;
        }
        if(campanaSelect) campanaSelect.innerHTML = '<option value="">— Cargando datos... —</option>';
        if(proyectoSelect) proyectoSelect.innerHTML = '<option value="">— Cargando datos... —</option>';

        if(campanaSelect) {
            fetch(`/crm_callcenter/public/leads/getCampanas/${empresaId}`)
                .then(response => response.json())
                .then(data => {
                    campanaSelect.innerHTML = '<option value="">— Seleccionar —</option>';
                    data.forEach(campana => {
                        let selected = (preCampana && preCampana == campana.id) ? 'selected' : '';
                        campanaSelect.innerHTML += `<option value="${campana.id}" ${selected}>${campana.nombre}</option>`;
                    });
                })
                .catch(error => console.error('Error fetching campanas:', error));
        }
        
        if(proyectoSelect) {
            fetch(`/crm_callcenter/public/leads/getProyectos/${empresaId}`)
                .then(response => response.json())
                .then(data => {
                    proyectoSelect.innerHTML = '<option value="">— Seleccionar —</option>';
                    data.forEach(proyecto => {
                        let selected = (preProyecto && preProyecto == proyecto.id) ? 'selected' : '';
                        proyectoSelect.innerHTML += `<option value="${proyecto.id}" ${selected}>${proyecto.nombre}</option>`;
                    });
                })
                .catch(error => console.error('Error fetching proyectos:', error));
        }
    }

    // --- EVENTOS ONCHANGE ---
    if(paisSelect) {
        paisSelect.addEventListener('change', function() {
            const paisId = this.value;
            if(paisId && countryCodes[paisId]) {
                let currentPhone = inputTelefono.value;
                if(currentPhone.trim() === '') {
                    inputTelefono.value = countryCodes[paisId];
                } else {
                    let newPhone = currentPhone.replace(/^\+\d+\s?/, '');
                    inputTelefono.value = countryCodes[paisId] + newPhone;
                }
            } else if (!paisId && /^\+\d+\s?$/.test(inputTelefono.value)) {
                 inputTelefono.value = '';
            }
            fetchCiudades(paisId);
        });
    }

    if(empresaSelect) {
        empresaSelect.addEventListener('change', function() {
            fetchCampanasYProyectos(this.value);
        });
    }

    // --- AUTOCARGA INICIAL ---
    if(paisSelect && paisSelect.value) {
        fetchCiudades(paisSelect.value, ciudadSelect.getAttribute('data-selected'));
    }
    if(empresaSelect && empresaSelect.value) {
        fetchCampanasYProyectos(
            empresaSelect.value, 
            campanaSelect.getAttribute('data-selected'), 
            proyectoSelect.getAttribute('data-selected')
        );
    }
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
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

    /* Subtítulos de Sección (Look Empresarial) */
    .section-title {
        font-size: 0.75rem;
        font-weight: 700;
        color: #3b2853; 
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 0.5rem;
        margin-bottom: 1.25rem;
        margin-top: 1.5rem;
    }
    .section-title:first-child { margin-top: 0; }

    /* Etiquetas Técnicas */
    .form-label {
        font-size: 0.70rem !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b !important;
        margin-bottom: 0.25rem !important;
    }

    /* Inputs corporativos */
    .form-control-sm, .form-select-sm, textarea.form-control {
        border: 1px solid #cbd5e1 !important;
        border-radius: 4px !important;
        color: #1e293b !important;
        font-size: 0.85rem !important;
        padding: 0.45rem 0.75rem !important;
        background-color: #f8fafc !important;
        box-shadow: none !important;
        transition: all 0.2s ease-in-out !important;
    }
    .form-control-sm:focus, .form-select-sm:focus, textarea.form-control:focus {
        background-color: #ffffff !important;
        border-color: #6f42c1 !important;
        box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.1) !important;
    }

    /* Interruptor */
    .form-switch .form-check-input {
        width: 2.3em !important;
        height: 1.15em !important;
        background-color: #ffffff;
        border: 1.5px solid #cbd5e1 !important;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }
    .form-switch .form-check-input:checked {
        background-color: #3b82f6 !important; /* Azul suave e inteligente */
        border-color: #3b82f6 !important;
    }
    .form-switch .form-check-input:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
    }
    .switch-container {
        border: 1px solid #e2e8f0 !important;
        background-color: #f8fafc !important;
    }

    /* Botones */
    .btn {
        border-radius: 4px !important;
        font-size: 0.85rem !important;
        font-weight: 600 !important;
        letter-spacing: 0.3px;
    }
    .btn-derivar {
        background-color: #ed8030 !important;
        border-color: #ed8030 !important;
        text-transform: uppercase;
        letter-spacing: 1px !important;
    }
    .btn-derivar:hover { background-color: #d86d23 !important; }
    .btn-primary { background-color: #6f42c1 !important; border-color: #6f42c1 !important; }
    .btn-primary:hover { background-color: #59339d !important; border-color: #59339d !important; }
    
    /* Animación para el shake de error sutil */
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-4px); }
        75% { transform: translateX(4px); }
    }
    .input-error {
        animation: shake 0.3s ease-in-out;
        border-color: #6f42c1 !important;
        box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.15) !important;
    }
    
    /* Tooltip Corporativo */
    .corporate-tooltip .tooltip-inner {
        background-color: #3b2853 !important;
        color: #ffffff !important;
        font-size: 0.80rem;
        font-weight: 500;
        padding: 0.5rem 0.75rem;
        border-radius: 4px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .corporate-tooltip .tooltip-arrow::before {
        border-top-color: #3b2853 !important;
    }
</style>

<!-- Título y botón volver -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0 fw-bold text-dark">Crear Nuevo Lead</h5>
    <a href="/crm_callcenter/public/leads" class="btn btn-outline-secondary btn-sm px-3 bg-white">
        <i class="bi bi-arrow-left"></i> Volver a la lista
    </a>
</div>

<div class="row">
    <!-- COLUMNA IZQUIERDA: Formulario Principal -->
    <div class="col-lg-8 col-md-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="/crm_callcenter/public/leads/store" method="POST">
                    
                    <!-- BLOQUE 1: DATOS DEL CONTACTO -->
                    <div class="section-title">1. Información del Contacto</div>
                    <div class="row g-3 mb-2">
                        <div class="col-md-4">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-4 position-relative">
                            <label class="form-label">País de Origen</label>
                            <select name="pais_id" id="pais_id" class="form-select form-select-sm text-muted">
                                <option value="">— Seleccionar —</option>
                                <?php foreach($data['catalogos']['paises'] as $p): ?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 position-relative">
                            <label class="form-label">Ciudad</label>
                            <select name="ciudad_id" id="ciudad_id" class="form-select form-select-sm text-muted">
                                <option value="">— Seleccionar —</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Teléfono <span class="text-danger">*</span></label>
                            <input type="text" name="telefono" id="inputTelefono" class="form-control form-control-sm" required placeholder="+591 ">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Fecha de Ingreso</label>
                            <input type="date" name="fecha_lead" class="form-control form-control-sm text-muted" value="<?php echo date('Y-m-d'); ?>">
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
                                    <option value="<?php echo $e['id']; ?>"><?php echo $e['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Campaña</label>
                            <select name="campana_id" id="campana_id" class="form-select form-select-sm text-muted">
                                <option value="">— Seleccionar —</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Proyecto</label>
                            <select name="proyecto_id" id="proyecto_id" class="form-select form-select-sm text-muted">
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
                                    <option value="<?php echo $c['id']; ?>"><?php echo $c['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nivel de Interés (MQL)</label>
                            <select name="mql_id" class="form-select form-select-sm text-muted">
                                <option value="">— Seleccionar —</option>
                                <?php foreach($data['catalogos']['mqls'] as $m): ?>
                                    <option value="<?php echo $m['id']; ?>"><?php echo $m['nivel']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Temperatura</label>
                            <select name="temperatura" class="form-select form-select-sm text-muted">
                                <option value="frio">Frío</option>
                                <option value="tibio">Tibio</option>
                                <option value="caliente">Caliente</option>
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
                                <option value="Contado">Al Contado</option>
                                <option value="Plazo">A Plazo</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Agente Responsable <span class="text-danger">*</span></label>
                            <select name="agente_id" class="form-select form-select-sm text-muted" required>
                                <option value="">— Asignar Agente —</option>
                                <?php foreach($data['catalogos']['agentes'] as $a): ?>
                                    <option value="<?php echo $a['id']; ?>"><?php echo $a['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 h-100">
                            <!-- El input d-block mantiene la alineación vertical con sus campos hermanos -->
                            <label class="form-label d-block text-transparent">&nbsp;</label>
                            <div class="border rounded-2 p-2 px-3 switch-container d-flex flex-column justify-content-center h-100 mt-n1">
                                <div class="form-check form-switch d-flex align-items-center gap-2 mb-1">
                                    <input class="form-check-input mt-0" type="checkbox" role="switch" name="se_envio_mensaje" id="switchMensaje" style="cursor:pointer; transform: scale(1.15); margin-left: 0;">
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
                        <textarea name="comentario" class="form-control" rows="3" placeholder="Añade detalles relevantes sobre lo que busca el prospecto..."></textarea>
                    </div>

                    <!-- Botón Guardar -->
                    <div class="border-top pt-3 text-end">
                        <button type="submit" class="btn btn-primary px-4 py-2 text-white">
                            Guardar Registro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- COLUMNA DERECHA: Opción Rápida -->
    <div class="col-lg-4 col-md-12">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4 text-center">
                <div class="mb-4">
                    <i class="bi bi-rocket-takeoff text-secondary opacity-50" style="font-size: 3rem;"></i>
                </div>
                <h6 class="fw-bold text-dark mb-1">Derivación Rápida</h6>
                <p class="text-muted small mb-4">Omite el proceso normal y transfiere este lead directamente a un vendedor.</p>
                
                <div class="text-start">
                    <label class="form-label">Seleccionar Vendedor</label>
                    <select class="form-select form-select-sm text-muted mb-3">
                        <option value="">— No derivar aún —</option>
                        <?php foreach($data['catalogos']['vendedores'] as $v): ?>
                            <option value="<?php echo $v['id']; ?>"><?php echo $v['nombre']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="button" class="btn btn-derivar w-100 text-white py-2 mt-2">Derivar Ahora</button>
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

    // Diccionario de códigos telefónicos basado en los IDs de la base de datos
    const countryCodes = {
        '1': '+591 ',  // Bolivia
        '2': '+54 ',   // Argentina
        '3': '+56 ',   // Chile
        '4': '+51 ',   // Perú
        '5': '+57 ',   // Colombia
        '6': '+52 ',   // México
        '7': '+593 ',  // Ecuador
        '8': '+598 ',  // Uruguay
        '9': '+595 ',  // Paraguay
        '10': '+34 ',  // España
        '11': '+1 '    // Estados Unidos
    };

    // Función para mostrar el Tooltip Corporativo apuntando al campo
    function showCorporateTooltip(element, message) {
        let existingTooltip = bootstrap.Tooltip.getInstance(element);
        if (existingTooltip) { existingTooltip.dispose(); }

        let tooltip = new bootstrap.Tooltip(element, {
            title: `<i class="bi bi-exclamation-circle-fill me-1 opacity-75"></i> ${message}`,
            html: true,
            placement: 'top',
            trigger: 'manual',
            template: '<div class="tooltip corporate-tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner shadow-sm"></div></div>'
        });

        tooltip.show();
        element.classList.add('input-error');
        setTimeout(() => { element.classList.remove('input-error'); }, 400);

        setTimeout(() => {
            let activeTooltip = bootstrap.Tooltip.getInstance(element);
            if (activeTooltip) {
                activeTooltip.hide();
                element.addEventListener('hidden.bs.tooltip', function () {
                    let t = bootstrap.Tooltip.getInstance(element);
                    if(t) t.dispose();
                }, { once: true });
            }
        }, 3000);
    }

    // --- ALERTAS (Interceptar Clic del Usuario) ---
    if(ciudadSelect) {
        ciudadSelect.addEventListener('mousedown', function(e) {
            if(!paisSelect.value) {
                e.preventDefault(); 
                showCorporateTooltip(this, 'Completa el campo País primero');
            }
        });
    }

    if(campanaSelect) {
        campanaSelect.addEventListener('mousedown', function(e) {
            if(!empresaSelect.value) {
                e.preventDefault();
                showCorporateTooltip(this, 'Selecciona una Empresa primero');
            }
        });
    }

    if(proyectoSelect) {
        proyectoSelect.addEventListener('mousedown', function(e) {
            if(!empresaSelect.value) {
                e.preventDefault();
                showCorporateTooltip(this, 'Selecciona una Empresa primero');
            }
        });
    }

    // --- 1. Dinamismo: País -> Ciudades & Código de Teléfono ---
    if(paisSelect && ciudadSelect) {
        paisSelect.addEventListener('change', function() {
            const paisId = this.value;

            // ---- LÓGICA DE AUTOCOMPLETADO DE TELÉFONO ----
            if(paisId && countryCodes[paisId]) {
                let currentPhone = inputTelefono.value;
                // Si está vacío o solo tiene espacios, asignamos el código del país
                if(currentPhone.trim() === '') {
                    inputTelefono.value = countryCodes[paisId];
                } else {
                    // Si ya escribieron algo, comprobamos si empieza con un '+'. 
                    // Si es así, lo reemplazamos por el nuevo código (sin afectar el número que escribieron)
                    let newPhone = currentPhone.replace(/^\+\d+\s?/, '');
                    inputTelefono.value = countryCodes[paisId] + newPhone;
                }
            } else if (!paisId) {
                 // Si deseleccionaron el país, y el teléfono SOLO tiene un código, lo limpiamos
                 let currentPhone = inputTelefono.value;
                 if (/^\+\d+\s?$/.test(currentPhone)) {
                     inputTelefono.value = '';
                 }
            }
            // ----------------------------------------------
            
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
                        ciudadSelect.innerHTML += `<option value="${ciudad.id}">${ciudad.nombre}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    ciudadSelect.innerHTML = '<option value="">— Error de conexión —</option>';
                });
        });
    }

    // --- 2. Dinamismo: Empresa -> Campañas y Proyectos ---
    if(empresaSelect) {
        empresaSelect.addEventListener('change', function() {
            const empresaId = this.value;
            
            if(!empresaId) {
                if(campanaSelect) campanaSelect.innerHTML = '<option value="">— Seleccionar —</option>';
                if(proyectoSelect) proyectoSelect.innerHTML = '<option value="">— Seleccionar —</option>';
                return;
            }

            if(campanaSelect) campanaSelect.innerHTML = '<option value="">— Cargando datos... —</option>';
            if(proyectoSelect) proyectoSelect.innerHTML = '<option value="">— Cargando datos... —</option>';

            // Cargar Campañas
            if(campanaSelect) {
                fetch(`/crm_callcenter/public/leads/getCampanas/${empresaId}`)
                    .then(response => response.json())
                    .then(data => {
                        campanaSelect.innerHTML = '<option value="">— Seleccionar —</option>';
                        data.forEach(campana => {
                            campanaSelect.innerHTML += `<option value="${campana.id}">${campana.nombre}</option>`;
                        });
                    });
            }
            
            // Cargar Proyectos
            if(proyectoSelect) {
                fetch(`/crm_callcenter/public/leads/getProyectos/${empresaId}`)
                    .then(response => response.json())
                    .then(data => {
                        proyectoSelect.innerHTML = '<option value="">— Seleccionar —</option>';
                        data.forEach(proyecto => {
                            proyectoSelect.innerHTML += `<option value="${proyecto.id}">${proyecto.nombre}</option>`;
                        });
                    });
            }
        });
    }
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
@extends('layouts.app')

@section('content')

<style>
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.45);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }
    .modal-overlay.active { display: flex; }
    .modal-box {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        max-width: 420px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        animation: modalIn 0.2s ease;
    }
    @keyframes modalIn {
        from { transform: scale(0.92); opacity: 0; }
        to   { transform: scale(1);    opacity: 1; }
    }
    .modal-titulo {
        font-size: 1rem;
        font-weight: 700;
        color: #378ADD;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #f0f4f8;
    }
    .modal-group { display: flex; flex-direction: column; margin-bottom: 0.8rem; }
    .modal-group label {
        font-size: 0.72rem;
        font-weight: 600;
        color: #4F5869;
        text-transform: uppercase;
        margin-bottom: 0.3rem;
        letter-spacing: 0.03em;
    }
    .modal-group input {
        height: 40px;
        border: 1.5px solid #D5D9E0;
        border-radius: 7px;
        padding: 0 0.9rem;
        font-size: 0.88rem;
        outline: none;
        transition: border 0.15s;
    }
    .modal-group input:focus { border-color: #378ADD; box-shadow: 0 0 0 3px rgba(55,138,221,0.12); }
    .input-error { border-color: #e74c3c !important; background: #fff5f5 !important; }
    .modal-producto-info {
        background: #f0f9f0;
        border: 1px solid #c3e6cb;
        border-radius: 8px;
        padding: 0.6rem 0.9rem;
        font-size: 0.78rem;
        margin-bottom: 0.8rem;
        display: none;
    }
    .modal-alerta {
        background: #FCEBEB;
        border: 1px solid #fca5a5;
        border-radius: 8px;
        padding: 0.6rem 0.9rem;
        font-size: 0.78rem;
        color: #791F1F;
        margin-bottom: 0.6rem;
        display: none;
        font-weight: 500;
    }
    .modal-btns { display: flex; gap: 0.7rem; margin-top: 1rem; }
    .btn-modal-agregar {
        flex: 1; padding: 0.65rem; border-radius: 8px; border: none;
        background: #378ADD; color: white; font-size: 0.85rem;
        font-weight: 600; cursor: pointer;
    }
    .btn-modal-agregar:hover { background: #2a7bc8; }
    .btn-modal-cerrar {
        flex: 1; padding: 0.65rem; border-radius: 8px;
        border: 1.5px solid #D5D9E0; background: white;
        color: #4F5869; font-size: 0.85rem; font-weight: 600; cursor: pointer;
    }
    .btn-modal-cerrar:hover { border-color: #378ADD; color: #378ADD; }
</style>

<h2 style="color:#378ADD; margin-bottom:1rem;">Nueva Factura</h2>

@if($errors->any())
    <div style="background:#FCEBEB;color:#791F1F;padding:0.75rem 1rem;border-radius:8px;margin-bottom:1rem;font-size:0.875rem;">
        @foreach($errors->all() as $error)
            <div>⚠ {{ $error }}</div>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('facturas.store') }}" id="form_factura" onsubmit="return validarFormulario()">
    @csrf

    <div style="background:#e8f4fd;border-radius:6px;padding:0.5rem 1rem;margin-bottom:1rem;font-size:0.82rem;color:#185FA5;font-weight:600;">
        🧾 Factura N° {{ $numero }}
    </div>

    {{-- Cliente --}}
    <div style="background:white;padding:1rem;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);margin-bottom:1rem;">
        <h3 style="font-size:0.85rem;color:#378ADD;margin-bottom:0.75rem;">👤 Datos del Cliente</h3>
        <div style="display:flex;gap:0.75rem;align-items:flex-end;margin-bottom:0.75rem;">
            <div style="display:flex;flex-direction:column;gap:0.25rem;flex:1;">
                <label style="font-size:0.72rem;font-weight:600;color:#4F5869;text-transform:uppercase;">Cédula del cliente</label>
                <input type="text" id="buscar_cliente"
                       placeholder="Ingresa la cédula y presiona Tab..."
                       style="height:38px;border:1.5px solid #D5D9E0;border-radius:7px;padding:0 0.9rem;font-size:0.85rem;outline:none;"
                       autocomplete="off">
            </div>
            <button type="button" onclick="buscarCliente()"
                    style="background:#378ADD;color:white;padding:0 1.2rem;height:38px;border:none;border-radius:7px;cursor:pointer;font-size:0.82rem;font-weight:600;">
                Buscar
            </button>
        </div>
        <div id="cliente_error" style="display:none;background:#FCEBEB;color:#791F1F;padding:0.5rem 0.75rem;border-radius:5px;font-size:0.78rem;margin-bottom:0.5rem;">
            ⚠ No se encontró ningún cliente con esa cédula.
        </div>
        <div id="cliente_info" style="display:none;">
            <input type="hidden" name="cliente_id" id="cliente_id">
            <div style="background:#f8fbff;border:1.5px solid #e2eaf3;border-radius:8px;padding:0.8rem 1rem;">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;font-size:0.82rem;">
                    <div><span style="color:#8A93A2;">Nombre:</span> <strong id="cli_nombre"></strong></div>
                    <div><span style="color:#8A93A2;">Cédula:</span> <strong id="cli_cedula"></strong></div>
                    <div><span style="color:#8A93A2;">Celular:</span> <strong id="cli_celular"></strong></div>
                    <div><span style="color:#8A93A2;">Dirección:</span> <strong id="cli_direccion"></strong></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Productos --}}
    <div style="background:white;padding:1rem;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);margin-bottom:1rem;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.75rem;">
            <h3 style="font-size:0.85rem;color:#378ADD;margin:0;">📦 Productos</h3>
            <button type="button" onclick="abrirModalProducto()"
                    style="background:#378ADD;color:white;padding:0.4rem 1rem;border:none;border-radius:7px;cursor:pointer;font-size:0.82rem;font-weight:600;">
                ＋ Agregar producto
            </button>
        </div>

        <div id="alerta_general" style="display:none;background:#FCEBEB;border:1px solid #fca5a5;color:#791F1F;padding:0.6rem 0.9rem;border-radius:8px;font-size:0.82rem;margin-bottom:0.75rem;font-weight:500;"></div>

        <table style="width:100%;border-collapse:collapse;font-size:0.8rem;">
            <thead style="background:#f5f9ff;border-bottom:2px solid #e2eaf3;">
                <tr>
                    <th style="padding:0.6rem 0.75rem;text-align:left;color:#378ADD;font-size:0.72rem;text-transform:uppercase;">Código</th>
                    <th style="padding:0.6rem 0.75rem;text-align:left;color:#378ADD;font-size:0.72rem;text-transform:uppercase;">Nombre</th>
                    <th style="padding:0.6rem 0.75rem;text-align:center;color:#378ADD;font-size:0.72rem;text-transform:uppercase;">Stock</th>
                    <th style="padding:0.6rem 0.75rem;text-align:center;color:#378ADD;font-size:0.72rem;text-transform:uppercase;">Cantidad</th>
                    <th style="padding:0.6rem 0.75rem;text-align:center;color:#378ADD;font-size:0.72rem;text-transform:uppercase;">Precio Unit.</th>
                    <th style="padding:0.6rem 0.75rem;text-align:center;color:#378ADD;font-size:0.72rem;text-transform:uppercase;">Costo</th>
                    <th style="padding:0.6rem 0.75rem;text-align:center;color:#378ADD;font-size:0.72rem;text-transform:uppercase;">IVA</th>
                    <th style="padding:0.6rem 0.75rem;text-align:center;color:#378ADD;font-size:0.72rem;text-transform:uppercase;">Subtotal</th>
                    <th style="padding:0.6rem 0.75rem;text-align:center;color:#378ADD;font-size:0.72rem;text-transform:uppercase;">Quitar</th>
                </tr>
            </thead>
            <tbody id="items_body">
                <tr id="sin_items">
                    <td colspan="9" style="padding:1.5rem;text-align:center;color:#8A93A2;">
                        No hay productos agregados. Haz clic en "Agregar producto".
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Totales --}}
    <div style="background:white;padding:1rem;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);margin-bottom:1rem;max-width:300px;margin-left:auto;">
        <div style="display:flex;justify-content:space-between;font-size:0.82rem;margin-bottom:0.4rem;">
            <span style="color:#8A93A2;">Subtotal:</span>
            <strong id="total_subtotal">$0,00</strong>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:0.82rem;margin-bottom:0.4rem;">
            <span style="color:#8A93A2;">IVA:</span>
            <strong id="total_iva">$0,00</strong>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:0.95rem;border-top:1px solid #f0f4f8;padding-top:0.4rem;">
            <span style="font-weight:700;">TOTAL:</span>
            <strong id="total_total" style="color:#378ADD;">$0,00</strong>
        </div>
    </div>

    {{-- Observacion --}}
    <div style="background:white;padding:1rem;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);margin-bottom:1rem;">
        <label style="font-size:0.8rem;color:#4F5869;">Observación</label>
        <textarea name="observacion" style="width:100%;border:1.5px solid #D5D9E0;border-radius:5px;padding:6px 8px;font-size:0.8rem;resize:vertical;margin-top:0.3rem;" rows="2"></textarea>
    </div>

    <button type="submit" style="background:#378ADD;color:white;padding:0.6rem 1.8rem;border:none;border-radius:8px;cursor:pointer;font-size:0.88rem;font-weight:600;">💾 Guardar Factura</button>
    <a href="{{ route('facturas.index') }}" style="margin-left:0.5rem;color:#8A93A2;font-size:0.82rem;text-decoration:none;">Cancelar</a>

</form>

{{-- MODAL AGREGAR PRODUCTO --}}
<div class="modal-overlay" id="modalProducto">
    <div class="modal-box">
        <div class="modal-titulo">➕ Agregar Producto</div>

        <div class="modal-group">
            <label>Código del producto</label>
            <input type="text" id="modal_codigo"
                   placeholder="Ingresa el código y presiona Tab..."
                   autocomplete="off">
        </div>

        <div class="modal-producto-info" id="modal_producto_info">
            <strong id="modal_producto_nombre"></strong><br>
            <span style="color:#8A93A2;">Costo promedio: </span>
            <strong id="modal_producto_costo" style="color:#0C447C;"></strong>
            &nbsp;|&nbsp;
            <span style="color:#8A93A2;">Stock disponible: </span>
            <strong id="modal_producto_stock" style="color:#27500A;"></strong>
        </div>

        <div class="modal-alerta" id="modal_producto_error">
            ⚠️ Producto no encontrado.
        </div>

        <div class="modal-group">
            <label>Cantidad</label>
            <input type="number" id="modal_cantidad" value="1" min="1"
                   oninput="validarCantidadModal()">
        </div>

        <div class="modal-alerta" id="modal_stock_alerta">
            ⚠️ <span id="modal_stock_msg"></span>
        </div>

        <div class="modal-group">
            <label>Precio de venta unitario</label>
            <input type="number" id="modal_precio" step="0.01" value="0" min="0"
                   oninput="validarPrecioModal()">
        </div>

        <div class="modal-alerta" id="modal_precio_alerta">
            ⚠️ <span id="modal_precio_msg"></span>
        </div>

        <div class="modal-btns">
            <button type="button" class="btn-modal-cerrar" onclick="cerrarModalProducto()">Cancelar</button>
            <button type="button" class="btn-modal-agregar" onclick="agregarDesdeModal()">➕ Agregar</button>
        </div>
    </div>
</div>

<script>
    let itemIndex = 0;
    let modalProductoActual = null;

    // ===== CLIENTE =====
    function buscarCliente() {
        const busqueda = document.getElementById('buscar_cliente').value.trim();
        if (!busqueda) return;
        fetch(`{{ route('facturas.buscar-cliente') }}?busqueda=${busqueda}`)
            .then(res => res.json())
            .then(data => {
                if (data.encontrado) {
                    document.getElementById('cliente_id').value = data.id;
                    document.getElementById('cli_nombre').textContent = data.nombre;
                    document.getElementById('cli_cedula').textContent = data.cedula;
                    document.getElementById('cli_celular').textContent = data.celular;
                    document.getElementById('cli_direccion').textContent = data.direccion;
                    document.getElementById('cliente_info').style.display = 'block';
                    document.getElementById('cliente_error').style.display = 'none';
                } else {
                    document.getElementById('cliente_info').style.display = 'none';
                    document.getElementById('cliente_error').style.display = 'block';
                }
            });
    }

    document.getElementById('buscar_cliente').addEventListener('keydown', function(e) {
        if (e.key === 'Tab' || e.key === 'Enter') { e.preventDefault(); buscarCliente(); }
    });

    // ===== MODAL PRODUCTO =====
    function abrirModalProducto() {
        modalProductoActual = null;
        document.getElementById('modal_codigo').value = '';
        document.getElementById('modal_cantidad').value = '1';
        document.getElementById('modal_precio').value = '0';
        document.getElementById('modal_producto_info').style.display = 'none';
        document.getElementById('modal_producto_error').style.display = 'none';
        document.getElementById('modal_stock_alerta').style.display = 'none';
        document.getElementById('modal_precio_alerta').style.display = 'none';
        document.getElementById('modal_codigo').classList.remove('input-error');
        document.getElementById('modal_cantidad').classList.remove('input-error');
        document.getElementById('modal_precio').classList.remove('input-error');
        document.getElementById('modalProducto').classList.add('active');
        setTimeout(() => document.getElementById('modal_codigo').focus(), 100);
    }

    function cerrarModalProducto() {
        document.getElementById('modalProducto').classList.remove('active');
    }

    document.getElementById('modal_codigo').addEventListener('keydown', function(e) {
        if (e.key === 'Tab' || e.key === 'Enter') { e.preventDefault(); buscarProductoModal(); }
    });

    function buscarProductoModal() {
        const codigo = document.getElementById('modal_codigo').value.trim();
        if (!codigo) return;
        fetch(`{{ route('facturas.buscar-producto') }}?busqueda=${codigo}`)
            .then(res => res.json())
            .then(data => {
                if (data.encontrado) {
                    modalProductoActual = data;
                    document.getElementById('modal_producto_nombre').textContent = data.nombre;
                    document.getElementById('modal_producto_costo').textContent = '$' + formatear(data.costo_promedio);
                    document.getElementById('modal_producto_stock').textContent = data.stock + ' unidades';
                    document.getElementById('modal_producto_info').style.display = 'block';
                    document.getElementById('modal_producto_error').style.display = 'none';
                    document.getElementById('modal_codigo').classList.remove('input-error');

                    // Si stock es 0 bloquear inmediatamente
                    if (data.stock <= 0) {
                        document.getElementById('modal_stock_msg').textContent = 'Este producto no tiene stock disponible.';
                        document.getElementById('modal_stock_alerta').style.display = 'block';
                    }

                    document.getElementById('modal_cantidad').focus();
                } else {
                    modalProductoActual = null;
                    document.getElementById('modal_producto_info').style.display = 'none';
                    document.getElementById('modal_producto_error').style.display = 'block';
                    document.getElementById('modal_codigo').classList.add('input-error');
                }
            });
    }

    function validarCantidadModal() {
        if (!modalProductoActual) return;
        const cantidad = parseInt(document.getElementById('modal_cantidad').value) || 0;
        const stock = parseInt(modalProductoActual.stock) || 0;
        const input = document.getElementById('modal_cantidad');
        const alerta = document.getElementById('modal_stock_alerta');
        const msg = document.getElementById('modal_stock_msg');

        if (cantidad > stock) {
            input.classList.add('input-error');
            msg.textContent = `Stock insuficiente. Disponible: ${stock} unidades.`;
            alerta.style.display = 'block';
        } else if (cantidad <= 0) {
            input.classList.add('input-error');
            msg.textContent = 'La cantidad debe ser al menos 1.';
            alerta.style.display = 'block';
        } else {
            input.classList.remove('input-error');
            alerta.style.display = 'none';
        }
    }

    function validarPrecioModal() {
        if (!modalProductoActual) return;
        const precio = parseFloat(document.getElementById('modal_precio').value) || 0;
        const costo = parseFloat(modalProductoActual.costo_promedio) || 0;
        const input = document.getElementById('modal_precio');
        const alerta = document.getElementById('modal_precio_alerta');
        const msg = document.getElementById('modal_precio_msg');

        if (precio > 0 && precio < costo) {
            input.classList.add('input-error');
            msg.textContent = `El precio $${formatear(precio)} es menor al costo $${formatear(costo)}. No se puede facturar por debajo del costo.`;
            alerta.style.display = 'block';
        } else if (precio === 0) {
            input.classList.add('input-error');
            msg.textContent = 'Debes ingresar un precio de venta.';
            alerta.style.display = 'block';
        } else {
            input.classList.remove('input-error');
            alerta.style.display = 'none';
        }
    }

    function agregarDesdeModal() {
        if (!modalProductoActual) {
            document.getElementById('modal_producto_error').style.display = 'block';
            return;
        }

        const cantidad = parseInt(document.getElementById('modal_cantidad').value) || 0;
        const precio = parseFloat(document.getElementById('modal_precio').value) || 0;
        const stock = parseInt(modalProductoActual.stock) || 0;
        const costo = parseFloat(modalProductoActual.costo_promedio) || 0;

        // Validar stock
        if (cantidad <= 0) {
            document.getElementById('modal_stock_msg').textContent = 'La cantidad debe ser al menos 1.';
            document.getElementById('modal_stock_alerta').style.display = 'block';
            document.getElementById('modal_cantidad').classList.add('input-error');
            document.getElementById('modal_cantidad').focus();
            return;
        }

        if (cantidad > stock) {
            document.getElementById('modal_stock_msg').textContent = `Stock insuficiente. Solo hay ${stock} unidades disponibles.`;
            document.getElementById('modal_stock_alerta').style.display = 'block';
            document.getElementById('modal_cantidad').classList.add('input-error');
            document.getElementById('modal_cantidad').focus();
            return;
        }

        // Validar precio
        if (precio === 0) {
            document.getElementById('modal_precio_msg').textContent = 'Debes ingresar un precio de venta.';
            document.getElementById('modal_precio_alerta').style.display = 'block';
            document.getElementById('modal_precio').classList.add('input-error');
            document.getElementById('modal_precio').focus();
            return;
        }

        if (precio < costo) {
            document.getElementById('modal_precio_msg').textContent = `❌ No puedes facturar por debajo del costo. Precio: $${formatear(precio)} | Costo: $${formatear(costo)}`;
            document.getElementById('modal_precio_alerta').style.display = 'block';
            document.getElementById('modal_precio').classList.add('input-error');
            document.getElementById('modal_precio').focus();
            return;
        }

        // Todo OK — agregar a la tabla
        agregarItem(modalProductoActual, cantidad, precio);

        // Limpiar para agregar otro
        document.getElementById('modal_codigo').value = '';
        document.getElementById('modal_cantidad').value = '1';
        document.getElementById('modal_precio').value = '0';
        document.getElementById('modal_producto_info').style.display = 'none';
        document.getElementById('modal_producto_error').style.display = 'none';
        document.getElementById('modal_stock_alerta').style.display = 'none';
        document.getElementById('modal_precio_alerta').style.display = 'none';
        document.getElementById('modal_codigo').classList.remove('input-error');
        document.getElementById('modal_cantidad').classList.remove('input-error');
        document.getElementById('modal_precio').classList.remove('input-error');
        modalProductoActual = null;
        document.getElementById('modal_codigo').focus();
    }

    function agregarItem(producto, cantidad, precio) {
        document.getElementById('sin_items').style.display = 'none';
        const tbody = document.getElementById('items_body');
        const idx = itemIndex++;
        const costo = parseFloat(producto.costo_promedio) || 0;
        const sub = cantidad * precio;
        const ivaVal = parseFloat(producto.iva) || 0;

        const tr = document.createElement('tr');
        tr.id = `item_${idx}`;
        tr.dataset.stock = producto.stock;
        tr.dataset.costo = costo;
        tr.dataset.nombre = producto.nombre;
        tr.style.borderBottom = '1px solid #f0f4f8';
        tr.innerHTML = `
            <td style="padding:0.6rem 0.75rem;">${producto.codigo}
                <input type="hidden" name="items[${idx}][producto_id]" value="${producto.id}">
            </td>
            <td style="padding:0.6rem 0.75rem;">${producto.nombre}</td>
            <td style="padding:0.6rem 0.75rem;text-align:center;">
                <span style="background:#EAF3DE;color:#27500A;padding:0.15rem 0.6rem;border-radius:10px;font-size:0.75rem;font-weight:600;">${producto.stock}</span>
            </td>
            <td style="padding:0.6rem 0.75rem;text-align:center;">
                <input type="number" name="items[${idx}][cantidad]" value="${cantidad}" min="1" max="${producto.stock}"
                    style="width:65px;height:28px;border:1.5px solid #D5D9E0;border-radius:4px;text-align:center;font-size:0.8rem;"
                    oninput="validarCantidadTabla(${idx})" onchange="validarCantidadTabla(${idx})">
                <div id="err_stock_${idx}" style="color:#e74c3c;font-size:0.7rem;display:none;margin-top:2px;">⚠ Stock insuficiente</div>
            </td>
            <td style="padding:0.6rem 0.75rem;text-align:center;">
                <input type="number" step="0.01" name="items[${idx}][precio_unitario]" value="${precio}" min="0"
                    style="width:100px;height:28px;border:1.5px solid #D5D9E0;border-radius:4px;text-align:center;font-size:0.8rem;"
                    oninput="validarPrecioTabla(${idx})" onchange="validarPrecioTabla(${idx})">
                <div id="err_precio_${idx}" style="color:#e74c3c;font-size:0.7rem;display:none;margin-top:2px;">⚠ Precio < costo</div>
            </td>
            <td style="padding:0.6rem 0.75rem;text-align:center;font-size:0.75rem;color:#8A93A2;">$${formatear(costo)}</td>
            <td style="padding:0.6rem 0.75rem;text-align:center;">${producto.iva}%</td>
            <td style="padding:0.6rem 0.75rem;text-align:center;font-weight:600;" id="sub_${idx}">$${formatear(sub)}</td>
            <td style="padding:0.6rem 0.75rem;text-align:center;">
                <button type="button" onclick="quitarItem(${idx})" style="background:#FCEBEB;color:#dc2626;border:none;border-radius:4px;padding:0.2rem 0.5rem;cursor:pointer;font-size:0.78rem;">✕</button>
            </td>
        `;
        tbody.appendChild(tr);
        calcularTotales();
    }

    function validarCantidadTabla(idx) {
        const tr = document.getElementById(`item_${idx}`);
        const input = tr.querySelector(`[name="items[${idx}][cantidad]"]`);
        const cantidad = parseInt(input.value) || 0;
        const stock = parseInt(tr.dataset.stock) || 0;
        const err = document.getElementById(`err_stock_${idx}`);

        if (cantidad > stock || cantidad <= 0) {
            input.style.borderColor = '#e74c3c';
            input.style.background = '#fff5f5';
            err.style.display = 'block';
        } else {
            input.style.borderColor = '#D5D9E0';
            input.style.background = 'white';
            err.style.display = 'none';
        }
        recalcular(idx);
    }

    function validarPrecioTabla(idx) {
        const tr = document.getElementById(`item_${idx}`);
        const input = tr.querySelector(`[name="items[${idx}][precio_unitario]"]`);
        const precio = parseFloat(input.value) || 0;
        const costo = parseFloat(tr.dataset.costo) || 0;
        const err = document.getElementById(`err_precio_${idx}`);

        if (precio < costo || precio === 0) {
            input.style.borderColor = '#e74c3c';
            input.style.background = '#fff5f5';
            err.style.display = 'block';
        } else {
            input.style.borderColor = '#D5D9E0';
            input.style.background = 'white';
            err.style.display = 'none';
        }
        recalcular(idx);
    }

    function recalcular(idx) {
        const tr = document.getElementById(`item_${idx}`);
        const cantidad = parseFloat(tr.querySelector(`[name="items[${idx}][cantidad]"]`).value) || 0;
        const precio = parseFloat(tr.querySelector(`[name="items[${idx}][precio_unitario]"]`).value) || 0;
        document.getElementById(`sub_${idx}`).textContent = '$' + formatear(cantidad * precio);
        calcularTotales();
    }

    function calcularTotales() {
        let subtotal = 0;
        let total_iva = 0;
        document.querySelectorAll('#items_body tr[id^="item_"]').forEach(tr => {
            const idx = tr.id.replace('item_', '');
            const cantidad = parseFloat(tr.querySelector(`[name="items[${idx}][cantidad]"]`).value) || 0;
            const precio = parseFloat(tr.querySelector(`[name="items[${idx}][precio_unitario]"]`).value) || 0;
            const ivaText = tr.cells[6].textContent.replace('%', '');
            const iva = parseFloat(ivaText) || 0;
            const sub = cantidad * precio;
            subtotal += sub;
            total_iva += sub * (iva / 100);
        });
        document.getElementById('total_subtotal').textContent = '$' + formatear(subtotal);
        document.getElementById('total_iva').textContent = '$' + formatear(total_iva);
        document.getElementById('total_total').textContent = '$' + formatear(subtotal + total_iva);
    }

    function validarFormulario() {
        let errores = [];
        document.querySelectorAll('#items_body tr[id^="item_"]').forEach(tr => {
            const idx = tr.id.replace('item_', '');
            const cantidad = parseInt(tr.querySelector(`[name="items[${idx}][cantidad]"]`).value) || 0;
            const precio = parseFloat(tr.querySelector(`[name="items[${idx}][precio_unitario]"]`).value) || 0;
            const stock = parseInt(tr.dataset.stock) || 0;
            const costo = parseFloat(tr.dataset.costo) || 0;
            const nombre = tr.dataset.nombre;

            if (cantidad > stock) errores.push(`"${nombre}": cantidad (${cantidad}) supera el stock (${stock}).`);
            if (precio === 0) errores.push(`"${nombre}": debes ingresar un precio.`);
            if (precio > 0 && precio < costo) errores.push(`"${nombre}": precio $${formatear(precio)} es menor al costo $${formatear(costo)}.`);
        });

        if (errores.length > 0) {
            const alerta = document.getElementById('alerta_general');
            alerta.innerHTML = '❌ No se puede guardar:<br>' + errores.join('<br>');
            alerta.style.display = 'block';
            window.scrollTo(0, 0);
            return false;
        }
        return true;
    }

    function formatear(num) {
        return new Intl.NumberFormat('es-CO', { minimumFractionDigits: 2 }).format(num);
    }

    function quitarItem(idx) {
        document.getElementById(`item_${idx}`).remove();
        calcularTotales();
    }

    document.getElementById('modalProducto').addEventListener('click', function(e) {
        if (e.target === this) cerrarModalProducto();
    });
</script>

@endsection
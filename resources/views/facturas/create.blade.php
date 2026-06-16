@extends('layouts.app')

@section('content')

    <h2 style="color:#378ADD; margin-bottom:1rem;">Nueva Factura</h2>

    @if($errors->any())
        <div style="background:#FCEBEB;color:#791F1F;padding:0.75rem 1rem;border-radius:8px;margin-bottom:1rem;font-size:0.875rem;">
            @foreach($errors->all() as $error)
                <div>⚠ {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('facturas.store') }}" id="form_factura">
        @csrf

        {{-- Numero de factura --}}
        <div style="background:#e8f4fd;border-radius:6px;padding:0.5rem 1rem;margin-bottom:1rem;font-size:0.82rem;color:#185FA5;font-weight:600;">
            🧾 Factura N° {{ $numero }}
        </div>

        {{-- Buscar cliente --}}
        <div style="background:white;padding:1rem;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);margin-bottom:1rem;">
            <h3 style="font-size:0.85rem;color:#378ADD;margin-bottom:0.75rem;">👤 Datos del Cliente</h3>

            <div style="display:flex;gap:0.75rem;margin-bottom:0.75rem;">
                <input type="text" id="buscar_cliente" placeholder="Buscar por cédula o nombre..." style="flex:1;height:32px;border:1.5px solid #D5D9E0;border-radius:5px;padding:0 8px;font-size:0.8rem;" autocomplete="off">
                <button type="button" onclick="buscarCliente()" style="background:#378ADD;color:white;padding:0 1rem;border:none;border-radius:5px;cursor:pointer;font-size:0.8rem;">Buscar</button>
            </div>

            <div id="cliente_error" style="display:none;background:#FCEBEB;color:#791F1F;padding:0.5rem 0.75rem;border-radius:5px;font-size:0.78rem;margin-bottom:0.5rem;">
                ⚠ No se encontró ningún cliente con ese dato.
            </div>

            <div id="cliente_info" style="display:none;">
                <input type="hidden" name="cliente_id" id="cliente_id">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;font-size:0.8rem;">
                    <div><span style="color:#8A93A2;">Nombre:</span> <strong id="cli_nombre"></strong></div>
                    <div><span style="color:#8A93A2;">Cédula:</span> <strong id="cli_cedula"></strong></div>
                    <div><span style="color:#8A93A2;">Celular:</span> <strong id="cli_celular"></strong></div>
                    <div><span style="color:#8A93A2;">Dirección:</span> <strong id="cli_direccion"></strong></div>
                </div>
            </div>
        </div>

        {{-- Items --}}
        <div style="background:white;padding:1rem;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);margin-bottom:1rem;">
            <h3 style="font-size:0.85rem;color:#378ADD;margin-bottom:0.75rem;">📦 Productos</h3>

            <div style="display:flex;gap:0.75rem;margin-bottom:0.75rem;">
                <input type="text" id="buscar_producto" placeholder="Buscar por código o nombre..." style="flex:1;height:32px;border:1.5px solid #D5D9E0;border-radius:5px;padding:0 8px;font-size:0.8rem;" autocomplete="off">
                <button type="button" onclick="buscarProducto()" style="background:#378ADD;color:white;padding:0 1rem;border:none;border-radius:5px;cursor:pointer;font-size:0.8rem;">Agregar</button>
            </div>

            <div id="producto_error" style="display:none;background:#FCEBEB;color:#791F1F;padding:0.5rem 0.75rem;border-radius:5px;font-size:0.78rem;margin-bottom:0.5rem;">
                ⚠ No se encontró ningún producto con ese dato.
            </div>

            <table style="width:100%;border-collapse:collapse;font-size:0.8rem;">
                <thead style="background:#f0f4f8;">
                    <tr>
                        <th style="padding:0.5rem;text-align:left;">Código</th>
                        <th style="padding:0.5rem;text-align:left;">Nombre</th>
                        <th style="padding:0.5rem;text-align:center;">Stock</th>
                        <th style="padding:0.5rem;text-align:center;">Cantidad</th>
                        <th style="padding:0.5rem;text-align:center;">Precio Unit.</th>
                        <th style="padding:0.5rem;text-align:center;">IVA</th>
                        <th style="padding:0.5rem;text-align:center;">Subtotal</th>
                        <th style="padding:0.5rem;text-align:center;">Quitar</th>
                    </tr>
                </thead>
                <tbody id="items_body">
                    <tr id="sin_items">
                        <td colspan="8" style="padding:1rem;text-align:center;color:#8A93A2;">No hay productos agregados</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Totales --}}
        <div style="background:white;padding:1rem;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);margin-bottom:1rem;max-width:300px;margin-left:auto;">
            <div style="display:flex;justify-content:space-between;font-size:0.82rem;margin-bottom:0.4rem;">
                <span style="color:#8A93A2;">Subtotal:</span>
                <strong id="total_subtotal">$0.00</strong>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:0.82rem;margin-bottom:0.4rem;">
                <span style="color:#8A93A2;">IVA:</span>
                <strong id="total_iva">$0.00</strong>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:0.95rem;border-top:1px solid #f0f4f8;padding-top:0.4rem;">
                <span style="font-weight:700;">TOTAL:</span>
                <strong id="total_total" style="color:#378ADD;">$0.00</strong>
            </div>
        </div>

        {{-- Observacion --}}
        <div style="background:white;padding:1rem;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);margin-bottom:1rem;">
            <label style="font-size:0.8rem;color:#4F5869;">Observación</label>
            <textarea name="observacion" style="width:100%;border:1.5px solid #D5D9E0;border-radius:5px;padding:6px 8px;font-size:0.8rem;resize:vertical;margin-top:0.3rem;" rows="2"></textarea>
        </div>

        <button type="submit" style="background:#378ADD;color:white;padding:0.5rem 1.5rem;border:none;border-radius:6px;cursor:pointer;font-size:0.88rem;font-weight:600;">Guardar Factura</button>
        <a href="{{ route('facturas.index') }}" style="margin-left:0.5rem;color:#8A93A2;font-size:0.82rem;text-decoration:none;">Cancelar</a>

    </form>

    <script>
        let itemIndex = 0;
        let stockItems = {};

        function buscarCliente() {
            const busqueda = document.getElementById('buscar_cliente').value.trim();
            if (!busqueda) return;

            fetch(`{{ route('facturas.buscar-cliente') }}?busqueda=${busqueda}`)
                .then(res => res.json())
                .then(data => {
                    if (data.encontrado) {
                        document.getElementById('cliente_id').value          = data.id;
                        document.getElementById('cli_nombre').textContent    = data.nombre;
                        document.getElementById('cli_cedula').textContent    = data.cedula;
                        document.getElementById('cli_celular').textContent   = data.celular;
                        document.getElementById('cli_direccion').textContent = data.direccion;
                        document.getElementById('cliente_info').style.display  = 'block';
                        document.getElementById('cliente_error').style.display = 'none';
                    } else {
                        document.getElementById('cliente_info').style.display  = 'none';
                        document.getElementById('cliente_error').style.display = 'block';
                    }
                });
        }

        function buscarProducto() {
            const busqueda = document.getElementById('buscar_producto').value.trim();
            if (!busqueda) return;

            fetch(`{{ route('facturas.buscar-producto') }}?busqueda=${busqueda}`)
                .then(res => res.json())
                .then(data => {
                    if (data.encontrado) {
                        agregarItem(data);
                        document.getElementById('buscar_producto').value = '';
                        document.getElementById('producto_error').style.display = 'none';
                    } else {
                        document.getElementById('producto_error').style.display = 'block';
                    }
                });
        }

        function agregarItem(producto) {
            document.getElementById('sin_items').style.display = 'none';
            const tbody = document.getElementById('items_body');
            const idx   = itemIndex++;
            stockItems[idx] = producto.stock;

            const tr = document.createElement('tr');
            tr.id    = `item_${idx}`;
            tr.style.borderBottom = '1px solid #f0f4f8';
            tr.innerHTML = `
                <td style="padding:0.5rem;">${producto.codigo}
                    <input type="hidden" name="items[${idx}][producto_id]" value="${producto.id}">
                </td>
                <td style="padding:0.5rem;">${producto.nombre}</td>
                <td style="padding:0.5rem;text-align:center;">
                    <span style="background:#EAF3DE;color:#27500A;padding:0.15rem 0.5rem;border-radius:10px;font-size:0.75rem;">${producto.stock}</span>
                </td>
                <td style="padding:0.5rem;text-align:center;">
                    <input type="number" name="items[${idx}][cantidad]" value="1" min="1" max="${producto.stock}"
                        style="width:60px;height:28px;border:1.5px solid #D5D9E0;border-radius:4px;text-align:center;font-size:0.8rem;"
                        onchange="validarStock(${idx})" oninput="validarStock(${idx})">
                    <div id="stock_error_${idx}" style="color:red;font-size:0.72rem;display:none;">Stock insuficiente</div>
                </td>
                <td style="padding:0.5rem;text-align:center;">
                    <input type="number" step="0.01" name="items[${idx}][precio_unitario]" value="0" min="0"
                        style="width:90px;height:28px;border:1.5px solid #D5D9E0;border-radius:4px;text-align:center;font-size:0.8rem;"
                        onchange="recalcular(${idx})" oninput="recalcular(${idx})">
                </td>
                <td style="padding:0.5rem;text-align:center;">${producto.iva}%</td>
                <td style="padding:0.5rem;text-align:center;" id="sub_${idx}">$0.00</td>
                <td style="padding:0.5rem;text-align:center;">
                    <button type="button" onclick="quitarItem(${idx})" style="background:#FCEBEB;color:#dc2626;border:none;border-radius:4px;padding:0.2rem 0.5rem;cursor:pointer;font-size:0.78rem;">✕</button>
                </td>
            `;
            tbody.appendChild(tr);
            recalcular(idx);
        }

        function validarStock(idx) {
            const tr       = document.getElementById(`item_${idx}`);
            const cantidad = parseInt(tr.querySelector(`[name="items[${idx}][cantidad]"]`).value) || 0;
            const stock    = stockItems[idx];
            const error    = document.getElementById(`stock_error_${idx}`);

            if (cantidad > stock) {
                error.style.display = 'block';
                tr.querySelector(`[name="items[${idx}][cantidad]"]`).style.borderColor = 'red';
            } else {
                error.style.display = 'none';
                tr.querySelector(`[name="items[${idx}][cantidad]"]`).style.borderColor = '#D5D9E0';
            }
            recalcular(idx);
        }

        function recalcular(idx) {
            const tr       = document.getElementById(`item_${idx}`);
            const cantidad = parseFloat(tr.querySelector(`[name="items[${idx}][cantidad]"]`).value) || 0;
            const precio   = parseFloat(tr.querySelector(`[name="items[${idx}][precio_unitario]"]`).value) || 0;
            const sub      = cantidad * precio;
            document.getElementById(`sub_${idx}`).textContent = '$' + sub.toFixed(2);
            calcularTotales();
        }

        function calcularTotales() {
            let subtotal  = 0;
            let total_iva = 0;

            document.querySelectorAll('#items_body tr[id^="item_"]').forEach(tr => {
                const idx      = tr.id.replace('item_', '');
                const cantidad = parseFloat(tr.querySelector(`[name="items[${idx}][cantidad]"]`).value) || 0;
                const precio   = parseFloat(tr.querySelector(`[name="items[${idx}][precio_unitario]"]`).value) || 0;
                const ivaText  = tr.cells[5].textContent.replace('%', '');
                const iva      = parseFloat(ivaText) || 0;
                const sub      = cantidad * precio;
                subtotal      += sub;
                total_iva     += sub * (iva / 100);
            });

            document.getElementById('total_subtotal').textContent = '$' + subtotal.toFixed(2);
            document.getElementById('total_iva').textContent      = '$' + total_iva.toFixed(2);
            document.getElementById('total_total').textContent    = '$' + (subtotal + total_iva).toFixed(2);
        }

        function quitarItem(idx) {
            document.getElementById(`item_${idx}`).remove();
            calcularTotales();
        }

        document.getElementById('buscar_cliente').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') { e.preventDefault(); buscarCliente(); }
        });
        document.getElementById('buscar_producto').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') { e.preventDefault(); buscarProducto(); }
        });
    </script>

@endsection
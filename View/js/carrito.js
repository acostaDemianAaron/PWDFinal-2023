const carrito = [];

function agregarAlCarrito(title, quantity, unit_price) {
    const itemExistente = carrito.find(item => item.title === title);

    if (itemExistente) {
        itemExistente.quantity++;
    } else {
        const newItem = { title, quantity, unit_price };
        carrito.push(newItem);
    }

    mostrarCarrito();
}

function eliminarDelCarrito(title) {
    const itemIndex = carrito.findIndex(item => item.title === title);

    if (itemIndex !== -1) {
        carrito.splice(itemIndex, 1);
    }

    mostrarCarrito();
}

function aumentarCantidad(title) {
    const itemExistente = carrito.find(item => item.title === title);

    if (itemExistente) {
        itemExistente.quantity++;
        mostrarCarrito();
    }
}

function disminuirCantidad(title) {
    const itemExistente = carrito.find(item => item.title === title);

    if (itemExistente && itemExistente.quantity > 1) {
        itemExistente.quantity--;
        mostrarCarrito();
    }
}

function mostrarCarrito() {
    const cartDiv = document.getElementById('cart');
    cartDiv.innerHTML = '<h2>Carrito de compras</h2>';

    let total = 0;

    carrito.forEach(item => {
        const subtotal = item.quantity * item.unit_price;
        cartDiv.innerHTML += `
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">${item.title}</h5>
                    <p class="card-text">Precio: $${item.unit_price}</p>
                    <p class="card-text">Cantidad: ${item.quantity}</p>
                    <p class="card-text">Subtotal: $${subtotal}</p>
                    <button class="btn btn-primary mr-2" onclick="aumentarCantidad('${item.title}')">+</button>
                    <button class="btn btn-primary mr-2" onclick="disminuirCantidad('${item.title}')">-</button>
                    <button class="btn btn-danger" onclick="eliminarDelCarrito('${item.title}')">Eliminar</button>
                </div>
            </div>
        `;
        total += subtotal;
    });

    if (carrito.length === 0) {
        cartDiv.innerHTML += '<p>El carrito está vacío.</p>';
    } else {
        cartDiv.innerHTML += `<p class="mt-3"><strong>Total: $${total}</strong></p>`;
        // Agregar el botón "Pagar" al final
        cartDiv.innerHTML += '<button class="btn btn-success" id="btnPagar" onclick="enviarCarrito()">Enviar pedido</button>';
    }
}

mostrarCarrito();

function enviarCarrito() {
    // Crear un formulario en el DOM
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'Action/enviar_pedido.php'; // La URL correcta de tu página PHP

    // Crear un campo oculto que contenga el carrito completo como JSON
    const carritoInput = document.createElement('input');
    carritoInput.type = 'hidden';
    carritoInput.name = 'carrito';
    carritoInput.value = JSON.stringify(carrito);
    form.appendChild(carritoInput);

    // Agregar el formulario al DOM y enviarlo
    document.body.appendChild(form);
    form.submit();
}
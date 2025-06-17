
let productoActual = null;
function cargarProductoDetalle() {
  const params = new URLSearchParams(window.location.search);
  const id = params.get('id');
  if (!id) return;

  fetch(`../ajax/Productos.php?id=${id}`)
    .then(res => res.json())
    .then(p => {
      if (!p) return;
      productoActual = p;
      const img = document.getElementById('detalle-imagen');
      if (img) {
        img.src = `../assets/img/product-${p.id_producto % 9 + 1}.jpg`;
        img.alt = p.nombre_producto;
      }
      const nombre = document.getElementById('detalle-nombre');
      if (nombre) nombre.textContent = p.nombre_producto;
      const precio = document.getElementById('detalle-precio');
      if (precio) precio.textContent = `$${p.precio}`;
      const desc = document.getElementById('detalle-descripcion');
      if (desc) desc.textContent = p.descripcion;
    })
    .catch(err => console.error('Error al cargar detalle:', err));
}


document.addEventListener('DOMContentLoaded', cargarProductoDetalle);

function prepararBotonCarrito() {
  const btn = document.querySelector('.btn-add-cart');
  if (!btn) return;
  btn.addEventListener('click', e => {
    e.preventDefault();
    if (!productoActual) return;
    const qty = parseInt(document.getElementById('detail-qty').value, 10) || 1;
    addToCart(productoActual, qty);
  });
}

document.addEventListener('DOMContentLoaded', () => {
  cargarProductoDetalle();
  prepararBotonCarrito();
});
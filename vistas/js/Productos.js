let productosTodos = [];
let productosFiltrados = [];
let paginaActual = 1;
const POR_PAGINA = 9;

function cargarProductosShop() {

  fetch('../ajax/Productos.php')
    .then(res => res.json())
    .then(productos => {
      productosTodos = productos;
      productosFiltrados = productos;
      renderProductos();
      agregarListeners();
    })
    .catch(err => console.error('Error al cargar productos:', err));
}

function agregarListeners() {
  const searchInput = document.getElementById('search-input');
  if (searchInput) searchInput.addEventListener('input', aplicarFiltros);
  document.querySelectorAll('[id^="price-"]').forEach(cb => {
    cb.addEventListener('change', aplicarFiltros);
  });
}

function aplicarFiltros() {
  const search = document.getElementById('search-input')?.value.toLowerCase() || '';
  const precios = Array.from(document.querySelectorAll('[id^="price-"]:checked')).map(c => c.id);


  productosFiltrados = productosTodos.filter(p => {
    const coincideBusqueda = p.nombre_producto.toLowerCase().includes(search);
    let coincidePrecio = true;


    if (precios.length && !precios.includes('price-all')) {
      coincidePrecio = precios.some(id => {
        switch (id) {
          case 'price-1':
            return p.precio >= 0 && p.precio <= 100;
          case 'price-2':
            return p.precio > 100 && p.precio <= 200;
          case 'price-3':
            return p.precio > 200 && p.precio <= 300;
          case 'price-4':
            return p.precio > 300 && p.precio <= 400;
          case 'price-5':
            return p.precio > 400 && p.precio <= 500;
          default:
            return true;
        }
      });
    }

    return coincideBusqueda && coincidePrecio;
  });

  paginaActual = 1;
  renderProductos();
}

function renderProductos() {
  const contenedor = document.querySelector('.row.pb-3');
  const plantilla = document.getElementById('template-producto');
  contenedor.querySelectorAll('.col-lg-4.col-md-6.col-sm-6.pb-1').forEach(e => e.remove());

  const inicio = (paginaActual - 1) * POR_PAGINA;
  const productosPagina = productosFiltrados.slice(inicio, inicio + POR_PAGINA);

  productosPagina.forEach(p => {
    const clone = plantilla.content.cloneNode(true);
    clone.querySelector('.product-img').src = `../assets/img/product-${p.id_producto % 9 + 1}.jpg`;
    clone.querySelector('.product-img').alt = p.nombre_producto;
    clone.querySelector('.product-name').textContent = p.nombre_producto;
    clone.querySelector('.product-name').href = `detail.php?id=${p.id_producto}`;
    clone.querySelector('.btn-detail').href = `detail.php?id=${p.id_producto}`;
    clone.querySelector('.product-price').textContent = `$${p.precio}`;
    clone.querySelector('.product-old-price').textContent = `$${(p.precio * 1.2).toFixed(2)}`;
    const btnCart = clone.querySelector('.btn-add-cart');
    btnCart.addEventListener('click', e => {
      e.preventDefault();
      addToCart(p, 1);
    });
    contenedor.appendChild(clone);
  });

  renderPaginacion();
}

function renderPaginacion() {
  const pag = document.getElementById('pagination');
  if (!pag) return;
  pag.innerHTML = '';
  const totalPaginas = Math.ceil(productosFiltrados.length / POR_PAGINA) || 1;

  const prev = document.createElement('li');
  prev.className = `page-item ${paginaActual === 1 ? 'disabled' : ''}`;
  prev.innerHTML = '<a class="page-link" href="#">Previous</a>';
  prev.addEventListener('click', e => {
    e.preventDefault();
    if (paginaActual > 1) {
      paginaActual--;
      renderProductos();
    }
  });
  pag.appendChild(prev);

  for (let i = 1; i <= totalPaginas; i++) {
    const li = document.createElement('li');
    li.className = `page-item ${i === paginaActual ? 'active' : ''}`;
    li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
    li.addEventListener('click', e => {
      e.preventDefault();
      paginaActual = i;
      renderProductos();
    });
    pag.appendChild(li);
  }

  const next = document.createElement('li');
  next.className = `page-item ${paginaActual === totalPaginas ? 'disabled' : ''}`;
  next.innerHTML = '<a class="page-link" href="#">Next</a>';
  next.addEventListener('click', e => {
    e.preventDefault();
    if (paginaActual < totalPaginas) {
      paginaActual++;
      renderProductos();
    }
  });
  pag.appendChild(next);

}

document.addEventListener('DOMContentLoaded', cargarProductosShop);
let ProductisTidis = [];
let productosFiltrados = [];
let paginaActual = 1;
const POR_PAGINA = 9;
function cargarProductos() {
    fetch('../ajax/Productos.php')
        .then(response => response.json())
        .then(productos => {
            productosTodos = productos;
            productosFiltrados = productos;
            renderProductos ();
            agregarListeners();
        })
        .catch(error => console.error('Error al cargar los productos:', error));
}

function agregarListeners() {
    const serchInput = document.querySelectorAll('serch-input');
    if (serchInput){
        document.querySelector('[id^="price-"]').forEach(cb => {
            cb.addEventListener('change', aplicarFiltros);
        })
    }
}
function aplicarFiltros() {
    const search = document.getElementById('search-input')?.toLowerCase() || '';
    const precios = Array.from(document.querySelectorAll('[id^="price-"]:checked')).map(c => c.id);
}

cloneElement.querySelector('product-img').src = `../assets/img/product-${p.id_producto % 9 +1}.jpg`;
cloneElement.querySelector('product-img').alt = p.nombre_producto;
cloneElement.querySelector('product-name').textContent = p.nombre_producto;
cloneElement.querySelector(`product-name`).href = `detail.php?id=${p.id_producto}`;
cloneElement.querySelector(`btn-detail`).href = `detail.php?id=${p.id_producto}`;
cloneElement.querySelector('product-price').textContent = `$${p.precio}`;
cloneElement.querySelector('product-price2').textContent = `$${(p.precio*1.2).toFixed(2)}`;

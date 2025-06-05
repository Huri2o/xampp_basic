-- Tabla: usuarios (compradores y vendedores)
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(150) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    direccion TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla: productos (cada uno tiene un vendedor)
CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre_producto VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    id_usuario INT NOT NULL, -- vendedor
    fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla: categorias
CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre_categoria VARCHAR(100) NOT NULL
);


-- Tabla intermedia: producto_categoria (relación muchos a muchos)
CREATE TABLE producto_categoria (
    id_producto INT,
    id_categoria INT,
    PRIMARY KEY (id_producto, id_categoria)
);

-- Tabla: carrito (productos que el usuario está por comprar)
CREATE TABLE carrito (
    id_carrito INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL, -- comprador
    id_producto INT NOT NULL,
    cantidad INT NOT NULL DEFAULT 1,
    fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla: ordenes (una orden de compra generada)
CREATE TABLE ordenes (
    id_orden INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL, -- comprador
    fecha_orden TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    estado ENUM('pendiente', 'pagado', 'cancelado', 'enviado', 'entregado') DEFAULT 'pendiente'
);

-- Tabla: detalle de orden (productos dentro de una orden)
CREATE TABLE detalle_orden (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_orden INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL
);

-- Claves foráneas con CASCADE
ALTER TABLE productos 
ADD FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE producto_categoria 
ADD FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE producto_categoria 
ADD FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE carrito 
ADD FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE carrito 
ADD FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE ordenes 
ADD FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE detalle_orden 
ADD FOREIGN KEY (id_orden) REFERENCES ordenes(id_orden)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE detalle_orden 
ADD FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
ON DELETE CASCADE ON UPDATE CASCADE;

-- Inserts iniciales
INSERT INTO usuarios (nombre, correo, contrasena, telefono, direccion) VALUES
('Juan Pérez', 'juan@example.com', '123456', '5551234567', 'Av. Siempre Viva 123'),
('Ana López', 'ana@example.com', 'abcdef', '5559876543', 'Calle Luna 456');

INSERT INTO categorias (nombre_categoria) VALUES ('Electrónica'), ('Ropa'), ('Hogar');

INSERT INTO productos (nombre_producto, descripcion, precio, stock, id_usuario) VALUES
('Audífonos Bluetooth', 'Audífonos con cancelación de ruido.', 599.99, 20, 1),
('Camiseta Blanca', 'Camiseta básica de algodón.', 149.50, 100, 2);

INSERT INTO producto_categoria (id_producto, id_categoria) VALUES
(1, 1), (2, 2);

INSERT INTO carrito (id_usuario, id_producto, cantidad) VALUES
(2, 1, 1), (2, 2, 2);

INSERT INTO ordenes (id_usuario, total, estado) VALUES (2, 898.99, 'pagado');

INSERT INTO detalle_orden (id_orden, id_producto, cantidad, precio_unitario) VALUES
(1, 1, 1, 599.99),
(1, 2, 2, 149.50);


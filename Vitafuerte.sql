CREATE TABLE empleados (
    id NUMBER PRIMARY KEY,
    username VARCHAR2(255) NOT NULL, 
    password VARCHAR2(255) NOT NULL,
    email VARCHAR2(255) NOT NULL  
     
);

CREATE SEQUENCE empleados_seq
START WITH 1
INCREMENT BY 1;

create table usuarios (
    id_usuario number primary key,
    cedula VARCHAR2(20) UNIQUE NOT NULL,
    nombre varchar2(50) not null,
    apellido varchar2(50) not null,
    correo varchar2(100) unique not null,
    telefono varchar2(15),
    direccion varchar2(255),
    fecha_registro date
);

CREATE SEQUENCE usuarios_seq
START WITH 1
INCREMENT BY 1;


CREATE TABLE miembros (
    id_miembro NUMBER PRIMARY KEY,
    cedula VARCHAR2(20) NOT NULL,
    activo CHAR(1) DEFAULT 'y',
    costo_mensual NUMBER(10, 2) NOT NULL,
    CONSTRAINT fk_miembro_usuario FOREIGN KEY (cedula) REFERENCES usuarios(cedula)
);

CREATE SEQUENCE miembros_seq
START WITH 1
INCREMENT BY 1;

CREATE TABLE instructores (
    id_instructor INT PRIMARY KEY,
    nombre VARCHAR2(100),
    especialidad VARCHAR2(100),
    telefono VARCHAR2(20),
    correo VARCHAR2(100),
    salario DECIMAL(10,2)
);

CREATE SEQUENCE instructores_seq
START WITH 1
INCREMENT BY 1;

CREATE TABLE clases (
    id_clase INT PRIMARY KEY,
    nombre_clase VARCHAR2(100),
    descripcion VARCHAR2(255),
    id_instructor INT,
    CONSTRAINT fk_clase_instructor FOREIGN KEY (id_instructor) REFERENCES instructores(id_instructor)
);

CREATE SEQUENCE clases_seq
START WITH 1
INCREMENT BY 1;

CREATE TABLE sucursales (
    id_gimnasio INT PRIMARY KEY,
    nombre_sucursal VARCHAR2(100),
    direccion VARCHAR2(255),
    telefono VARCHAR2(20),
    ciudad VARCHAR2(100)
);

CREATE TABLE equipos_gimnasio (
    id_equipo INT PRIMARY KEY,
    nombre VARCHAR2(100),
    tipo VARCHAR2(100),
    estado VARCHAR2(50),
    fecha_compra DATE,
    id_gimnasio INT,
    CONSTRAINT fk_equipo_gimnasio FOREIGN KEY (id_gimnasio) REFERENCES sucursales(id_gimnasio)
);

CREATE SEQUENCE equipos_gimnasio_seq
START WITH 1
INCREMENT BY 1;

CREATE TABLE mantenimiento_equipos (
    id_mantenimiento INT PRIMARY KEY,
    id_equipo INT,
    fecha_mantenimiento DATE,
    descripcion VARCHAR2(255),
    estado VARCHAR2(50),
    CONSTRAINT fk_mantenimiento_equipo FOREIGN KEY (id_equipo) REFERENCES equipos_gimnasio(id_equipo)
);

CREATE SEQUENCE mantenimiento_equipos_seq
START WITH 1
INCREMENT BY 1;

CREATE TABLE productos_tienda (
    id_producto INT PRIMARY KEY,
    nombre_producto VARCHAR2(100),
    precio DECIMAL(10,2),
    stock INT,
    tipo_producto VARCHAR2(100)
);

CREATE SEQUENCE productos_tienda_seq
START WITH 1
INCREMENT BY 1;

CREATE TABLE ventas_tienda (
    id_venta INT PRIMARY KEY,
    id_usuario INT,
    id_producto INT,
    cantidad INT,
    total DECIMAL(10,2),
    fecha_venta DATE,
    CONSTRAINT fk_venta_producto FOREIGN KEY (id_producto) REFERENCES productos_tienda(id_producto),
    CONSTRAINT fk_venta_cliente FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE SEQUENCE ventas_tienda_seq
START WITH 1
INCREMENT BY 1;

CREATE TABLE pagos (
    id_pago INT PRIMARY KEY,
    id_cliente INT,
    id_miembro INT,
    fecha_pago DATE,
    monto DECIMAL(10,2),
    metodo_pago VARCHAR2(50),
    CONSTRAINT fk_pago_cliente FOREIGN KEY (id_cliente) REFERENCES usuarios(id_usuario),
    CONSTRAINT fk_pago_membresia FOREIGN KEY (id_miembro) REFERENCES miembros(id_miembro)
);

CREATE SEQUENCE pagos_seq
START WITH 1
INCREMENT BY 1;


/*Inserciones en la base*/

INSERT INTO usuarios (id_usuario, cedula, nombre, apellido, correo, telefono, direccion, fecha_registro)
VALUES (usuarios_seq.NEXTVAL, '1234567890', 'Juan', 'Pérez', 'juan.perez@example.com', '0991234567', 'Av. Siempre Viva 123', SYSDATE);

INSERT INTO usuarios (id_usuario, cedula, nombre, apellido, correo, telefono, direccion, fecha_registro)
VALUES (usuarios_seq.NEXTVAL, '0987654321', 'María', 'Gómez', 'maria.gomez@example.com', '0987654321', 'Calle Falsa 456', SYSDATE);

INSERT INTO usuarios (id_usuario, cedula, nombre, apellido, correo, telefono, direccion, fecha_registro)
VALUES (usuarios_seq.NEXTVAL, '1122334455', 'Carlos', 'López', 'carlos.lopez@example.com', '0971122334', 'Av. Principal 789', SYSDATE);

INSERT INTO usuarios (id_usuario, cedula, nombre, apellido, correo, telefono, direccion, fecha_registro)
VALUES (usuarios_seq.NEXTVAL, '2233445566', 'Ana', 'Martínez', 'ana.martinez@example.com', '0962233445', 'Boulevard Central 321', SYSDATE);

INSERT INTO usuarios (id_usuario, cedula, nombre, apellido, correo, telefono, direccion, fecha_registro)
VALUES (usuarios_seq.NEXTVAL, '3344556677', 'Pedro', 'Ramírez', 'pedro.ramirez@example.com', '0953344556', 'Sector Norte 654', SYSDATE);


INSERT INTO miembros (id_miembro, cedula, activo, costo_mensual)
VALUES (miembros_seq.NEXTVAL, '1234567890', 'y', 50.00);

INSERT INTO miembros (id_miembro, cedula, activo, costo_mensual)
VALUES (miembros_seq.NEXTVAL, '0987654321', 'y', 45.00);

INSERT INTO miembros (id_miembro, cedula, activo, costo_mensual)
VALUES (miembros_seq.NEXTVAL, '1122334455', 'n', 60.00);

INSERT INTO miembros (id_miembro, cedula, activo, costo_mensual)
VALUES (miembros_seq.NEXTVAL, '2233445566', 'y', 55.00);

INSERT INTO miembros (id_miembro, cedula, activo, costo_mensual)
VALUES (miembros_seq.NEXTVAL, '3344556677', 'n', 40.00);

INSERT INTO instructores (id_instructor, nombre, especialidad, telefono, correo, salario)
VALUES (instructores_seq.NEXTVAL, 'Luis Fernández', 'Entrenamiento Funcional', '0998765432', 'luis.fernandez@example.com', 1500.00);

INSERT INTO instructores (id_instructor, nombre, especialidad, telefono, correo, salario)
VALUES (instructores_seq.NEXTVAL, 'Carla Rodríguez', 'Yoga y Meditación', '0987654321', 'carla.rodriguez@example.com', 1400.00);

INSERT INTO instructores (id_instructor, nombre, especialidad, telefono, correo, salario)
VALUES (instructores_seq.NEXTVAL, 'Pedro Gómez', 'CrossFit', '0976543210', 'pedro.gomez@example.com', 1600.00);

INSERT INTO instructores (id_instructor, nombre, especialidad, telefono, correo, salario)
VALUES (instructores_seq.NEXTVAL, 'Ana Martínez', 'Pilates', '0965432109', 'ana.martinez@example.com', 1350.00);

INSERT INTO instructores (id_instructor, nombre, especialidad, telefono, correo, salario)
VALUES (instructores_seq.NEXTVAL, 'Diego Ramírez', 'Musculación', '0954321098', 'diego.ramirez@example.com', 1700.00);

INSERT INTO clases (id_clase, nombre_clase, descripcion, id_instructor)
VALUES (clases_seq.NEXTVAL, 'Funcional Total', 'Ejercicios de cuerpo completo con intensidad media-alta', 1);

INSERT INTO clases (id_clase, nombre_clase, descripcion, id_instructor)
VALUES (clases_seq.NEXTVAL, 'Yoga Vinyasa', 'Flujo dinámico de posturas con respiración controlada', 2);

INSERT INTO clases (id_clase, nombre_clase, descripcion, id_instructor)
VALUES (clases_seq.NEXTVAL, 'CrossFit Intensivo', 'Entrenamiento de alta intensidad con pesas y cardio', 3);

INSERT INTO clases (id_clase, nombre_clase, descripcion, id_instructor)
VALUES (clases_seq.NEXTVAL, 'Pilates Reformer', 'Ejercicios en máquina Reformer para tonificación y flexibilidad', 4);

INSERT INTO clases (id_clase, nombre_clase, descripcion, id_instructor)
VALUES (clases_seq.NEXTVAL, 'Powerlifting', 'Entrenamiento de fuerza con levantamiento de pesas pesadas', 5);


INSERT INTO sucursales (id_gimnasio, nombre_sucursal, direccion, telefono, ciudad)
VALUES (1, 'Gym Central', 'Av. Principal 123', '0991112222', 'Quito');

INSERT INTO sucursales (id_gimnasio, nombre_sucursal, direccion, telefono, ciudad)
VALUES (2, 'Gym Norte', 'Calle Secundaria 456', '0983334444', 'Guayaquil');

INSERT INTO equipos_gimnasio (id_equipo, nombre, tipo, estado, fecha_compra, id_gimnasio)
VALUES (equipos_gimnasio_seq.NEXTVAL, 'Cinta de correr', 'Cardio', 'Operativo', TO_DATE('2023-05-10', 'YYYY-MM-DD'), 1);

INSERT INTO equipos_gimnasio (id_equipo, nombre, tipo, estado, fecha_compra, id_gimnasio)
VALUES (equipos_gimnasio_seq.NEXTVAL, 'Bicicleta estática', 'Cardio', 'Operativo', TO_DATE('2022-11-15', 'YYYY-MM-DD'), 1);

INSERT INTO equipos_gimnasio (id_equipo, nombre, tipo, estado, fecha_compra, id_gimnasio)
VALUES (equipos_gimnasio_seq.NEXTVAL, 'Máquina de pesas', 'Fuerza', 'Mantenimiento', TO_DATE('2021-08-20', 'YYYY-MM-DD'), 2);

INSERT INTO equipos_gimnasio (id_equipo, nombre, tipo, estado, fecha_compra, id_gimnasio)
VALUES (equipos_gimnasio_seq.NEXTVAL, 'Banco de pesas', 'Fuerza', 'Operativo', TO_DATE('2020-12-05', 'YYYY-MM-DD'), 2);

INSERT INTO equipos_gimnasio (id_equipo, nombre, tipo, estado, fecha_compra, id_gimnasio)
VALUES (equipos_gimnasio_seq.NEXTVAL, 'Remadora', 'Cardio', 'Operativo', TO_DATE('2023-02-18', 'YYYY-MM-DD'), 1);


INSERT INTO mantenimiento_equipos (id_mantenimiento, id_equipo, fecha_mantenimiento, descripcion, estado)
VALUES (mantenimiento_equipos_seq.NEXTVAL, 1, TO_DATE('2024-02-15', 'YYYY-MM-DD'), 'Cambio de banda y lubricación', 'Completado');

INSERT INTO mantenimiento_equipos (id_mantenimiento, id_equipo, fecha_mantenimiento, descripcion, estado)
VALUES (mantenimiento_equipos_seq.NEXTVAL, 3, TO_DATE('2024-03-01', 'YYYY-MM-DD'), 'Revisión general y ajuste de pesas', 'Pendiente');

INSERT INTO mantenimiento_equipos (id_mantenimiento, id_equipo, fecha_mantenimiento, descripcion, estado)
VALUES (mantenimiento_equipos_seq.NEXTVAL, 5, TO_DATE('2024-03-10', 'YYYY-MM-DD'), 'Reemplazo de asiento', 'En progreso');

INSERT INTO productos_tienda (id_producto, nombre_producto, precio, stock, tipo_producto)
VALUES (productos_tienda_seq.NEXTVAL, 'Proteína Whey', 45.00, 20, 'Suplemento');

INSERT INTO productos_tienda (id_producto, nombre_producto, precio, stock, tipo_producto)
VALUES (productos_tienda_seq.NEXTVAL, 'Barra Energética', 2.50, 100, 'Alimento');

INSERT INTO productos_tienda (id_producto, nombre_producto, precio, stock, tipo_producto)
VALUES (productos_tienda_seq.NEXTVAL, 'Guantes de Gimnasio', 15.00, 30, 'Accesorio');

INSERT INTO productos_tienda (id_producto, nombre_producto, precio, stock, tipo_producto)
VALUES (productos_tienda_seq.NEXTVAL, 'Cuerda para saltar', 10.00, 50, 'Accesorio');

INSERT INTO productos_tienda (id_producto, nombre_producto, precio, stock, tipo_producto)
VALUES (productos_tienda_seq.NEXTVAL, 'BCAA Aminoácidos', 30.00, 15, 'Suplemento');

INSERT INTO ventas_tienda (id_venta, id_usuario, id_producto, cantidad, total, fecha_venta)
VALUES (ventas_tienda_seq.NEXTVAL, 1, 1, 1, 45.00, TO_DATE('2024-03-05', 'YYYY-MM-DD'));

INSERT INTO ventas_tienda (id_venta, id_usuario, id_producto, cantidad, total, fecha_venta)
VALUES (ventas_tienda_seq.NEXTVAL, 2, 2, 3, 7.50, TO_DATE('2024-03-06', 'YYYY-MM-DD'));

INSERT INTO ventas_tienda (id_venta, id_usuario, id_producto, cantidad, total, fecha_venta)
VALUES (ventas_tienda_seq.NEXTVAL, 3, 3, 2, 30.00, TO_DATE('2024-03-07', 'YYYY-MM-DD'));

INSERT INTO ventas_tienda (id_venta, id_usuario, id_producto, cantidad, total, fecha_venta)
VALUES (ventas_tienda_seq.NEXTVAL, 4, 4, 1, 10.00, TO_DATE('2024-03-08', 'YYYY-MM-DD'));

INSERT INTO ventas_tienda (id_venta, id_usuario, id_producto, cantidad, total, fecha_venta)
VALUES (ventas_tienda_seq.NEXTVAL, 5, 5, 1, 30.00, TO_DATE('2024-03-09', 'YYYY-MM-DD'));

INSERT INTO pagos (id_pago, id_cliente, id_miembro, fecha_pago, monto, metodo_pago)
VALUES (pagos_seq.NEXTVAL, 1, 1, TO_DATE('2024-03-01', 'YYYY-MM-DD'), 50.00, 'Tarjeta de crédito');

INSERT INTO pagos (id_pago, id_cliente, id_miembro, fecha_pago, monto, metodo_pago)
VALUES (pagos_seq.NEXTVAL, 2, 2, TO_DATE('2024-03-02', 'YYYY-MM-DD'), 45.00, 'Efectivo');

INSERT INTO pagos (id_pago, id_cliente, id_miembro, fecha_pago, monto, metodo_pago)
VALUES (pagos_seq.NEXTVAL, 3, 3, TO_DATE('2024-03-03', 'YYYY-MM-DD'), 60.00, 'Transferencia bancaria');

INSERT INTO pagos (id_pago, id_cliente, id_miembro, fecha_pago, monto, metodo_pago)
VALUES (pagos_seq.NEXTVAL, 4, 4, TO_DATE('2024-03-04', 'YYYY-MM-DD'), 55.00, 'Tarjeta de débito');

INSERT INTO pagos (id_pago, id_cliente, id_miembro, fecha_pago, monto, metodo_pago)
VALUES (pagos_seq.NEXTVAL, 5, 5, TO_DATE('2024-03-05', 'YYYY-MM-DD'), 40.00, 'PayPal');




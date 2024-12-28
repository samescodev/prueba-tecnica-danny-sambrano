USE prueba_tecnica;

-- Ingreso de datos de ejemplo de inicio
INSERT INTO pastel (nombre, descripcion, preparado_por, fecha_creacion, fecha_vencimiento) VALUES 
('Pastel de chocolate', 'Pastel con cobertura de chocolate amargo','Juan Hernandez', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 7 DAY)),
('Pastel de vainilla', 'Pastel clásico con sabor a vainilla', 'Carlos Quinto', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 4 DAY)),
('Pastel de fresa', 'Pastel esponjoso con fesas frescas', 'Ester Rosales', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 3 DAY)),
('Pastel de queso', 'Pastel cremoso con queso fresco', 'Ana Pérez', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 5 DAY)),
('Pastel de manzana', 'Pastel con manzanas frescas y canela', 'Luis Gómez', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 6 DAY)),
('Pastel de miel y nuez', 'Pastel suave con miel natural y nueces', 'María López', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 8 DAY)),
('Pastel de plátano', 'Pastel con plátano maduro y trozos de chocolate', 'Sofía Martínez', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 7 DAY)),
('Pastel de maíz', 'Pastel dulce hecho con harina de maíz', 'José Ramírez', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 10 DAY)),
('Pastel de cacao', 'Pastel de cacao con un toque de chocolate amargo', 'Ricardo Sánchez', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 9 DAY));

INSERT INTO categoria_ingrediente (nombre, descripcion) VALUES 
('Lácteos y derivados', 'Productos derivados de la leche como leche, queso, y mantequilla'),
('Harinas', 'Harinas de trigo, maíz, y otras variedades'),
('Frutas', 'Frutas frescas, secas o procesadas'),
('Endulzantes', 'Azúcar, miel y otros edulcorantes naturales o artificiales'),
('Ingredientes básicos', 'Ingredientes esenciales como huevos, sal y aceites'),
('Cacao y derivados', 'Ingredientes derivados del cacao como chocolate y cocoa'),
('Especias', 'Ingredientes para dar sabor como canela y vainilla'),
('Otros', 'Productos varios');

INSERT INTO ingrediente (nombre, descripcion, fecha_ingreso, fecha_vencimiento, id_categoria_ingrediente) VALUES 
('Harina', 'Harina de trigo', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 6 MONTH), 2),
('Azúcar', 'Azúcar blanca',  CURDATE(), DATE_ADD(CURDATE(), INTERVAL 6 MONTH), 4),
('Huevos', 'Huevos fescos de granja', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 12 DAY), 5),
('Leche', 'Leche entera', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 MONTH), 1),
('Fresas', 'Fresas de temporada',  CURDATE(), DATE_ADD(CURDATE(), INTERVAL 10 DAY), 3),
('Chocolate', 'Chocolate amargo',  CURDATE(), DATE_ADD(CURDATE(), INTERVAL 2 MONTH), 6),
('Vainilla', 'Escencia de vainilla', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 6 MONTH), 7),
('Queso', 'Queso fresco', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 2 MONTH), 1),
('Mantequilla', 'Mantequilla sin sal', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 2 MONTH), 1),
('Maíz', 'Harina de maíz', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 6 MONTH), 2),
('Manzanas', 'Manzanas frescas', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 7 DAY), 3),
('Plátano', 'Plátano maduro', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 5 DAY), 3),
('Miel', 'Miel de abeja natural', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 YEAR), 4),
('Aceite de oliva', 'Aceite de oliva virgen extra', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 YEAR), 5),
('Cacao en polvo', 'Cacao en polvo sin azúcar', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 YEAR), 6),
('Canela', 'Canela en polvo', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 YEAR), 7);


-- Pastel de Chocolate
INSERT INTO pastel_ingredientes (id_pastel, id_ingrediente, cantidad_ingrediente, unidad_medida) VALUES
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de chocolate'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Harina'), 200, 'gramos'),
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de chocolate'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Azúcar'), 150, 'gramos'),
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de chocolate'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Chocolate'), 250, 'gramos');

-- Pastel de Vainilla
INSERT INTO pastel_ingredientes (id_pastel, id_ingrediente, cantidad_ingrediente, unidad_medida) VALUES
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de vainilla'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Harina'), 200, 'gramos'),
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de vainilla'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Azúcar'), 150, 'gramos'),
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de vainilla'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Huevos'), 3, 'unidades'),
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de vainilla'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Leche'), 100, 'mililitros'),
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de vainilla'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Vainilla'), 5, 'mililitros');

-- Pastel de Fresa
INSERT INTO pastel_ingredientes (id_pastel, id_ingrediente, cantidad_ingrediente, unidad_medida) VALUES
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de fresa'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Harina'), 200, 'gramos'),
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de fresa'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Azúcar'), 150, 'gramos'),
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de fresa'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Leche'), 100, 'mililitros'),
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de fresa'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Fresas'), 100, 'gramos');
 
 -- Pastel de Queso
INSERT INTO pastel_ingredientes (id_pastel, id_ingrediente, cantidad_ingrediente, unidad_medida) VALUES
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de queso'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Harina'), 200, 'gramos'),	
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de queso'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Huevos'), 3, 'unidades'),
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de queso'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Leche'), 150, 'mililitros'),
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de queso'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Queso'), 200, 'gramos');

-- Pastel de Manzana
INSERT INTO pastel_ingredientes (id_pastel, id_ingrediente, cantidad_ingrediente, unidad_medida) VALUES
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de manzana'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Harina'), 250, 'gramos'),
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de manzana'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Azúcar'), 180, 'gramos'),
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de manzana'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Manzanas'), 150, 'gramos'),
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de manzana'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Canela'), 5, 'gramos');

-- Pastel de Plátano
INSERT INTO pastel_ingredientes (id_pastel, id_ingrediente, cantidad_ingrediente, unidad_medida) VALUES
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de plátano'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Harina'), 220, 'gramos'),
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de plátano'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Azúcar'), 140, 'gramos'),
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de plátano'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Huevos'), 3, 'unidades'),
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de plátano'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Leche'), 100, 'mililitros'),
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de plátano'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Plátano'), 2, 'piezas'),
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de plátano'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Chocolate'), 50, 'gramos');

-- Pastel de Maíz
INSERT INTO pastel_ingredientes (id_pastel, id_ingrediente, cantidad_ingrediente, unidad_medida) VALUES
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de maíz'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Harina'), 250, 'gramos'),
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de maíz'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Azúcar'), 150, 'gramos'),
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de maíz'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Huevos'), 3, 'unidades'),
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de maíz'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Leche'), 120, 'mililitros'),
((SELECT id_pastel FROM pastel WHERE nombre = 'Pastel de maíz'), 
 (SELECT id_ingrediente FROM ingrediente WHERE nombre = 'Maíz'), 200, 'gramos');
 
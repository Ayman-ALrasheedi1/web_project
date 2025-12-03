الداتا بيس 

-- 1. USERS TABLE (For Login & Sign Up)
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('user', 'admin') DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- --------------------------------------------------------

-- 2. PRODUCTS TABLE (With Stock Management)
CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  category VARCHAR(100) NOT NULL,
  brand VARCHAR(100) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  description TEXT,
  stock_quantity INT DEFAULT 5,  -- New column for stock control
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert Sample Products (Old + New Items)
INSERT INTO products (name, category, brand, price, description, stock_quantity) VALUES
('20-inch Sport Alloy Rims', 'Rims', 'Toyota', 1500.00, 'Matte black, aggressive design for sedans and coupes.', 5),
('19-inch Luxury Chrome Rims', 'Rims', 'Mercedes', 2200.00, 'Chrome finish, luxury style for premium cars.', 2),
('Full Sport Body Kit', 'Body Kit', 'BMW', 3800.00, 'Front, rear and side skirts for a complete sporty look.', 1),
('Carbon Fiber Rear Spoiler', 'Spoiler', 'Toyota', 1100.00, 'Carbon fiber spoiler for better looks and downforce.', 8),
('Sport Exhaust System', 'Exhaust', 'Nissan', 2000.00, 'Deeper sound and improved exhaust flow.', 4),
('Widebody Fender Kit', 'Body Kit', 'Nissan', 5500.00, 'Aggressive widebody kit for GTR and 370z models.', 3),
('Titanium Sport Exhaust', 'Exhaust', 'BMW', 4200.00, 'Lightweight titanium system with blue burnt tips.', 0), -- Out of Stock
('21-inch Forged Rims', 'Rims', 'Mercedes', 9500.00, 'Premium forged wheels, lightweight and super strong.', 4),
('High Kick Trunk Spoiler', 'Spoiler', 'BMW', 1200.00, 'Aggressive high-kick style spoiler in gloss black.', 8),
('Carbon Rear Diffuser', 'Body Kit', 'Mercedes', 2800.00, 'Real carbon fiber diffuser with F1 style brake light.', 0), -- Out of Stock
('Ceramic Coated Exhaust', 'Exhaust', 'Toyota', 1800.00, 'Matte black ceramic coated exhaust tips.', 10);

-- --------------------------------------------------------

-- 3. BUILDS TABLE (For Projects Gallery)
CREATE TABLE IF NOT EXISTS builds (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  car_model VARCHAR(255) NOT NULL,
  mods_list TEXT NOT NULL, 
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert Sample Builds
INSERT INTO builds (title, car_model, mods_list, description) VALUES
('Sport Package for Toyota Camry', 'Toyota Camry', '19-inch black sport rims\nFront and rear body kit\nCarbon fiber rear spoiler', 'Full sport look with an aggressive stance and improved style.'),
('Luxury Package for BMW 5 Series', 'BMW 5 Series', '19-inch chrome luxury rims\nSide skirts and front lip\nSport exhaust system', 'Clean luxury styling with a sport touch and deeper exhaust sound.'),
('Sport Setup for Nissan', 'Nissan Altima', '20-inch alloy rims\nSport exhaust system\nRear spoiler', 'Simple but effective upgrade for a more aggressive look.');

-- --------------------------------------------------------

-- 4. MESSAGES TABLE (For Contact Form)
CREATE TABLE IF NOT EXISTS messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  phone VARCHAR(50),
  car_model_year VARCHAR(255),
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

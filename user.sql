




















CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    phone_number VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL
);

CREATE TABLE user_activity (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    login_time DATETIME NOT NULL,
    logout_time DATETIME DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);


DELIMITER //

CREATE TRIGGER after_user_insert
AFTER INSERT ON users
FOR EACH ROW
BEGIN
    INSERT INTO user_activity (user_id, login_time) 
    VALUES (NEW.user_id, NOW());
END;

//

DELIMITER ;

CREATE TABLE companies (
    company_id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(255) NOT NULL,
    logo LONGBLOB
);

-- Insert sample data into clients table (ensure to add this section if needed)
-- Insert 20 sample users into the users table
INSERT INTO users (phone_number, password, role) VALUES 
('1234567890', 'password_hash_1', 'Admin'),
('1234567891', 'password_hash_2', 'User'),
('1234567892', 'password_hash_3', 'Admin'),
('1234567893', 'password_hash_4', 'User'),
('1234567894', 'password_hash_5', 'Admin'),
('1234567895', 'password_hash_6', 'User'),
('1234567896', 'password_hash_7', 'Admin'),
('1234567897', 'password_hash_8', 'User'),
('1234567898', 'password_hash_9', 'Admin'),
('1234567899', 'password_hash_10', 'User'),
('1234567800', 'password_hash_11', 'Admin'),
('1234567801', 'password_hash_12', 'User'),
('1234567802', 'password_hash_13', 'Admin'),
('1234567803', 'password_hash_14', 'User'),
('1234567804', 'password_hash_15', 'Admin'),
('1234567805', 'password_hash_16', 'User'),
('1234567806', 'password_hash_17', 'Admin'),
('1234567807', 'password_hash_18', 'User'),
('1234567808', 'password_hash_19', 'Admin'),
('1234567809', 'password_hash_20', 'User');

-- Create clients table
CREATE TABLE clients (
    client_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    address1 VARCHAR(255) NOT NULL,
    address2 VARCHAR(255),
    town VARCHAR(100),
    country VARCHAR(100),
    postcode VARCHAR(20),
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data into clients table
INSERT INTO clients (name, email, address1, address2, town, country, postcode, phone) VALUES
('Client A', 'clienta@example.com', '123 Main St', 'Apt 1', 'Townsville', 'Countryland', '12345', '123-456-7890'),
('Client B', 'clientb@example.com', '456 Maple Ave', '', 'Townsville', 'Countryland', '12345', '123-456-7891'),
('Client C', 'clientc@example.com', '789 Oak Dr', 'Suite 2', 'Townsville', 'Countryland', '12345', '123-456-7892'),
('Client D', 'clientd@example.com', '101 Pine St', 'Apt 3', 'Townsville', 'Countryland', '12345', '123-456-7893'),
('Client E', 'cliente@example.com', '202 Birch Rd', '', 'Townsville', 'Countryland', '12345', '123-456-7894'),
('Client F', 'clientf@example.com', '303 Cedar Blvd', 'Apt 4', 'Townsville', 'Countryland', '12345', '123-456-7895'),
('Client G', 'clientg@example.com', '404 Elm St', 'Suite 5', 'Townsville', 'Countryland', '12345', '123-456-7896'),
('Client H', 'clienth@example.com', '505 Spruce Ln', 'Apt 6', 'Townsville', 'Countryland', '12345', '123-456-7897'),
('Client I', 'clienti@example.com', '606 Aspen Way', 'Suite 7', 'Townsville', 'Countryland', '12345', '123-456-7898'),
('Client J', 'clientj@example.com', '707 Willow Ct', 'Apt 8', 'Townsville', 'Countryland', '12345', '123-456-7899'),
('Client K', 'clientk@example.com', '808 Redwood Dr', '', 'Townsville', 'Countryland', '12345', '123-456-7800'),
('Client L', 'clientl@example.com', '909 Fir St', 'Suite 9', 'Townsville', 'Countryland', '12345', '123-456-7801'),
('Client M', 'clientm@example.com', '1010 Cypress Ln', 'Apt 10', 'Townsville', 'Countryland', '12345', '123-456-7802'),
('Client N', 'clientn@example.com', '1111 Maple St', '', 'Townsville', 'Countryland', '12345', '123-456-7803'),
('Client O', 'cliento@example.com', '1212 Oak Ave', 'Suite 11', 'Townsville', 'Countryland', '12345', '123-456-7804'),
('Client P', 'clientp@example.com', '1313 Pine Blvd', 'Apt 12', 'Townsville', 'Countryland', '12345', '123-456-7805'),
('Client Q', 'clientq@example.com', '1414 Birch Rd', '', 'Townsville', 'Countryland', '12345', '123-456-7806'),
('Client R', 'clientr@example.com', '1515 Cedar St', 'Suite 13', 'Townsville', 'Countryland', '12345', '123-456-7807'),
('Client S', 'clients@example.com', '1616 Spruce Dr', 'Apt 14', 'Townsville', 'Countryland', '12345', '123-456-7808'),
('Client T', 'clientt@example.com', '1717 Elm St', '', 'Townsville', 'Countryland', '12345', '123-456-7809');


CREATE TABLE invoices (
    invoice_id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL UNIQUE,
    invoice_number VARCHAR(20) NOT NULL UNIQUE,
    date DATE NOT NULL,
    due_date DATE NOT NULL,
    status ENUM('Unpaid', 'Paid', 'Overdue') DEFAULT 'Unpaid',
        description VARCHAR(255) NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    tax DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    grand_total DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    payment_method ENUM('credit-card', 'bank-transfer', 'paypal') NOT NULL,
    custom_email VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(client_id) ON DELETE CASCADE
);

INSERT INTO invoices (client_id, invoice_number, date, due_date, status, total_amount, tax, grand_total, payment_method, custom_email)
VALUES
(1, 'INV-1001', '2024-08-01', '2024-08-08', 'Paid', 1000.00, 150.00, 1150.00, 'credit-card', 'invoice1@example.com'),
(2, 'INV-1002', '2024-08-02', '2024-08-09', 'Unpaid', 2000.00, 300.00, 2300.00, 'bank-transfer', 'invoice2@example.com'),
(3, 'INV-1003', '2024-08-03', '2024-08-10', 'Overdue', 1500.00, 225.00, 1725.00, 'paypal', 'invoice3@example.com'),
(4, 'INV-1004', '2024-08-04', '2024-08-11', 'Paid', 2500.00, 375.00, 2875.00, 'credit-card', 'invoice4@example.com'),
(5, 'INV-1005', '2024-08-05', '2024-08-12', 'Unpaid', 3000.00, 450.00, 3450.00, 'bank-transfer', 'invoice5@example.com'),
(6, 'INV-1006', '2024-08-06', '2024-08-13', 'Paid', 3500.00, 525.00, 4025.00, 'paypal', 'invoice6@example.com'),
(7, 'INV-1007', '2024-08-07', '2024-08-14', 'Overdue', 4000.00, 600.00, 4600.00, 'credit-card', 'invoice7@example.com'),
(8, 'INV-1008', '2024-08-08', '2024-08-15', 'Unpaid', 4500.00, 675.00, 5175.00, 'bank-transfer', 'invoice8@example.com'),
(9, 'INV-1009', '2024-08-09', '2024-08-16', 'Paid', 5000.00, 750.00, 5750.00, 'paypal', 'invoice9@example.com'),
(10, 'INV-1010', '2024-08-10', '2024-08-17', 'Unpaid', 5500.00, 825.00, 6325.00, 'credit-card', 'invoice10@example.com');



CREATE TABLE invoice_items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT,
    description VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
        tax DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    discount DECIMAL(10, 2) DEFAULT 0.00,
    sub_total DECIMAL(10, 2) AS (quantity * unit_price - discount) STORED,
    FOREIGN KEY (invoice_id) REFERENCES invoices(invoice_id) ON DELETE CASCADE
);

INSERT INTO invoice_items (invoice_id, description, quantity, unit_price, discount)
VALUES
(1, 'Product A', 2, 500.00, 50.00),
(2, 'Product B', 1, 2000.00, 100.00),
(3, 'Product C', 3, 500.00, 75.00),
(4, 'Product D', 5, 500.00, 125.00),
(5, 'Product E', 10, 300.00, 150.00),
(6, 'Product F', 7, 500.00, 175.00),
(7, 'Product G', 8, 500.00, 200.00),
(8, 'Product H', 6, 750.00, 225.00),
(9, 'Product I', 4, 1250.00, 250.00),
(10, 'Product J', 11, 500.00, 275.00),
(1, 'Service A', 1, 200.00, 20.00),
(2, 'Service B', 2, 800.00, 40.00),
(3, 'Service C', 3, 500.00, 60.00),
(4, 'Service D', 4, 500.00, 80.00),
(5, 'Service E', 2, 1500.00, 100.00),
(6, 'Service F', 5, 700.00, 120.00),
(7, 'Service G', 1, 4000.00, 140.00),
(8, 'Service H', 2, 2250.00, 160.00),
(9, 'Service I', 6, 750.00, 180.00),
(10, 'Service J', 3, 2500.00, 200.00);



CREATE TABLE receipts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    receipt_number VARCHAR(20) NOT NULL UNIQUE,  -- Keep this line
    receipt_date DATE NOT NULL,
    due_date DATE NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    tax_rate DECIMAL(5, 2) DEFAULT 0.15,  -- Default tax rate
    tax DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    grand_total DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    payment_method ENUM('credit-card', 'bank-transfer', 'paypal') NOT NULL,
    message TEXT,
    FOREIGN KEY (client_id) REFERENCES clients(client_id)
);



CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);

CREATE TABLE receipt_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    receipt_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    discount DECIMAL(10, 2) DEFAULT 0.00,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (receipt_id) REFERENCES receipts(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);


-- Populate the products table with sample data
INSERT INTO products (name, price) VALUES
('Product A', 100.00),
('Product B', 200.00),
('Product C', 300.00),
('Product D', 400.00),
('Product E', 500.00),
('Product F', 600.00),
('Product G', 700.00),
('Product H', 800.00),
('Product I', 900.00),
('Product J', 1000.00);

-- Populate the receipts table with sample data
INSERT INTO receipts (client_id, receipt_date, due_date, total, payment_method, message)
VALUES
(1, '2024-08-01', '2024-08-08', 1000.00, 'credit-card', 'Payment received in full'),
(2, '2024-08-02', '2024-08-09', 2000.00, 'bank-transfer', 'Pending payment'),
(3, '2024-08-03', '2024-08-10', 1500.00, 'paypal', 'Partial payment received'),
(4, '2024-08-04', '2024-08-11', 1200.00, 'credit-card', 'Payment received in full'),
(5, '2024-08-05', '2024-08-12', 1800.00, 'bank-transfer', 'Pending payment'),
(6, '2024-08-06', '2024-08-13', 1600.00, 'paypal', 'Payment received in full'),
(7, '2024-08-07', '2024-08-14', 1400.00, 'credit-card', 'Partial payment received'),
(8, '2024-08-08', '2024-08-15', 1100.00, 'bank-transfer', 'Pending payment'),
(9, '2024-08-09', '2024-08-16', 1700.00, 'paypal', 'Payment received in full'),
(10, '2024-08-10', '2024-08-17', 1900.00, 'credit-card', 'Partial payment received');

-- Populate the receipt_items table with sample data
INSERT INTO receipt_items (receipt_id, product_id, quantity, discount)
VALUES
(1, 1, 2, 10.00),
(2, 2, 3, 20.00),
(3, 3, 1, 15.00),
(4, 4, 4, 25.00),
(5, 5, 2, 5.00),
(6, 6, 1, 30.00),
(7, 7, 3, 10.00),
(8, 8, 4, 20.00),
(9, 9, 2, 15.00),
(10, 10, 1, 25.00);

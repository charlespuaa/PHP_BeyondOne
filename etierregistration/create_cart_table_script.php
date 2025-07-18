<?php

// Database connection parameters
$servername = "localhost"; // Or your database host
$username = "your_username"; // Your MySQL username
$password = "your_password"; // Your MySQL password
$dbname = "etierrproducts"; // The database name as specified

try {
    // Create a new PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL statement to create the 'cart' table
    $sql = "
    CREATE TABLE `cart` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT NOT NULL,
        `product_id` INT NOT NULL,
        `quantity` INT NOT NULL DEFAULT 1,
        `size` VARCHAR(10) NOT NULL, -- To store selected size (XS, S, M, L, XL)
        `added_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
        CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE,
        UNIQUE (`user_id`, `product_id`, `size`) -- Prevents duplicate entries for the same product and size for a user
    );";

    // Execute the SQL statement
    $conn->exec($sql);
    echo "Table 'cart' created successfully in database '$dbname'.\n";

} catch (PDOException $e) {
    // Catch and display any errors
    echo "Error: " . $e->getMessage() . "\n";
}

// Close the connection (optional, as PHP closes it automatically at script end)
$conn = null;

?>

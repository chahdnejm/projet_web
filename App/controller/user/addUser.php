<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    $dateOfBirth = $_POST["date_of_birth"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Secure password
    $location = $_POST["location"];
    $mobile = $_POST["mobile"];
    $gender = $_POST["gender"];
    $role = $_POST["role"];



    try {
        // Database connection credentials
        $host = "localhost"; // Host (default for XAMPP is localhost)
        $dbName = "purebuzz"; // Replace with your database name
        $username = "root"; // Default XAMPP MySQL username
        $passwordDB = ""; // Default XAMPP MySQL password is empty

        // Connect to MySQL database using PDO
        $dsn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $passwordDB);

        // Set PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL query to insert user data
        $stmt = $pdo->prepare(
            "INSERT INTO users (first_name, last_name, date_of_birth, email, password, location, mobile, gender, role)
             VALUES (:first_name, :last_name, :date_of_birth, :email, :password, :location, :mobile, :gender, :role)"
        );

        // Bind parameters to the query
        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':last_name', $lastName);
        $stmt->bindParam(':date_of_birth', $dateOfBirth);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':mobile', $mobile);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':role', $role);

        // Execute the query
        $stmt->execute();

        echo "User added successfully!";
    } catch (PDOException $e) {
        // Handle PDO exceptions
        die("Database error: " . $e->getMessage());
    }
}
?>

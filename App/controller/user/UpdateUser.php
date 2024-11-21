<?php
// Vérifier si la méthode de requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si l'ID de l'utilisateur est fourni
    if (isset($_POST["id"])) {
        $userId = $_POST["id"];
        $firstName = $_POST["first_name"];
        $lastName = $_POST["last_name"];
        $dateOfBirth = $_POST["date_of_birth"];
        $email = $_POST["email"];
        $mobile = $_POST["mobile"];
        $gender = $_POST["gender"];
        $role = $_POST["role"];
        $location = $_POST["location"];

        try {
            // Connexion à la base de données
            $host = "localhost";
            $dbName = "purebuzz";
            $username = "root";
            $passwordDB = "";

            $dsn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";
            $pdo = new PDO($dsn, $username, $passwordDB);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Préparer la requête de mise à jour
            $stmt = $pdo->prepare(
                "UPDATE users SET 
                    first_name = :first_name,
                    last_name = :last_name,
                    date_of_birth = :date_of_birth,
                    email = :email,
                    mobile = :mobile,
                    gender = :gender,
                    role = :role,
                    location = :location
                 WHERE id = :id"
            );

            // Associer les valeurs des paramètres
            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':date_of_birth', $dateOfBirth);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':mobile', $mobile);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':location', $location);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);

            // Exécuter la requête
            if ($stmt->execute()) {
                // Répondre avec succès
                echo json_encode(["success" => true, "message" => "User updated successfully"]);
            } else {
                // Répondre avec une erreur
                echo json_encode(["success" => false, "message" => "Failed to update user"]);
            }
        } catch (PDOException $e) {
            // Gérer les erreurs de la base de données
            echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "User ID is required"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>

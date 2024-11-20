<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Configuration de la base de données
        $host = "localhost"; // Hôte
        $dbName = "purebuzz"; // Nom de la base de données
        $username = "root"; // Utilisateur MySQL
        $passwordDB = ""; // Mot de passe MySQL

        // Connexion à la base de données avec PDO
        $dsn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $passwordDB);

        // Définir le mode d'erreur PDO sur Exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérifier que les données nécessaires sont envoyées
        if (isset($_POST['id'], $_POST['name'], $_POST['email'], $_POST['tel']) && !empty($_POST['id'])) {
            // Récupération des données POST
            $userId = intval($_POST['id']);
            $name = $_POST['name'];
            $email = $_POST['email'];
            $tel = $_POST['tel'];

            // Préparer la requête de mise à jour
            $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email, tel = :tel WHERE id = :id");
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':tel', $tel, PDO::PARAM_STR);

            // Exécuter la requête
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "User updated successfully."]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to update user."]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "All fields are required (id, name, email, tel)."]);
        }
    } catch (PDOException $e) {
        // Gérer les exceptions PDO
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>

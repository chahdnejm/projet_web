<?php
<?php
// Connexion à la base de données (vous devez remplacer ces valeurs par les vôtres)
$host = 'localhost';       // Adresse du serveur MySQL
$dbname = 'votre_base';    // Nom de la base de données
$username = 'votre_user';  // Nom d'utilisateur MySQL
$password = 'votre_pass';  // Mot de passe MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Définir le mode d'erreur PDO pour afficher les erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Afficher l'erreur si la connexion échoue
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>


// Vérifiez si un ID est passé dans l'URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Préparez la requête pour récupérer les détails de l'utilisateur en fonction de l'ID
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);

    // Exécutez la requête
    $stmt->execute();

    // Récupérer les résultats
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si l'utilisateur existe
    if ($user) {
        // Variables des détails de l'utilisateur
        $firstName = $user['first_name'];
        $lastName = $user['last_name'];
        $email = $user['email'];
        $dateOfBirth = $user['date_of_birth'];
        $role = $user['role'];
    } else {
        // Si l'utilisateur n'existe pas
        echo "Utilisateur non trouvé.";
        exit;
    }
} else {
    // Si l'ID n'est pas passé dans l'URL
    echo "ID non spécifié.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'utilisateur</title>
    <link rel="stylesheet" href="path/to/your/css/style.css"> <!-- Ajoutez le chemin vers votre CSS -->
</head>

<body>
<div class="container">
    <h1>Détails de l'utilisateur</h1>
    <table>
        <tr>
            <th>Prénom</th>
            <td><?php echo htmlspecialchars($firstName); ?></td>
        </tr>
        <tr>
            <th>Nom</th>
            <td><?php echo htmlspecialchars($lastName); ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo htmlspecialchars($email); ?></td>
        </tr>
        <tr>
            <th>Date de naissance</th>
            <td><?php echo htmlspecialchars($dateOfBirth); ?></td>
        </tr>
        <tr>
            <th>Rôle</th>
            <td><?php echo htmlspecialchars($role); ?></td>
        </tr>
    </table>

    <!-- Ajoutez un bouton ou un lien pour revenir à la liste des utilisateurs -->
    <a href="getalluser.php" class="btn">Retour à la liste</a>
</div>
</body>

</html>

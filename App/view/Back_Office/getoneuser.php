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
        $location = $user['location'];
        $mobile = $user['mobile'];
        $gender = $user['gender'];
        // Photo de profil (si elle existe dans la base de données)
        $profilePic = $user['profile_picture'] ? $user['profile_picture'] : 'default-profile.jpg';
    } else {
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
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>User Details</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../../../assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="../../../../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../../../assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../../../../assets/vendors/typicons/typicons.css">
    <link rel="stylesheet" href="../../../../assets/vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="../../../../assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../../../../assets/css/vertical-layout-light/style.css">
    <link rel="shortcut icon" href="../../../../assets/PureBuzzLogo.png" />
</head>

<body>
<div class="container-scroller">
    <!-- Navbar -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
            <div class="me-3">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
            </div>
            <div>
                <a class="navbar-brand brand-logo" href="index.html">
                    <img src="../../../../assets/PureBuzzLogo.png" style="height: 80px;" alt="logo" />
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid page-body-wrapper">
        <div class="main-panel" style="background-color:#FDD670 ">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="home-tab">
                            <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active ps-0" id="home-tab" href="#" role="tab" aria-controls="overview" aria-selected="true">User Details</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content tab-content-basic">
                                <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                                    <div class="row flex-grow">
                                        <div class="col-12 grid-margin stretch-card">
                                            <div class="card card-rounded">
                                                <div class="card-body">
                                                    <div class="table-responsive mt-1">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <th>First Name</th>
                                                                <td><?php echo htmlspecialchars($firstName); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Last Name</th>
                                                                <td><?php echo htmlspecialchars($lastName); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Email</th>
                                                                <td><?php echo htmlspecialchars($email); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Date of Birth</th>
                                                                <td><?php echo htmlspecialchars($dateOfBirth); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Role</th>
                                                                <td><?php echo htmlspecialchars($role); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Gender</th>
                                                                <td><?php echo htmlspecialchars($gender); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Location</th>
                                                                <td><?php echo htmlspecialchars($location); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Mobile</th>
                                                                <td><?php echo htmlspecialchars($mobile); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Profile Picture</th>
                                                                <td>
                                                                    <img src="../../../uploads/<?php echo $profilePic; ?>" alt="Profile Picture" style="height: 80px; width: 80px;">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <a href="getalluser.php" class="btn btn-primary">Back to Users List</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer -->
        <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash.</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2021. All rights reserved.</span>
            </div>
        </footer>
    </div>
</div>
</body>
</html>

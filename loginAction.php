<?php
require_once('database.php');

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Vérifier si l'utilisateur existe et que le mot de passe est correct
    if ($hashed_password !== null && password_verify($password, $hashed_password)) {
        // Authentification réussie, créer une session pour l'utilisateur
        $_SESSION['auth'] = true;
        $_SESSION['id'] = $id;
        $_SESSION['password'] = $password;
        $_SESSION['email'] = $email;
        // Vous pouvez également stocker d'autres informations de l'utilisateur dans la session si nécessaire

        // Rediriger vers une page de succès ou le tableau de bord de l'utilisateur
        echo "Connexion réussie"; 
        exit();
    } else {
        // Identifiants invalides, afficher un message d'erreur
        echo "Identifiants invalides. Veuillez réessayer.";
    }
}
?>
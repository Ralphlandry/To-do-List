<?php
// Paramètres de connexion à la base de données
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'todolist');
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connexion réussie !"; // optionnel pour tester
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Todo List</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; }
        input, button { padding: 0.5rem; margin: 0.5rem 0; }
    </style>
</head>
<body>
    <h1>Ma Todo List</h1>

    <form action="" method="POST">
        <input type="text" name="task" placeholder="Nouvelle tâche" required>
        <button type="submit">Ajouter</button>
    </form>

    <ul>
        <?php
        // Récupérer et afficher les tâches
        $stmt = $pdo->query("SELECT * FROM tasks ORDER BY id DESC");
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($tasks as $task) {
            echo "<li>" . htmlspecialchars($task['title']) . "</li>";
        }
        ?>
    </ul>
</body>
</html>

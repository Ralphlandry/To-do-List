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
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}


// Lire toutes les tâches triées du plus récent au plus ancien
$sql = "SELECT * FROM todo ORDER BY created_at DESC";
$stmt = $pdo->query($sql);

// Convertit les résultats en tableau associatif
$taches = $stmt->fetchAll(PDO::FETCH_ASSOC);




if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ajouter une nouvelle tâche
    if (isset($_POST['action']) && $_POST['action'] === 'new' && !empty($_POST['title'])) {
        $title = trim($_POST['title']);
        $stmt = $pdo->prepare("INSERT INTO todo (title, done, created_at) VALUES (?, 0, NOW())");
        $stmt->execute([$title]);
    }

    // Supprimer une tâche
    if (isset($_POST['action']) && $_POST['action'] === 'delete' && !empty($_POST['id'])) {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM todo WHERE id = ?");
        $stmt->execute([$id]);
    }

    // Basculer le statut "done"
    if (isset($_POST['action']) && $_POST['action'] === 'toggle' && !empty($_POST['id'])) {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("UPDATE todo SET done = 1 - done WHERE id = ?");
        $stmt->execute([$id]);
    }

    // Redirection pour éviter la double soumission du formulaire
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// =======================
// Récupération de la liste des tâches
// =======================
$stmt = $pdo->query("SELECT * FROM todo ORDER BY created_at DESC");
$taches = $stmt->fetchAll(PDO::FETCH_ASSOC);
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



    <!-- Liste des tâches -->
<ul class="list-group mt-4">
    <?php foreach ($taches as $task): ?>
        <?php
        // Choisir la classe selon le statut
        $classe = $task['done'] ? 'list-group-item list-group-item-success' : 'list-group-item list-group-item-warning';
        ?>
        <li class="<?= $classe; ?> d-flex justify-content-between align-items-center">
            <?= htmlspecialchars($task['title']); ?>

            <div>
                <!-- Bouton toggle -->
                <form method="POST" style="display:inline">
                    <input type="hidden" name="action" value="toggle">
                    <input type="hidden" name="id" value="<?= $task['id']; ?>">
                    <button class="btn btn-sm btn-primary">Toggle</button>
                </form>

                <!-- Bouton supprimer -->
                <form method="POST" style="display:inline">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $task['id']; ?>">
                    <button class="btn btn-sm btn-danger">Supprimer</button>
                </form>
            </div>
        </li>
    <?php endforeach; ?>
</ul>


</body>
</html>

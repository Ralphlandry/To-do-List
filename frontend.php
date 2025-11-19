<?php
define('DB_USER' , 'root');
define('DB_PAS', '');
define('DBNAME', 'todolist');
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');

?>

<!DOCTYPE html
<html lang="fr">
<head>
    <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
     <link rel="stylesheet" href="https:                                                                 
        </head>
          <body>
         <nav class="navbar navbar-expand-lg navbar-light bg-light">
         <a class="navbar-brand" href="#">Todo List</a>
                </nav>
                <div class="container">
                 <form class="form-inline" method="post">
                     <input type="text" class="form-control" name="title" placeholder="Nouvelle tâche">
                    <input type="hidden" name="action" value="add">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
                 <ul class="list-group">
                 <?php
                                                                                                                        // Affichage des tâches (à implémenter)
                   ?>
                 </ul>
                 </div>
              </body>
      </html>

<?php

// admin/category/create.php

require '../../bootstrap.php';
/** @var PDO $connection */

use Entity\Category;
use Manager\CategoryManager;

$manager = new CategoryManager($connection);
$category = new Category();

// Si le formulaire a été soumis
if (isset($_POST['category_create'])) {
    // Met à jour la catégorie avec les données saisies par l'internaute
    $category->setTitle($_POST['title']);

    // Insérer dans la base de données
    $manager->persist($category);

    // Rediriger l'internaute vers la page détail
    header('Location: /admin/category/read.php?id=' . $category->getId());
    http_response_code(302);
    exit;
}
?>
<!doctype html>
<html lang="fr">
<head>
    <!-- Head -->
    <?php include PROJECT_ROOT . '/admin/includes/head.php'; ?>
    <title>Administration</title>
</head>
<body>
<!-- Top bar -->
<?php include PROJECT_ROOT . '/admin/includes/topbar.php'; ?>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar bar -->
        <?php include PROJECT_ROOT . '/admin/includes/sidebar.php'; ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Créer une nouvelle catégorie</h1>
            </div>

            <form action="/admin/category/create.php" method="post">
                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Titre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button name="category_create" type="submit" class="btn btn-primary">
                            Enregistrer
                        </button>
                        <a href="/admin/category" class="btn btn-light">
                            Annuler
                        </a>
                    </div>
                </div>
            </form>

        </main>
    </div>
</div>

<!-- Scripts -->
<?php include PROJECT_ROOT . '/admin/includes/scripts.php'; ?>
</html>

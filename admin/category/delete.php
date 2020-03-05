<?php

// admin/category/delete.php

require '../../bootstrap.php';
/** @var PDO $connection */

use Manager\CategoryManager;
use Repository\CategoryRepository;

// Récupère l'ID dans les paramètres d'URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
// Récupère la catégorie correspondant à l'ID
$repository = new CategoryRepository($connection);
if (null === $category = $repository->findOneById($id)) {
    // Page introuvable
    http_response_code(404);
    exit;
}

// Si le formulaire a été soumis et la case de confirmation est cochée
if (isset($_POST['category_delete']) && ($_POST['confirm'] === '1')) {
    // Supprimer la catégorie de la base de données
    $manager = new CategoryManager($connection);
    $manager->remove($category);

    // Rediriger l'internaute vers la page index
    header('Location: /admin/category');
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
                <h1 class="h2">Supprimer la catégorie</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="/admin/category/create.php" class="btn btn-success">
                        Nouvelle catégorie
                    </a>
                </div>
            </div>

            <form action="/admin/category/delete.php?id=<?php echo $category->getId(); ?>" method="post">
                <div class="form-group row">
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="confirm" name="confirm" value="1">
                            <label class="form-check-label" for="confirm">
                                Confirmer la suppression ?
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button name="category_delete" type="submit" class="btn btn-danger">
                            Supprimer
                        </button>
                        <a href="/admin/category/read.php?id=<?php echo $category->getId(); ?>" class="btn btn-light">
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

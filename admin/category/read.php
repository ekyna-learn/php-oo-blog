<?php

// admin/category/read.php

require '../../bootstrap.php';
/** @var PDO $connection */

use Repository\CategoryRepository;

// Récupérer l'identifiant dans les paramètres d'URL ($_GET)
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Utiliser la méthode findOneById() de la classe CategoryRepository
// pour récupérer la catégorie correspondant à l'identifiant
$repository = new CategoryRepository($connection);

$category = $repository->findOneById($id);

// Gérer le cas 404 : 'Catégorie introuvable'
if (null === $category) {
    http_response_code(404);
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
                <h1 class="h2">Détail de la catégorie</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="/admin/category/create.php" class="btn btn-success">
                        Nouvelle catégorie
                    </a>
                </div>
            </div>

            <table class="table">
                <tbody>
                <tr>
                    <th>ID</th>
                    <td>
                        <?php echo $category->getId(); ?>
                    </td>
                </tr>
                <tr>
                    <th>Titre</th>
                    <td>
                        <?php echo $category->getTitle(); ?>
                    </td>
                </tr>
                </tbody>
            </table>

            <p class="text-right">
                <a href="/admin/category/update.php?id=<?php echo $category->getId(); ?>"
                   class="btn btn-sm btn-warning">
                    Modifier
                </a>
                <a href="/admin/category/delete.php?id=<?php echo $category->getId(); ?>"
                   class="btn btn-sm btn-danger">
                    Supprimer
                </a>
            </p>

        </main>
    </div>
</div>

<!-- Scripts -->
<?php include PROJECT_ROOT . '/admin/includes/scripts.php'; ?>
</html>

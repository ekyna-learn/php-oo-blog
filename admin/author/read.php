<?php

// admin/author/read.php

require '../../bootstrap.php';
/** @var PDO $connection */

use Repository\AuthorRepository;

// Récupérer l'identifiant dans les paramètres d'URL ($_GET)
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Utiliser la méthode findOneById() de la classe AuthorRepository
// pour récupérer l'auteur correspondant à l'identifiant
$repository = new AuthorRepository($connection);

$author = $repository->findOneById($id);

// Gérer le cas 404 : 'Auteur introuvable'
if (null === $author) {
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
                <h1 class="h2">Détail de l'auteur</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="/admin/author/create.php" class="btn btn-success">
                        Nouvel auteur
                    </a>
                </div>
            </div>

            <table class="table">
                <tbody>
                <tr>
                    <th>ID</th>
                    <td>
                        <?php echo $author->getId(); ?>
                    </td>
                </tr>
                <tr>
                    <th>Nom</th>
                    <td>
                        <?php echo $author->getName(); ?>
                    </td>
                </tr>
                </tbody>
            </table>

            <p class="text-right">
                <a href="/admin/author/update.php?id=<?php echo $author->getId(); ?>"
                   class="btn btn-sm btn-warning">
                    Modifier
                </a>
                <a href="/admin/author/delete.php?id=<?php echo $author->getId(); ?>"
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

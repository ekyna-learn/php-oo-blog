<?php

// admin/post/read.php

require '../../bootstrap.php';
/** @var PDO $connection */

use Repository\PostRepository;
use Repository\AuthorRepository;
use Repository\CategoryRepository;

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$categoryRepository = new CategoryRepository($connection);
$authorRepository = new AuthorRepository($connection);

$repository = new PostRepository(
    $connection,
    $categoryRepository,
    $authorRepository
);

if (null === $post = $repository->findOneById($id)) {
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
                <h1 class="h2">Détail de l'article</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="/admin/post/create.php" class="btn btn-success">
                        Nouvel article
                    </a>
                </div>
            </div>

            <table class="table">
                <tbody>
                <tr>
                    <th>ID</th>
                    <td>
                        <?php echo $post->getId() ?>
                    </td>
                </tr>
                <tr>
                    <th>Titre</th>
                    <td>
                        <?php echo $post->getTitle() ?>
                    </td>
                </tr>
                <tr>
                    <th>Catégorie</th>
                    <td>
                        <a href="/admin/category/read.php?id=<?php echo $post->getCategory()->getId(); ?>">
                            <?php echo $post->getCategory()->getTitle(); ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>Auteur</th>
                    <td>
                        <a href="/admin/author/read.php?id=<?php echo $post->getAuthor()->getId(); ?>">
                            <?php echo $post->getAuthor()->getName(); ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>Contenu</th>
                    <td>
                        <?php echo $post->getContent(); ?>
                    </td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>
                        <?php echo strftime('%A %e %B %Y', $post->getDate()->getTimestamp()); ?>
                    </td>
                </tr>
                </tbody>
            </table>

            <p class="text-right">
                <a href="/admin/post/update.php?id=<?php echo $post->getId() ?>"
                   class="btn btn-sm btn-warning">
                    Modifier
                </a>
                <a href="/admin/post/delete.php?id=<?php echo $post->getId() ?>"
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

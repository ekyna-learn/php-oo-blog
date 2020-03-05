<?php

// admin/post/index.php

require '../../bootstrap.php';
/** @var PDO $connection */

use Repository\PostRepository;
use Repository\AuthorRepository;
use Repository\CategoryRepository;

$categoryRepository = new CategoryRepository($connection);
$authorRepository = new AuthorRepository($connection);

$repository = new PostRepository(
    $connection,
    $categoryRepository,
    $authorRepository
);

$posts = $repository->findAll();

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
                <h1 class="h2">Articles</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="/admin/post/create.php" class="btn btn-success">
                        Nouvel article
                    </a>
                </div>
            </div>

            <table class="table">
                <thead>
                <tr>
                    <th></th>
                    <th>Titre</th>
                    <th>Catégorie</th>
                    <th>Auteur</th>
                    <th>Date</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($posts as $post) { ?>
                    <tr>
                        <td>
                            <?php echo $post->getId(); ?>
                        </td>
                        <td>
                            <a href="/admin/post/read.php?id=<?php echo $post->getId(); ?>">
                                <?php echo $post->getTitle(); ?>
                            </a>
                        </td>
                        <td>
                            <a href="/admin/category/read.php?id=<?php echo $post->getCategory()->getId() ?>">
                                <?php echo $post->getCategory()->getTitle(); ?>
                            </a>
                        </td>
                        <td>
                            <a href="/admin/author/read.php?id=<?php echo $post->getAuthor()->getId(); ?>">
                                <?php echo $post->getAuthor()->getName(); ?>
                            </a>
                        </td>
                        <td>
                            <?php echo strftime('%A %e %B %Y', $post->getDate()->getTimestamp()); ?>
                        </td>
                        <td class="text-right">
                            <a href="/admin/post/update.php?id=<?php echo $post->getId(); ?>"
                               class="btn btn-sm btn-warning">
                                Modifier
                            </a>
                            <a href="/admin/post/delete.php?id=<?php echo $post->getId(); ?>"
                               class="btn btn-sm btn-danger">
                                Supprimer
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

        </main>
    </div>
</div>

<!-- Scripts -->
<?php include PROJECT_ROOT . '/admin/includes/scripts.php'; ?>
</html>

<?php

// admin/post/update.php

require '../../bootstrap.php';
/** @var PDO $connection */

use Manager\PostManager;
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

if (isset($_POST['post_update'])) {
    $category = $categoryRepository->findOneById($_POST['category']);

    $author = $authorRepository->findOneById($_POST['author']);

    $date = new DateTime($_POST['date']);

    $post
        ->setCategory($category)
        ->setAuthor($author)
        ->setTitle($_POST['title'])
        ->setContent($_POST['content'])
        ->setDate($date);

    $manager = new PostManager($connection);
    $manager->persist($post);

    // Rediriger l'internaute
    header('Location: /admin/post/read.php?id=' . $post->getId());
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
                <h1 class="h2">Modifier l'article</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="/admin/post/create.php" class="btn btn-success">
                        Nouvel article
                    </a>
                </div>
            </div>

            <form action="/admin/post/update.php?id=<?php echo $post->getId() ?>" method="post">

                <?php require __DIR__ . '/_form.php'; ?>

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button name="post_update" type="submit" class="btn btn-primary">
                            Enregistrer
                        </button>
                        <a href="/admin/post/read.php?id=<?php echo $post->getId() ?>" class="btn btn-light">
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
<script src="https://cdn.tiny.cloud/1/mrjmq4qadtxpbjbrzs3dhn0fqy6m7gj28f707yykznc8dr99/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#content',
        menubar: 'edit view format table'
    });
</script>
</html>

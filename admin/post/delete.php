<?php

// admin/post/delete.php

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

$error = '';

// Si le formulaire a été soumis et la case de confirmation est cochée
if (isset($_POST['post_delete'])) {
    if (isset($_POST['confirm']) && ($_POST['confirm'] === '1')) {
        // Supprimer l'auteur de la base de données
        $manager = new PostManager($connection);
        $manager->remove($post);

        // Rediriger l'internaute vers la page index
        header('Location: /admin/post');
        http_response_code(302);
        exit;
    }

    $error = 'Veuillez cocher la case.';
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
                <h1 class="h2">Supprimer l'article</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="/admin/post/create.php" class="btn btn-success">
                        Nouvel article
                    </a>
                </div>
            </div>

            <?php if (!empty($error)) { ?>
                <p class="alert alert-danger"><?php echo $error; ?></p>
            <?php } ?>

            <form action="/admin/post/delete.php?id=<?php echo $post->getId() ?>" method="post">
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
                        <button name="post_delete" type="submit" class="btn btn-danger">
                            Supprimer
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
</html>

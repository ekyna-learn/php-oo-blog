<?php

// admin/author/update.php

require '../../bootstrap.php';
/** @var PDO $connection */

use Manager\AuthorManager;
use Repository\AuthorRepository;

// Récupère l'ID dans les paramètres d'URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
// Récupère l'auteur correspondant à l'ID
$repository = new AuthorRepository($connection);
if (null === $author = $repository->findOneById($id)) {
    // Page introuvable
    http_response_code(404);
    exit;
}

// Si le formulaire a été soumis
if (isset($_POST['author_update'])) {
    // Met à jour l'auteur avec les données saisies par l'internaute
    $author->setName($_POST['name']);

    $manager = new AuthorManager($connection);
    $manager->persist($author);

    // Rediriger l'internaute
    http_response_code(302);
    header('Location: /admin/author/read.php?id=' . $author->getId());
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
                <h1 class="h2">Modifier l'auteur</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="/admin/author/create.php" class="btn btn-success">
                        Nouvel auteur
                    </a>
                </div>
            </div>

            <form action="/admin/author/update.php?id=<?php echo $author->getId(); ?>" method="post">
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Nom</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control"
                               id="name" name="name"
                               value="<?php echo $author->getName(); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button name="author_update" type="submit" class="btn btn-primary">
                            Enregistrer
                        </button>
                        <a href="/admin/author/read.php?id=<?php echo $author->getId(); ?>" class="btn btn-light">
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

<?php

/** @var \Entity\Post $post */

$date = null;
if (null !== $post->getDate()) {
    $date = $post->getDate()->format('Y-m-d');
}

$categoryId = null;
if (null !== $post->getCategory()) {
    $categoryId = $post->getCategory()->getId();
}

$authorId = null;
if (null !== $post->getAuthor()) {
    $authorId = $post->getAuthor()->getId();
}

$categories = $categoryRepository->findAll();
$authors = $authorRepository->findAll();

?>
<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label">Titre</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="title" name="title"
               value="<?php echo $post->getTitle(); ?>">
    </div>
</div>
<div class="form-group row">
    <label for="category" class="col-sm-2 col-form-label">Catégorie</label>
    <div class="col-sm-10">
        <select class="form-control" id="category" name="category">
            <option value="">Choisir</option>
            <?php
            foreach ($categories as $category) {
                $selected = $category->getId() === $categoryId ? ' selected' : '';
            ?>
            <option value="<?php echo $category->getId(); ?>"<?php echo $selected; ?>>
                <?php echo $category->getTitle(); ?>
            </option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group row">
    <label for="author" class="col-sm-2 col-form-label">Auteur</label>
    <div class="col-sm-10">
        <select class="form-control" id="author" name="author">
            <option value="">Choisir</option>
            <?php
            foreach ($authors as $author) {
                $selected = $author->getId() === $authorId ? ' selected' : '';
                ?>
                <option value="<?php echo $author->getId(); ?>"<?php echo $selected; ?>>
                    <?php echo $author->getName(); ?>
                </option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group row">
    <label for="content" class="col-sm-2 col-form-label">Contenu</label>
    <div class="col-sm-10">
        <textarea class="form-control" id="content" name="content"><?php
            echo $post->getContent();
        ?></textarea>
    </div>
</div>
<div class="form-group row">
    <label for="date" class="col-sm-2 col-form-label">Date</label>
    <div class="col-sm-10">
        <input type="date" class="form-control" id="date" name="date"
               value="<?php echo $date; ?>">
    </div>
</div>

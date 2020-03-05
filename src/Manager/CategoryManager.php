<?php

// src/Manager/CategoryManager.php

namespace Manager;

use Entity\Category;

class CategoryManager extends AbstractManager
{
    /**
     * Enregistre une catégorie dans la base de données.
     *
     * @param Category $category
     */
    public function persist(Category $category)
    {
        if (null === $category->getId()) {
            $this->insert($category);

            return;
        }

        $this->update($category);
    }

    /**
     * Supprime une catégorie de la base de données.
     *
     * @param Category $category
     */
    public function remove(Category $category)
    {
        $sql = 'DELETE FROM category WHERE id=:id LIMIT 1';

        $delete = $this->connection->prepare($sql);

        $delete->execute([
            'id' => $category->getId(),
        ]);

        // Supprime l'identifiant
        $category->setId(null);
    }

    /**
     * Insert une catégorie dans la base de données.
     *
     * @param Category $category
     */
    private function insert(Category $category)
    {
        $sql = 'INSERT INTO category(title) VALUES (:title)';

        $insert = $this->connection->prepare($sql);

        $insert->execute([
            'title' => $category->getTitle(),
        ]);

        // Met à jour l'identifiant
        $category->setId($this->connection->lastInsertId());
    }

    /**
     * Met à jour une catégorie dans la base de données.
     *
     * @param Category $category
     */
    private function update(Category $category)
    {
        $sql = 'UPDATE category SET title=:title WHERE id=:id LIMIT 1';

        $update = $this->connection->prepare($sql);

        $update->execute([
            'id'   => $category->getId(),
            'title' => $category->getTitle(),
        ]);
    }
}

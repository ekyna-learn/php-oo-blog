<?php

// src/Repository/CategoryRepository.php

namespace Repository;

use Entity\Category;

class CategoryRepository extends AbstractRepository
{
    /**
     * Récupère toutes les catégories.
     *
     * @return Category[]
     */
    public function findAll(): array
    {
        $sql = 'SELECT id, title FROM category';

        $statement = $this->connection->query($sql);

        $categories = [];

        while (false !== $data = $statement->fetch()) {
            $categories[] = $this->hydrate($data);
        }

        return $categories;
    }

    /**
     * Récupère une catégorie par son identifiant.
     *
     * @param int $id
     *
     * @return Category|null
     */
    public function findOneById(int $id): ?Category
    {
        $sql = 'SELECT id, title FROM category WHERE id=:id LIMIT 1';

        $statement = $this->connection->prepare($sql);

        $statement->execute([
            'id' => $id,
        ]);

        if (false !== $data = $statement->fetch()) {
            return $this->hydrate($data);
        }

        return null;
    }

    /**
     * Converti les données d'une ligne de résultat de la BDD en objet PHP Category.
     *
     * @param array $data
     *
     * @return Category
     */
    private function hydrate(array $data): Category
    {
        $category = new Category();
        $category
            ->setId($data['id'])
            ->setTitle($data['title']);

        return $category;
    }
}

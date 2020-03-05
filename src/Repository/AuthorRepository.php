<?php

// src/Repository/AuthorRepository.php

namespace Repository;

use Entity\Author;

class AuthorRepository extends AbstractRepository
{
    /**
     * Récupère tous les auteurs.
     *
     * @return Author[]
     */
    public function findAll(): array
    {
        $sql = 'SELECT id, name FROM author';

        $statement = $this->connection->query($sql);

        $authors = [];

        while (false !== $data = $statement->fetch()) {
            $authors[] = $this->hydrate($data);
        }

        return $authors;
    }

    /**
     * Récupère un auteur par son identifiant.
     *
     * @param int $id
     *
     * @return Author|null
     */
    public function findOneById(int $id): ?Author
    {
        $sql = 'SELECT id, name FROM author WHERE id=:id LIMIT 1';

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
     * Converti les données d'une ligne de résultat de la BDD en objet PHP Author.
     *
     * @param array $data
     *
     * @return Author
     */
    private function hydrate(array $data): Author
    {
        $author = new Author();
        $author
            ->setId($data['id'])
            ->setName($data['name']);

        return $author;
    }
}

<?php

// src/Manager/AuthorManager.php

namespace Manager;

use Entity\Author;

class AuthorManager extends AbstractManager
{
    /**
     * Enregistre un auteur dans la base de données.
     *
     * @param Author $author
     */
    public function persist(Author $author)
    {
        if (null === $author->getId()) {
            $this->insert($author);

            return;
        }

        $this->update($author);
    }

    /**
     * Supprime un auteur de la base de données.
     *
     * @param Author $author
     */
    public function remove(Author $author)
    {
        $sql = 'DELETE FROM author WHERE id=:id LIMIT 1';

        $delete = $this->connection->prepare($sql);

        $delete->execute([
            'id' => $author->getId(),
        ]);

        // Supprime l'identifiant
        $author->setId(null);
    }

    /**
     * Insert un auteur dans la base de données.
     *
     * @param Author $author
     */
    private function insert(Author $author)
    {
        $sql = 'INSERT INTO author(name) VALUES (:name)';

        $insert = $this->connection->prepare($sql);

        $insert->execute([
            'name' => $author->getName(),
        ]);

        // Met à jour l'identifiant
        $author->setId($this->connection->lastInsertId());
    }

    /**
     * Met à jour un auteur dans la base de données.
     *
     * @param Author $author
     */
    private function update(Author $author)
    {
        $sql = 'UPDATE author SET name=:name WHERE id=:id LIMIT 1';

        $update = $this->connection->prepare($sql);

        $update->execute([
            'id'   => $author->getId(),
            'name' => $author->getName(),
        ]);
    }
}

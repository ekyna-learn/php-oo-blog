<?php

namespace Manager;

use Entity\Post;

class PostManager extends AbstractManager
{
    /**
     * Enregistre un article dans la base de données.
     *
     * @param Post $post
     */
    public function persist(Post $post)
    {
        if (null === $post->getId()) {
            $this->insert($post);

            return;
        }

        $this->update($post);
    }

    /**
     * Supprime un article de la base de données.
     *
     * @param Post $post
     */
    public function remove(Post $post)
    {
        $sql = 'DELETE FROM post WHERE id=:id LIMIT 1';

        $delete = $this->connection->prepare($sql);

        $delete->execute([
            'id' => $post->getId(),
        ]);

        // Supprime l'identifiant
        $post->setId(null);
    }

    /**
     * Insert un article dans la base de données.
     *
     * @param Post $post
     */
    private function insert(Post $post)
    {
        $sql =
            'INSERT INTO post(category_id, author_id, title, content, date) ' .
            'VALUES (:category, :author, :title, :content, :date)';

        $insert = $this->connection->prepare($sql);

        $insert->execute([
            'category' => $post->getCategory()->getId(),
            'author'   => $post->getAuthor()->getId(),
            'title'    => $post->getTitle(),
            'content'  => $post->getContent(),
            'date'     => $post->getDate()->format('Y-m-d'),
        ]);

        // Met à jour l'identifiant
        $post->setId($this->connection->lastInsertId());
    }

    /**
     * Met à jour un article dans la base de données.
     *
     * @param Post $post
     */
    private function update(Post $post)
    {
        $sql =
            'UPDATE post SET ' .
            '    category_id=:category, ' .
            '    author_id=:author, ' .
            '    title=:title, ' .
            '    content=:content, ' .
            '    date=:date ' .
            'WHERE id=:id LIMIT 1';

        $update = $this->connection->prepare($sql);

        $update->execute([
            'id'       => $post->getId(),
            'category' => $post->getCategory()->getId(),
            'author'   => $post->getAuthor()->getId(),
            'title'    => $post->getTitle(),
            'content'  => $post->getContent(),
            'date'     => $post->getDate()->format('Y-m-d'),
        ]);
    }
}

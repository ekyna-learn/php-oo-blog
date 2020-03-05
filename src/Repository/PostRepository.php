<?php

namespace Repository;

use DateTime;
use Entity\Author;
use Entity\Category;
use Entity\Post;
use PDO;

class PostRepository extends AbstractRepository
{
    /** @var CategoryRepository */
    private $categoryRepository;

    /** @var AuthorRepository */
    private $authorRepository;


    /**
     * Constructor.
     *
     * @param PDO                $connection
     * @param CategoryRepository $categoryRepository
     * @param AuthorRepository   $authorRepository
     */
    public function __construct(
        PDO $connection,
        CategoryRepository $categoryRepository,
        AuthorRepository $authorRepository
    ) {
        parent::__construct($connection);

        $this->categoryRepository = $categoryRepository;
        $this->authorRepository = $authorRepository;
    }

    public function findAll(): array
    {
        $sql = 'SELECT id, category_id, author_id, title, content, date FROM post';

        $statement = $this->connection->query($sql);

        $authors = [];

        while (false !== $data = $statement->fetch()) {
            $authors[] = $this->hydrate($data);
        }

        return $authors;
    }

    public function findOneById(int $id): ?Post
    {
        $sql = 'SELECT id, category_id, author_id, title, content, date FROM post WHERE id=:id LIMIT 1';

        $statement = $this->connection->prepare($sql);

        $statement->execute([
            'id' => $id,
        ]);

        if (false !== $data = $statement->fetch()) {
            return $this->hydrate($data);
        }

        return null;
    }

    public function findByAuthor(Author $author): array
    {
         // TODO
    }

    public function findByCategory(Category $category): array
    {
        // TODO
    }

    /**
     * Converti les données d'une ligne de résultat de la BDD en objet PHP Post.
     *
     * @param array $data
     *
     * @return Post
     */
    private function hydrate(array $data): Post
    {
        $category = $this
            ->categoryRepository
            ->findOneById($data['category_id']);

        $author = $this
            ->authorRepository
            ->findOneById($data['author_id']);

        $date = new DateTime($data['date']);

        $post = new Post();
        $post
            ->setId($data['id'])
            ->setCategory($category)
            ->setAuthor($author)
            ->setTitle($data['title'])
            ->setContent($data['content'])
            ->setDate($date);

        return $post;
    }
}

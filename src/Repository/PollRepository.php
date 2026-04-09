<?php

namespace App\Repository;

use App\Db\Mysql;
use App\Entity\Poll;
use PDO;
use App\Repository\CategoryRepository;

class PollRepository
{
    public function __construct() {}


    public function findAll(?int $limit = null): array
    {
        $sql = 'SELECT * FROM poll ORDER BY id DESC';
        if ($limit !== null) {
            $sql .= ' LIMIT ' . intval($limit);
        }

        $stmt = Mysql::getInstance()->getPdo()->query($sql);
        $polls = [];
        // Précharge toutes les catégories pour éviter les requêtes multiples
        $catRepo = new CategoryRepository();
        $categories = [];
        foreach ($catRepo->findAll() as $cat) {
            $categories[$cat->getId()] = $cat;
        }
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $category = $categories[$data['category_id']] ?? null;
            $poll = new Poll(
                $data['id'],
                $data['title'],
                $data['description'],
                $data['user_id'],
                $data['category_id'],
                $category
            );
            $polls[] = $poll;
        }
        return $polls;
    }

    public function find(int $id): ?Poll
    {
        $stmt = Mysql::getInstance()->getPdo()->prepare('SELECT * FROM poll WHERE id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) return null;
        $catRepo = new \App\Repository\CategoryRepository();
        $category = $catRepo->findById($data['category_id']);
        return new Poll(
            $data['id'],
            $data['title'],
            $data['description'],
            $data['user_id'],
            $data['category_id'],
            $category
        );
    }
    
    public function findByCategory(int $categoryId): array
    {
        $sql = 'SELECT * FROM poll WHERE category_id = ? ORDER BY id DESC';
        $stmt = Mysql::getInstance()->getPdo()->prepare($sql);
        $stmt->execute([$categoryId]);
        $polls = [];
        $catRepo = new CategoryRepository();
        $categories = [];
        foreach ($catRepo->findAll() as $cat) {
            $categories[$cat->getId()] = $cat;
        }
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $category = $categories[$data['category_id']] ?? null;
            $poll = new Poll(
                $data['id'],
                $data['title'],
                $data['description'],
                $data['user_id'],
                $data['category_id'],
                $category
            );
            $polls[] = $poll;
        }
        return $polls;
    }

    public function create(Poll $poll): Poll
    {
        $stmt = Mysql::getInstance()->getPdo()->prepare('INSERT INTO poll (title, description, user_id, category_id) VALUES (?, ?, ?, ?)');
        $stmt->execute([
            $poll->getTitle(),
            $poll->getDescription(),
            $poll->getUserId(),
            $poll->getCategoryId()
        ]);
        $poll->setId(Mysql::getInstance()->getPdo()->lastInsertId());
        return $poll;
    }
}


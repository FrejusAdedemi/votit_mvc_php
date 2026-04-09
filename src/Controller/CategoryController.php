<?php
namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PollRepository;

class CategoryController extends Controller {
    public function list() {
        $categoryRepo = new CategoryRepository();
        $categories = $categoryRepo->findAll();
        $this->render('category/list', ['categories' => $categories]);
    }

    public function show() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /category/list');
            exit;
        }

        $categoryRepo = new CategoryRepository();
        $category = $categoryRepo->findById($id);
        if (!$category) {
            header('Location: /category/list');
            exit;
        }

        $pollRepo = new PollRepository();
        $polls = $pollRepo->findByCategory($id);

        $this->render('category/show', [
            'category' => $category,
            'polls' => $polls
        ]);
    }
}

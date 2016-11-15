<?php

namespace App\Contracts\Repositories;


use App\Models\ArticleCategory;

interface ArticleCategoryRepository
{
    public function findById($id);

    public function findAll();

    public function save(ArticleCategory $category);

    public function delete(ArticleCategory $category);
}
<?php

namespace App\Services\Repositories;


use App\Contracts\Repositories\ArticleCategoryRepository;
use App\Models\ArticleCategory;

class ArticleCategoryRepositoryImpl implements ArticleCategoryRepository
{

    public function save(ArticleCategory $category)
    {
        return $category->save();
    }

    public function delete(ArticleCategory $category)
    {
        return $category->delete();
    }

    public function findById($id)
    {
        return ArticleCategory::where('id','=',$id)->first();
    }

    public function findAll()
    {
        return ArticleCategory::all();
    }
}
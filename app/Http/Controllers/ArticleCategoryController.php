<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\ArticleCategoryRepository;
use App\Contracts\Services\AlertMessageService;
use App\Models\ArticleCategory;
use App\Models\User;
use Illuminate\Http\Request;


class ArticleCategoryController extends Controller
{
    private $articleCategoryRepository;

    public function __construct(ArticleCategoryRepository $articleCategoryRepository){
        $this->articleCategoryRepository = $articleCategoryRepository;
        $this->middleware("authorize:".User::TYPE_ADMIN);
    }

    public function getIndex()
    {
        $categories = $this->articleCategoryRepository->findAll();
        return view('article_categories.index',compact('categories'));
    }

    public function getCreate()
    {
        $articleCategory = new ArticleCategory();
        return view('article_categories.create',compact('articleCategory'));
    }

    public function getUpdate($article_category_id)
    {
        $articleCategory = $this->articleCategoryRepository->findById($article_category_id);
        if ($articleCategory === null) abort(404);
        return view('article_categories.update',compact('articleCategory'));
    }

    public function postCreate(Request $request,AlertMessageService $message)
    {
        $this->validate($request,[
            'name' => 'required|unique:article_categories'
        ]);
        $category = new ArticleCategory();
        $category->name = $request->input('name');
        $this->articleCategoryRepository->save($category);
        $message->setSuccess("kategori ditambahkan");
        return redirect()->back();
    }

    public function postUpdate($article_category_id,Request $request,AlertMessageService $message)
    {
        $category = $this->articleCategoryRepository->findById($article_category_id);
        if ($category === null) abort(404);
        $validate_name = ['required'];
        if ($request->input('name') != $category->name){
            array_push($validate_name,'unique:article_categories');
        }
        $this->validate($request,['name'=>$validate_name]);
        $category->name = $request->input('name');
        $this->articleCategoryRepository->save($category);
        $message->setSuccess("kategori diubah");
        return redirect()->back();
    }

    public function getDelete($article_category_id,AlertMessageService $message)
    {
        $category = $this->articleCategoryRepository->findById($article_category_id);
        if ($category === null) abort(404);
        $this->articleCategoryRepository->delete($category);
        $message->setSuccess("kategori dihapus");
        return redirect()->back();
    }
}

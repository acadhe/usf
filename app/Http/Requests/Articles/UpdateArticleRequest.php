<?php

namespace App\Http\Requests\Articles;

use App\Http\Requests\Request;

/**
 * Class UpdateArticleRequest
 * @package App\Http\Requests\Articles
 */
class UpdateArticleRequest extends Request
{
    /**
     * Authorization is in the controller
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $max_image_size = 5200; //5200KB
        return [
            'headerimg'=>['image','mimes:jpeg,bmp,png,gif',"max:$max_image_size"],
            'title' => ['required','string'],
            'content' => ['required','string']
        ];
    }
}

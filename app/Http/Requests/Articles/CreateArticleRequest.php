<?php

namespace App\Http\Requests\Articles;

use App\Http\Requests\Request;

class CreateArticleRequest extends Request
{
    /**
     * Authorization is in the controller
     *
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
        return [
            //
        ];
    }
}

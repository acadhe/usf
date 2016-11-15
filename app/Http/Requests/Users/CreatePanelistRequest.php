<?php
namespace App\Http\Requests\Users;



use App\Http\Requests\Request;

class CreatePanelistRequest extends Request
{
    /**
     * Authorization is in controller
     */
    public function authorize(){
        return true;
    }

    public function rules()
    {
        return [
            'email' => ['required','email','unique:users'],
            'password' => ['required'],
            'name' => ['required'],
            'photo' => ['image','max:2100','mimes:jpeg,bmp,png,gif']//max 2100 kB
        ];
    }
}
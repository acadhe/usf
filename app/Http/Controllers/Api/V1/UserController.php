<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Services\UserService;
use App\Http\Requests\Users\CreatePanelistRequest;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware("authorize:".User::TYPE_ADMIN);
        $this->userService = $userService;
    }

    public function postCreatePanelist(CreatePanelistRequest $request)
    {
        $this->userService->createPanelistFromRequest($request);
        return response()->json(['status'=>'ok']);
    }
}

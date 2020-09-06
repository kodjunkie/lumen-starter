<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    /**
     * @var User
     */
    private $user;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->user = User::query();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = $this->user->latest()->simplePaginate(15);
        return response()->json($users);
    }
}

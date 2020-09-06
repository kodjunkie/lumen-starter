<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @var User
     */
    private $user;

    /**
     * Registration
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users',
            'email' => 'required|email:filter,rfc|max:255|unique:users',
            'phone' => 'required|numeric|digits:11|unique:users',
            'plate' => 'required|unique:users',
            'password' => ['required', 'string', 'min:8'],
        ]);

        $input = $request->all();
        $input['name'] = ucwords($request->name);
        $input['password'] = app('hash')->make($request->password);
        $user = User::query()->create($input);

        return response()->json($user);
    }

    /**
     * Authentication
     * @param Request $request
     * @return mixed
     * @throws AuthenticationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required|min:8'
        ]);

        $credentials = $request->only('email', 'password');
        $user = User::whereEmail($credentials['email'])->first();
        $isValidPassword = app('hash')->check($credentials['password'], $user->password);

        if (!is_null($user) && $isValidPassword) {
            return response()->json($user);
        }

        throw new AuthenticationException('Your credentials does not match our record.');
    }
}

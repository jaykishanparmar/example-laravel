<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\User\UserRepositoryInterface;
use App\Http\Requests\Auth\LoginRequest;

class UserController extends Controller
{
    protected $userRepository;

    function __construct(UserRepositoryInterface $userRepository)
    {
       $this->userRepository = $userRepository;
    }

    public function login(LoginRequest $request)
    {
       try {
          return $this->userRepository->login($request);
       } catch (\Throwable $th) {
          return $this->handleException($th);
       }
    }

    public function validateToken(Request $request)
    {
      try {
         return $this->userRepository->checkLogin($request);
      } catch (\Throwable $th) {
         return $this->handleException($th);
      }
    }


    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

}

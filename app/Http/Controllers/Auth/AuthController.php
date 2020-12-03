<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Interfaces\UserInterfaceRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    protected $request;
    protected $userRepository;

    public function __construct(Request $request,UserInterfaceRepository $userRepositoryInterface)
    {
        $this->request = $request;
        $this->userRepository = $userRepositoryInterface;
    }


    public function login()
    {
        $this->request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $this->request->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user' => new UserResource($user)
        ]);
    }

    public function logout()
    {
        $this->request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function register() {

      $validateAttr =   $this->request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
            'nome' => 'required|string',
            'sobrenome' => 'required|string',
            'telefone' => 'required|string',
        ]);

        $validateAttr['password'] = bcrypt($this->request->password);

        $user = $this->userRepository->create($validateAttr);

        return new UserResource($user);
    }

}

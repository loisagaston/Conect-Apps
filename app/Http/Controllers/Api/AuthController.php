<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }




    /**
         *
         * @OA\Post(
         *     path="/api/login",
         * tags={"Authentication"},
        *     summary="Login",
        *     description="Login",
       *     @OA\Parameter(
     *          name="email",
     *          description="Email Field",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="password",
     *          description="Password",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
    *     @OA\Response(response="200", description="Display a credential User."),
    *     @OA\Response(response="201", description="Successful operation"),
    *     @OA\Response(response="400", description="Bad Request"),
    *     @OA\Response(response="401", description="Unauthenticated"),
    *     @OA\Response(response="403", description="Forbidden")
    * )
    */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

    }

    /**
         *
         * @OA\Post(
         *     path="/api/register",
         *  * tags={"Authentication"},
        *     summary="Register",
        *     description="Register",
          *      @OA\Parameter(
     *          name="name",
     *          description="name Field",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="email",
     *          description="email",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *  @OA\Parameter(
     *          name="password",
     *          description="Password",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *    @OA\Response(response="200", description="Create User credentials"),
    *     @OA\Response(response="201", description="Successful operation"),
    *     @OA\Response(response="400", description="Bad Request"),
    *     @OA\Response(response="401", description="Unauthenticated"),
    *     @OA\Response(response="403", description="Forbidden")
    * )
    */
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    /**
         *
         * @OA\Post(
         *     path="/api/logout",
         *   tags={"Authentication"},
        *     summary="Logout",
        *     description="Logout",
         *     @OA\Response(
         *         response=200,
         *         description="Mostrar credencial User."
         *     ),
         *     @OA\Response(
         *         response="default",
         *         description="Ha ocurrido un error."
         *     )
         * )
         */
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    /**
         *
         * @OA\Post(
         *     path="/api/refresh",
         *     tags={"Authentication"},
        *     summary="Refresh",
        *     description="Refresh",
         *     @OA\Response(
         *         response=200,
         *         description="Mostrar credencial User."
         *     ),
         *     @OA\Response(
         *         response="default",
         *         description="Ha ocurrido un error."
         *     )
         * )
         */
    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}

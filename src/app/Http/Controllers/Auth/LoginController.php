<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\Session\SessionNotCreated;
use App\Exceptions\Session\SessionNotStored;
use App\Exceptions\User\UserNotFound;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Session;
use App\Models\User;
use App\Repositories\Repository;
use App\Repositories\SessionRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    /**
     * @var Repository
     */
    private Repository $repository;

    public function __construct()
    {
        $this->repository = new SessionRepository();
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws SessionNotCreated
     * @throws SessionNotStored
     * @throws UserNotFound
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!$user = (new UserRepository())::getModel()::where('email', $request->email)->first())
            throw new UserNotFound();

        if (!$session = $this->attempts($user, $request->password))
            throw new SessionNotCreated();

        return ResponseHelper::results([
            'message' => trans('auth.login'),
            'user' => [
                'user_id' => (string)$user->_id,
            ],
            'session' => [
                'auth_secure_token' => $session->auth_secure_token,
                'expired_at' => $session->expired_at
            ]
        ]);
    }

    /**
     * @param User $user
     * @param string $password
     * @return Session
     * @throws UserNotFound
     * @throws SessionNotStored
     */
    private function attempts(User $user, string $password): Session
    {
        if (!Hash::check($password, $user->passoword))
            throw new UserNotFound();

        return $this->repository->createSession($user);
    }
}

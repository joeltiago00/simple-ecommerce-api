<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\Session\SessionNotGeted;
use App\Exceptions\Session\SessionNotUpdated;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LogoutRequest;
use App\Repositories\Repository;
use App\Repositories\SessionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;

class LogoutController extends Controller
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
     * @param LogoutRequest $request
     * @return JsonResponse
     * @throws SessionNotGeted
     * @throws SessionNotUpdated
     */
    public function logout(LogoutRequest $request): JsonResponse
    {
        if ($session = $this->repository->getActiveSessionByToken($request->header('auth-secure-token')))
            throw new SessionNotFoundException();

        $this->repository->invalidateSession($session);

        return ResponseHelper::results(['message' => trans('auth.logout')]);
    }
}

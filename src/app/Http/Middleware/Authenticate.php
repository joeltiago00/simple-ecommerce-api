<?php

namespace App\Http\Middleware;

use App\Exceptions\Login\LoginInvalidSession;
use App\Exceptions\User\UserInvalid;
use App\Helpers\ResponseHelper;
use App\Models\Session;
use App\Repositories\SessionRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use MongoDB\BSON\ObjectId;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }

    /**
     * @param $request
     * @param \Closure $next
     * @param ...$guards
     * @return JsonResponse|mixed
     * @throws LoginInvalidSession
     * @throws UserInvalid
     */
    public function handle($request, \Closure $next, ...$guards)
    {
        $token = $request->header('Auth-Secure-Token');

        $validation = Validator::make(
            ['Auth-Secure-Token' => $token],
            [
                'Auth-Secure-Token' => 'required|uuid',
            ]);

        if ($validation->fails())
            return ResponseHelper::unprocessableEntity(['errors' => $validation->errors()]);

        if (!$session = (new SessionRepository())::getModel()::where('auth_secure_token', $token)
            ->where('status', 'active')
            ->where('expired_at', '>', Carbon::now()->format('Y-m-d H:i:s'))
            ->first())
            throw new LoginInvalidSession();

        if (!$user = (new UserRepository())::getModel()::find(new ObjectId($session->user_id)))
            throw new UserInvalid();

        $request->merge([
            'user_id' => $user->_id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_role' => $user->role,
            'session_id' => $session->_id
        ]);

        return $next($request);
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Exceptions\Mail\MailNotSent;
use App\Exceptions\Password\PasswordNotChanged;
use App\Exceptions\Password\PasswordNotUpdated;
use App\Exceptions\Password\PasswordResetHistoryNotCreated;
use App\Exceptions\Password\PasswordResetHistoryNotGenerated;
use App\Exceptions\Password\PasswordResetNotCreated;
use App\Exceptions\Password\PasswordResetNotDeleted;
use App\Exceptions\Password\PasswordResetNotExcluded;
use App\Exceptions\Password\PasswordResetNotFound;
use App\Exceptions\Password\PasswordResetNotGetted;
use App\Exceptions\User\UserNotFound;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserPasswordRequest;
use App\Mail\ForgotPasswordMail;
use App\Models\User;
use App\Repositories\Repository;
use App\Repositories\UserPasswordRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use MongoDB\BSON\ObjectId;

class UserPasswordController extends Controller
{
    /**
     * @var Repository
     */
    private Repository $repository;

    public function __construct()
    {
        $this->repository = new UserPasswordRepository();
    }

    /**
     * @param UserPasswordRequest $request
     * @return JsonResponse
     * @throws MailNotSent
     * @throws PasswordResetNotCreated
     */
    public function generateToken(UserPasswordRequest $request): JsonResponse
    {
        if (!$user = (new UserRepository())::getModel()::where('email', $request->email)->first())
            return ResponseHelper::results(['message' => trans('user.password-reset-requested')]);

        $token = $this->repository->generateToken($user);

        try {
            Mail::to($user->email)->send(new ForgotPasswordMail($user->first_name, $token));
        } catch (\Exception $e) {
            throw new MailNotSent($e);
        }

        return ResponseHelper::results(['message' => trans('user.password-reset-requested')]);
    }

    /**
     * @param UserPasswordRequest $request
     * @param string $token
     * @return JsonResponse
     * @throws UserNotFound
     * @throws PasswordNotChanged
     * @throws PasswordNotUpdated
     * @throws PasswordResetHistoryNotCreated
     * @throws PasswordResetHistoryNotGenerated
     * @throws PasswordResetNotDeleted
     * @throws PasswordResetNotExcluded
     * @throws PasswordResetNotFound
     * @throws PasswordResetNotGetted
     */
    public function resetPassword(UserPasswordRequest $request, string $token): JsonResponse
    {
        $password_reset = $this->repository->getValidToken($token, $request->email);

        if (!$user = (new UserRepository())::getModel()::find(new ObjectId($password_reset->user_id)))
            throw new UserNotFound();

        $this->repository->resetPassword($user, $password_reset, $request->password);

        return ResponseHelper::results(['message' => trans('user.password.updated')]);
    }

    /**
     * @param UserPasswordRequest $request
     * @param User $user
     * @return JsonResponse
     * @throws PasswordNotUpdated
     */
    public function changePassword(UserPasswordRequest $request, User $user): JsonResponse
    {
        //TODO:: implementar validação para ver se o id logado é o mesmo do usuário
        $this->repository->changePassword($user, $request->password, $request->session_id);

        return ResponseHelper::results(['message' => trans('user.password.updated')]);
    }
}

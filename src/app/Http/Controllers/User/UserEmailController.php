<?php

namespace App\Http\Controllers\User;

use App\Exceptions\Mail\MailNotSent;
use App\Exceptions\User\UserEmailChangeNotDeleted;
use App\Exceptions\User\UserEmailChangeNotExcluded;
use App\Exceptions\User\UserEmailChangeNotFound;
use App\Exceptions\User\UserEmailChangeNotGetted;
use App\Exceptions\User\UserEmailChangeNotRequested;
use App\Exceptions\User\UserEmailChangeRequestNotCreated;
use App\Exceptions\User\UserEmailChangeTokenExpired;
use App\Exceptions\User\UserEmailNotChanged;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserEmailRequest;
use App\Mail\UserEmailChangeRequestedMail;
use App\Models\User;
use App\Repositories\Repository;
use App\Repositories\UserEmailRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class UserEmailController extends Controller
{
    /**
     * @var Repository
     */
    private Repository $repository;

    public function __construct()
    {
        $this->repository = new UserEmailRepository();
    }

    /**
     * @param UserEmailRequest $request
     * @param User $user
     * @return JsonResponse
     * @throws MailNotSent
     * @throws UserEmailChangeNotRequested
     * @throws UserEmailChangeRequestNotCreated
     */
    public function requestChangeEmail(UserEmailRequest $request, User $user): JsonResponse
    {
        if (!$token = $this->repository->generateToken($user, $request->new_email))
            throw new UserEmailChangeRequestNotCreated();

        try {
            Mail::to($user->email)->send(new UserEmailChangeRequestedMail($user->name, $token, $request->new_email));
        } catch (\Exception $e) {
            throw new MailNotSent($e);
        }

        return ResponseHelper::results(['message' => trans('user.email.change-requested')]);
    }

    /**
     * @param UserEmailRequest $request
     * @param User $user
     * @return JsonResponse
     * @throws UserEmailChangeNotDeleted
     * @throws UserEmailChangeNotExcluded
     * @throws UserEmailChangeNotFound
     * @throws UserEmailChangeNotGetted
     * @throws UserEmailNotChanged
     * @throws UserEmailChangeTokenExpired
     */
    public function changeEmail(UserEmailRequest $request, User $user): JsonResponse
    {
        $email_change = $this->repository->getValidToken($request->token, $request->new_email);

        $this->repository->changeEmail($email_change, $user);

        return ResponseHelper::results(['message' => trans('user.email.changed')]);
    }
}

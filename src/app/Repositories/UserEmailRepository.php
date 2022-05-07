<?php

namespace App\Repositories;

use App\Exceptions\Mail\MailChangeStatusNotUpdated;
use App\Exceptions\User\UserEmailChangeNotDeleted;
use App\Exceptions\User\UserEmailChangeNotExcluded;
use App\Exceptions\User\UserEmailChangeNotFound;
use App\Exceptions\User\UserEmailChangeNotGetted;
use App\Exceptions\User\UserEmailChangeNotRequested;
use App\Exceptions\User\UserEmailChangeTokenExpired;
use App\Exceptions\User\UserEmailNotChanged;
use App\Models\User;
use App\Models\UserEmailChange;
use App\Types\EmailChangeStatusTypes;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserEmailRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(UserEmailChange::class);
    }

    /**
     * @param UserEmailChange $emailChange
     * @param User $user
     * @return void
     * @throws UserEmailChangeNotDeleted
     * @throws UserEmailChangeNotExcluded
     * @throws UserEmailNotChanged
     */
    public function changeEmail(UserEmailChange $emailChange, User $user): void
    {
        if (!$user->update(['email' => $emailChange->new_user_email]))
            throw new UserEmailNotChanged();

        if (!$this->delete($emailChange))
            throw new UserEmailChangeNotExcluded();

    }

    /**
     * @param User $user
     * @param string $new_email
     * @return string
     * @throws UserEmailChangeNotRequested
     */
    public function generateToken(User $user, string $new_email): string
    {
        try {
            $email_change = $user->emailChange()->create([
                'user_id' => $user->_id,
                'old_user_email' => $user->email,
                'new_user_email' => $new_email,
                'token' => Str::uuid()->toString(),
                'status' => EmailChangeStatusTypes::ACTIVE,
                'expired_at' => Carbon::now()->addMinutes(15)->format('Y-m-d H:i:s'),
                'deleted_at' => null
            ]);
        } catch (\Exception $e) {
            throw new UserEmailChangeNotRequested($e);
        }

        return $email_change->token;
    }

    /**
     * @param string $token
     * @param string $email
     * @return UserEmailChange
     * @throws UserEmailChangeNotGetted
     * @throws UserEmailChangeNotFound
     * @throws UserEmailChangeTokenExpired
     */
    public function getValidToken(string $token, string $email): UserEmailChange
    {
        try {
            if (!$email_change = self::getModel()::where('token', $token)
                ->where('new_user_email', $email)
                ->where('deleted_at', null)
                ->first())
                throw new UserEmailChangeNotFound();

            $expired_at = new Carbon($email_change->expired_at);

            if ($expired_at->lessThan(Carbon::now())) {
                $this->expireToken($email_change);

                throw new UserEmailChangeTokenExpired();
            }
        } catch (\Exception $e) {
            throw new UserEmailChangeNotGetted($e);
        }

        return $email_change;
    }

    /**
     * @param UserEmailChange $emailChange
     * @return bool
     * @throws MailChangeStatusNotUpdated
     */
    private function expireToken(UserEmailChange $emailChange): bool
    {
        try {
            return $emailChange->update(['status' => EmailChangeStatusTypes::EXPIRED]);
        } catch (\Exception $e) {
            throw new MailChangeStatusNotUpdated($e);
        }
    }

    /**
     * @param UserEmailChange $emailChange
     * @return bool
     * @throws UserEmailChangeNotDeleted
     */
    private function delete(UserEmailChange $emailChange): bool
    {
        try {
            return $emailChange->update(['deleted_at' => Carbon::now()->format('Y-m-d H:i:s'), 'status' => EmailChangeStatusTypes::FINISHED]);
        } catch (\Exception $e) {
            throw new UserEmailChangeNotDeleted($e);
        }
    }
}

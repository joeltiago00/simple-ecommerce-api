<?php

namespace App\Repositories;

use App\Exceptions\Password\PasswordNotChanged;
use App\Exceptions\Password\PasswordNotUpdated;
use App\Exceptions\Password\PasswordResetHistoryNotCreated;
use App\Exceptions\Password\PasswordResetHistoryNotGenerated;
use App\Exceptions\Password\PasswordResetNotCreated;
use App\Exceptions\Password\PasswordResetNotDeleted;
use App\Exceptions\Password\PasswordResetNotExcluded;
use App\Exceptions\Password\PasswordResetNotExpired;
use App\Exceptions\Password\PasswordResetNotFound;
use App\Exceptions\Password\PasswordResetNotGetted;
use App\Exceptions\Password\PasswordResetTokenExpired;
use App\Models\PasswordReset;
use App\Models\PasswordResetHistory;
use App\Models\User;
use App\Types\PasswordResetChangeByTypes;
use App\Types\PasswordResetStatusTypes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use MongoDB\BSON\ObjectId;

class UserPasswordRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(PasswordReset::class);
    }

    /**
     * @param User $user
     * @param PasswordReset $passwordReset
     * @param string $new_password
     * @return void
     * @throws PasswordNotChanged
     * @throws PasswordNotUpdated
     * @throws PasswordResetHistoryNotCreated
     * @throws PasswordResetHistoryNotGenerated
     * @throws PasswordResetNotDeleted
     * @throws PasswordResetNotExcluded
     */
    public function resetPassword(User $user, PasswordReset $passwordReset, string $new_password)
    {
        if (!$this->update($user, $new_password))
            throw new PasswordNotChanged();

        if (!$this->createPasswordResetHistory([
            'user_id' => $user->id,
            'changed_by' => PasswordResetChangeByTypes::FORGOT_PASSWORD,
            'password_reset_id' => $passwordReset->_id
        ]))
            throw new PasswordResetHistoryNotGenerated();

        if (!$this->deleteToken($passwordReset))
            throw new PasswordResetNotExcluded();
    }

    /**
     * @param User $user
     * @param string $new_password
     * @param string $session_id
     * @return void
     * @throws PasswordNotUpdated
     */
    public function changePassword(User $user, string $new_password, string $session_id): void
    {
        try {
            if (!$this->update($user, $new_password))
                throw new PasswordNotChanged();

            if (!$this->createPasswordResetHistory([
                'user_id' => $user->id,
                'changed_by' => PasswordResetChangeByTypes::USER,
                'session_id' => $session_id
            ]))
                throw new PasswordResetHistoryNotGenerated();
        } catch (\Exception $e) {
            throw new PasswordNotUpdated($e);
        }
    }

    /**
     * @param User $user
     * @return string
     * @throws PasswordResetNotCreated
     */
    public function generateToken(User $user): string
    {
        try {
            $password_reset = $user->passwordReset()->create([
                'user_id' => new ObjectId((string)$user->_id),
                'user_email' => $user->email,
                'token' => Str::uuid()->toString(),
                'expired_at' => Carbon::now()->addMinutes(15)->format('Y-m-d H:i:s'),
                'deleted_at' => null
            ]);
        } catch (\Exception $e) {
            throw new PasswordResetNotCreated($e);
        }

        return $password_reset->token;
    }

    /**
     * @param string $token
     * @param string $email
     * @return PasswordReset
     * @throws PasswordResetNotGetted
     * @throws PasswordResetNotFound
     */
    public function getValidToken(string $token, string $email): PasswordReset
    {
        try {
            if (!$password_reset = self::getModel()::where('token', $token)
                ->where('user_email', $email)
                ->where('deleted_at', null)
                ->first())
                throw new PasswordResetNotFound();

            $expired_at = new Carbon($password_reset->expired_at);

            if ($expired_at->lessThan(Carbon::now())) {
                $this->expireToken($password_reset);

                throw new PasswordResetTokenExpired();
            }
        } catch (\Exception $e) {
            throw new PasswordResetNotGetted($e);
        }

        return $password_reset;
    }

    /**
     * @param PasswordReset $passwordReset
     * @return bool
     * @throws PasswordResetNotExpired
     */
    private function expireToken(PasswordReset $passwordReset): bool
    {
        try {
            return $passwordReset->update([
                'status' => PasswordResetStatusTypes::EXPIRED,
                'deleted_at' => Carbon::now()->format('Y-m-d H:i:S')
            ]);
        } catch (\Exception $e) {
            throw new PasswordResetNotExpired($e);
        }
    }

    /**
     * @param PasswordReset $passwordReset
     * @return bool
     * @throws PasswordResetNotDeleted
     */
    private function deleteToken(PasswordReset $passwordReset): bool
    {
        try {
            return $passwordReset->update([
                'status' => PasswordResetStatusTypes::FINISHED,
                'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            throw new PasswordResetNotDeleted($e);
        }
    }

    /**
     * @param array $data
     * @return bool
     * @throws PasswordResetHistoryNotCreated
     */
    private function createPasswordResetHistory(array $data): bool
    {
        try {
            return (bool)PasswordResetHistory::create($data);
        } catch (\Exception $e) {
            throw new PasswordResetHistoryNotCreated($e);
        }
    }

    /**
     * @param User $user
     * @param string $new_password
     * @return bool
     * @throws PasswordNotUpdated
     */
    private function update(User $user, string $new_password): bool
    {
        try {
            return $user->update(['password' => Hash::make($new_password)]);;
        } catch (\Exception $e) {
            throw new PasswordNotUpdated($e);
        }
    }
}

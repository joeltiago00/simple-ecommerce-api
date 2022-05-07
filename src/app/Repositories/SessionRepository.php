<?php

namespace App\Repositories;

use App\Exceptions\Session\SessionNotGeted;
use App\Exceptions\Session\SessionNotStored;
use App\Exceptions\Session\SessionNotUpdated;
use App\Models\Session;
use App\Models\User;
use App\Types\GeneralStatusTypes;
use App\Types\LoginDisabledAtTypes;
use Carbon\Carbon;
use Illuminate\Support\Str;
use MongoDB\BSON\ObjectId;
use MongoDB\Collection;

class SessionRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(Session::class);
    }

    /**
     * @param User $user
     * @return Session
     * @throws SessionNotStored
     */
    public function createSession(User $user): Session
    {
        try {
            $session = $user->session()->create([
                'user_id' => new ObjectId($user->_id),
                'auth_secure_token' => Str::uuid()->toString(),
                'expired_at' => Carbon::now()->addHours(3),
                'disabled_by' => null,
                'disabled_by_session_id' => null,
            ]);

            $this->invalidateSessionsByUser($user, $session);
        } catch (\Exception $e) {
            throw new SessionNotStored($e);
        }

        return $session;
    }

    /**
     * @param User $user
     * @param Session $session
     * @return void
     * @throws SessionNotUpdated
     */
    private function invalidateSessionsByUser(User $user, Session $session)
    {
        try {
            self::getModel()::where('_id', '<>', new ObjectId($session->_id))
            ->where('user_id', new ObjectId($user->_id))
                ->where('status', GeneralStatusTypes::ACTIVE)
                ->update([
                    'status' => GeneralStatusTypes::INACTIVE,
                    'disabled_by' => LoginDisabledAtTypes::LOGIN,
                    'disabled_by_session_id' => new ObjectId($session->_id)
                ]);
        } catch (\Exception $e) {
            throw new SessionNotUpdated($e);
        }
    }

    /**
     * @param string $token
     * @return Session
     * @throws SessionNotGeted
     */
    public function getActiveSessionByToken(string $token): Session
    {
        try {
            return self::getModel()::where('auth_secure_token', $token)
                ->where('status', GeneralStatusTypes::ACTIVE)
                ->where('expired_at', '>', Carbon::now())
                ->first();
        } catch (\Exception $e) {
        throw new SessionNotGeted($e);
        }
    }

    /**
     * @param Session $session
     * @return void
     * @throws SessionNotUpdated
     */
    public function invalidateSession(Session $session)
    {
        try {
            $session->update([
                'status' => GeneralStatusTypes::INACTIVE,
                'disabled_by' => LoginDisabledAtTypes::LOGIN,
                'disabled_by_session_id' => new ObjectId($session->_id)
            ]);
        } catch (\Exception $e) {
            throw new SessionNotUpdated($e);
        }
    }
}

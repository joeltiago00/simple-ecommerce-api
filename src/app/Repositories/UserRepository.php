<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\User\Contracts\UserInterface;
use App\Exceptions\User\UserImageProfileHistoryNotCreated;
use App\Exceptions\User\UserImageProfileNotSetted;
use App\Exceptions\User\UserImageProfileNotUpdated;
use App\Exceptions\User\UserNotInactivated;
use App\Exceptions\User\UserNotStored;
use App\Exceptions\User\UserNotUpdated;
use App\Models\User;
use App\Types\UserStatusTypes;
use MongoDB\BSON\ObjectId;

class UserRepository extends Repository
{

    public function __construct()
    {
        $this->setModel(User::class);
    }

    /**
     * @param UserInterface $user
     * @return User
     * @throws UserNotStored
     */
    public function store(UserInterface $user): User
    {
        try {
            return self::getModel()::create([
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'status' => $user->getStatus(),
                'email_verified' => $user->getEmailVerified(),
                'email_verified_at' => null
            ]);
        } catch (\Exception $e) {
            throw new UserNotStored($e);
        }
    }

    /**
     * @param User $user
     * @param string|null $first_name
     * @param string|null $last_name
     * @return bool
     * @throws UserNotUpdated
     */
    public function changeName(User $user, string $first_name = null, string $last_name = null): bool
    {
        try {
            return $user->update([
                'first_name' => $first_name ?? $user->first_name,
                'last_name' => $last_name ?? $user->last_name
            ]);
        } catch (\Exception $e) {
            throw new UserNotUpdated($e);
        }
    }

    /**
     * @param User $user
     * @return bool
     * @throws UserNotInactivated
     */
    public function inactiveUser(User $user): bool
    {
        try {
            return $user->update(['status' => UserStatusTypes::INACTIVE]);
        } catch (\Exception $e) {
            throw new UserNotInactivated($e);
        }
    }

    /**
     * @param User $user
     * @param object $data
     * @return void
     * @throws UserImageProfileNotSetted
     */
    public function setImageProfile(User $user, object $data): void
    {
        try {
            $old_image = $user->image_profile['url'] ?? null;

            if (!$user->update(['image_profile' => [
                'url' => sprintf('%s?versionid=%s', $data->url, $data->version_id)
                    ]
                ])
            )
                throw new UserImageProfileNotUpdated();

            if ($user->imageProfileHistory()->create([
                'user_id' => new ObjectId($user->_id),
                'old_image' => $old_image,
                'new_image' => $user->image_profile['url']
                ])
            )
                throw new UserImageProfileHistoryNotCreated();

        } catch (\Exception $e) {
            throw new UserImageProfileNotSetted($e);
        }
    }
}

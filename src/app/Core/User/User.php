<?php
declare(strict_types=1);
namespace App\Core\User;

use App\Core\User\Contracts\UserInterface;
use App\Types\UserStatusTypes;
use Illuminate\Support\Facades\Hash;

class User implements UserInterface
{
    /**
     * @var string
     */
    private string $first_name;
    /**
     * @var string
     */
    private string $last_name;
    /**
     * @var string
     */
    private string $email;
    /**
     * @var string
     */
    private string $password;
    /**
     * @var string
     */
    private string $role;
    /**
     * @var string
     */
    private string $status;
    /**
     * @var bool
     */
    private bool $email_verified;
    /**
     * @var string
     */
    private string $email_verified_at;

    /**
     * @param string $first_name
     * @param string $last_name
     * @param string $email
     * @param string $password
     * @param string $role
     * @param string $status
     * @param bool $email_verified
     * @param string $email_verified_at
     */
    public function __construct(
        string $first_name, string $last_name, string $email, string $password, string $role = 'user', string $status = UserStatusTypes::ACTIVE,
        bool   $email_verified = false, string $email_verified_at = '',
    )
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = Hash::make($password);
        $this->role = $role;
        $this->status = $status;
        $this->email_verified = $email_verified;
        $this->email_verified_at = $email_verified_at;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return bool
     */
    public function getEmailVerified(): bool
    {
        return $this->email_verified;
    }

    /**
     * @return string
     */
    public function getEmailVerifiedAt(): string
    {
        return $this->email_verified_at;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }
}

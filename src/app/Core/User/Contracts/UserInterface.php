<?php

namespace App\Core\User\Contracts;

interface UserInterface
{
    public function getFirstName(): string;

    public function getLastName(): string;

    public function getEmail(): string;

    public function getPassword(): string;

    public function getRole(): string;

    public function getStatus(): string;

    public function getEmailVerified(): bool;

    public function getEmailVerifiedAt(): string;
}

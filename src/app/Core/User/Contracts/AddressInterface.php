<?php

namespace App\Core\User\Contracts;

interface AddressInterface
{
    public function getType(): string;

    public function getUserId(): string;

    public function getStreet(): string;

    public function getNumber(): string;

    public function getNeighborhood(): string;

    public function getCity(): string;

    public function getState(): string;

    public function getCountry(): string;

    public function getZipcode(): string;

    public function getComplement(): string;

}

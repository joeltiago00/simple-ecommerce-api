<?php

namespace App\Core\User;

use App\Core\User\Contracts\AddressInterface;

class Address implements AddressInterface
{
    /**
     * @var string
     */
    private string $user_id;
    /**
     * @var string
     */
    private string $street;
    /**
     * @var string
     */
    private string $number;
    /**
     * @var string
     */
    private string $neighborhood;
    /**
     * @var string
     */
    private string $city;
    /**
     * @var string
     */
    private string $state;
    /**
     * @var string
     */
    private string $country;
    /**
     * @var string
     */
    private string $zipcode;
    /**
     * @var string
     */
    private string $complement;

    /**
     * @param string $user_id
     * @param string $street
     * @param string $number
     * @param string $neighborhood
     * @param string $city
     * @param string $state
     * @param string $country
     * @param string $zipcode
     * @param string|null $complement
     */
    public function __construct(
        string $user_id, string $street, string $number, string $neighborhood,
        string $city, string $state, string $country, string $zipcode, string $complement = null
    )
    {
        $this->user_id = $user_id;
        $this->street = $street;
        $this->number = $number;
        $this->neighborhood = $neighborhood;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
        $this->zipcode = $zipcode;
        $this->complement = $complement;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getNeighborhood(): string
    {
        return $this->neighborhood;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getZipcode(): string
    {
        return $this->zipcode;
    }

    /**
     * @return string
     */
    public function getComplement(): string
    {
        return $this->complement;
    }
}

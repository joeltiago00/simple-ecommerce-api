<?php

namespace App\Repositories;

use App\Core\User\Contracts\AddressInterface;
use App\Exceptions\Address\AddressNotDeleted;
use App\Exceptions\Address\AddressNotStored;
use App\Exceptions\Address\AddressNotUpdated;
use App\Models\Address;

class AddressRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(Address::class);
    }

    /**
     * @param AddressInterface $address
     * @return bool
     * @throws AddressNotStored
     */
    public function store(AddressInterface $address): bool
    {
        try {
            return (bool)self::getModel()::create([
                'user_id' => $address->getUserId(),
                'street' => $address->getStreet(),
                'number' => $address->getNumber(),
                'neighborhood' => $address->getNeighborhood(),
                'city' => $address->getCity(),
                'state' => $address->getState(),
                'zipcode' => $address->getZipcode(),
                'country' => $address->getCountry(),
                'complement' => $address->getComplement(),
                'deleted_at' => null
            ]);
        } catch (\Exception $e) {
            throw new AddressNotStored($e);
        }
    }

    /**
     * @param Address $address
     * @param array $data
     * @return bool
     * @throws AddressNotUpdated
     */
    public function update(Address $address, array $data): bool
    {
        try {
            return $address->update($data);
        } catch (\Exception $e) {
            throw new AddressNotUpdated($e);
        }
    }

    /**
     * @param Address $address
     * @return bool
     * @throws AddressNotDeleted
     */
    public function delete(Address $address): bool
    {
        try {
            return $address->delete();
        } catch (\Exception $e) {
            throw new AddressNotDeleted($e);
        }
    }
}

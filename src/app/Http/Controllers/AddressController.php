<?php

namespace App\Http\Controllers;

use App\Core\User\Address;
use App\Exceptions\Address\AddressNotChanged;
use App\Exceptions\Address\AddressNotCreated;
use App\Exceptions\Address\AddressNotDeleted;
use App\Exceptions\Address\AddressNotExcluded;
use App\Exceptions\Address\AddressNotStored;
use App\Exceptions\Address\AddressNotUpdated;
use App\Helpers\ResponseHelper;
use App\Http\Requests\AddressRequest;
use App\Models\User;
use App\Repositories\AddressRepository;
use App\Repositories\Repository;
use Illuminate\Http\JsonResponse;

class AddressController extends Controller
{
    /**
     * @var Repository
     */
    private Repository $repository;

    public function __construct()
    {
        $this->repository = new AddressRepository();
    }

    /**
     * @param AddressRequest $request
     * @param User $user
     * @return JsonResponse
     * @throws AddressNotCreated
     * @throws AddressNotStored
     */
    public function store(AddressRequest $request, User $user): JsonResponse
    {
        $address = new Address((string)$user->_id, $request->address['street'], $request->address['number'],
            $request->address['neighborhood'], $request->address['city'], $request->address['state'],
            $request->address['country'], $request->address['zipcode'],
            $request->address['complement'] ?? null);

        if (!$this->repository->store($address))
            throw new AddressNotCreated();

        return ResponseHelper::created(['message' => trans('user.address.created')]);
    }

    /**
     * @param AddressRequest $request
     * @param \App\Models\Address $address
     * @return JsonResponse
     * @throws AddressNotChanged
     * @throws AddressNotUpdated
     */
    public function update(AddressRequest $request, \App\Models\Address $address): JsonResponse
    {
        if (!$this->repository->update($address, $request->address))
            throw new AddressNotChanged();

        return ResponseHelper::results(['message' => trans('user.address.updated')]);
    }

    /**
     * @param \App\Models\Address $address
     * @return JsonResponse
     * @throws AddressNotExcluded
     * @throws AddressNotDeleted
     */
    public function delete(\App\Models\Address $address): JsonResponse
    {
        if (!$this->repository->delete($address))
            throw new AddressNotExcluded();

        return ResponseHelper::results(['message' => trans('user.address.deleted')]);
    }
}

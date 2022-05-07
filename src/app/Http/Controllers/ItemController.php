<?php

namespace App\Http\Controllers;

use App\Core\Shop\Item;
use App\Exceptions\Argument\NoneArgument;
use App\Exceptions\Item\ItemNotChanged;
use App\Exceptions\Item\ItemNotCreated;
use App\Exceptions\Item\ItemNotDeleted;
use App\Exceptions\Item\ItemNotExcluded;
use App\Exceptions\Item\ItemNotStored;
use App\Exceptions\Item\ItemNotUpdated;
use App\Helpers\ResponseHelper;
use App\Http\Requests\ItemRequest;
use App\Models\Item as ItemModel;
use App\Repositories\ItemRepository;
use App\Repositories\Repository;
use Illuminate\Http\JsonResponse;

class ItemController extends Controller
{
    /**
     * @var Repository
     */
    private Repository $repository;

    public function __construct()
    {
        $this->repository = new ItemRepository();
    }

    /**
     * @param ItemRequest $request
     * @return JsonResponse
     * @throws ItemNotCreated
     * @throws ItemNotStored
     */
    public function store(ItemRequest $request): JsonResponse
    {
        $item = new Item(
            $request->name,
            $request->price,
            $request->quantity,
            $request->category,
            $request->specifications['is_physical'],
            $request->specifications['weight'] ?? 0,
            $request->specifications['color'],
            $request->specifications['brand'],
            $request->specifications['model'],
            $request->description,
        );

        if (!$model = $this->repository->store($item))
            throw new ItemNotCreated();

        return ResponseHelper::created(['_id' => $model->_id]);
    }

    /**
     * @param ItemModel $item
     * @param ItemRequest $request
     * @return JsonResponse
     * @throws ItemNotChanged
     * @throws NoneArgument
     * @throws ItemNotUpdated
     */
    public function update(ItemModel $item, ItemRequest $request): JsonResponse
    {
        if (!$this->repository->update($item, $request->all()))
            throw new ItemNotChanged();

        return ResponseHelper::results(['_id' => $item->_id]);
    }

    /**
     * @param ItemModel $item
     * @return JsonResponse
     * @throws ItemNotExcluded
     * @throws ItemNotDeleted
     */
    public function delete(ItemModel $item): JsonResponse
    {
        if (!$this->repository->delete($item))
            throw new ItemNotExcluded();

        return ResponseHelper::noContent();
    }
}

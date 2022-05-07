<?php

namespace App\Repositories;

use App\Core\Shop\Contracts\ItemInterface;
use App\Exceptions\Argument\NoneArgument;
use App\Exceptions\Item\ItemNotDeleted;
use App\Exceptions\Item\ItemNotStored;
use App\Exceptions\Item\ItemNotUpdated;
use App\Models\Item;

class ItemRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(Item::class);
    }

    /**
     * @param ItemInterface $item
     * @return Item
     * @throws ItemNotStored
     */
    public function store(ItemInterface $item): Item
    {
        try {
            return self::getModel()::create([
                'name' => $item->getName(),
                'price' => $item->getPrice(),
                'quantity' => $item->getQuantity(),
                'category' => $item->getCategory(),
                'specifications' => [
                    'is_physical' => $item->isPhysical(),
                    'weight' => $item->getWeight(),
                    'color' => $item->getColor(),
                    'brand' => $item->getBrand(),
                    'model' => $item->getModel(),
                ],
                'description' => $item->getDescription(),
            ]);
        } catch (\Exception $e) {
            throw new ItemNotStored($e);
        }
    }

    /**
     * @param Item $item
     * @param array $data
     * @return bool
     * @throws ItemNotUpdated
     * @throws NoneArgument
     */
    public function update(Item $item, array $data): bool
    {
        if (empty($data))
            throw new NoneArgument();

        try {
            return $item->update([
                'name' => $data['name'] ?? $item->name,
                'price' => $data['price'] ?? $item->price,
                'quantity' => $data['quantity'] ?? $item->quantity,
                'category' => $data['category'] ?? $item->category,
                'specifications' => [
                    'is_physical' => $data['specifications']['is_physical'] ?? $item->specifications['is_physical'],
                    'weight' => $data['specifications']['weight'] ?? $item->specifications['weight'],
                    'color' => $data['specifications']['color'] ?? $item->specifications['color'],
                    'brand' => $data['specifications']['brand'] ?? $item->specifications['brand'],
                    'model' => $data['specifications']['model'] ?? $item->specifications['model'],
                ],
                'description' => $data['description'] ?? $item->description,
            ]);
        } catch (\Exception $e) {
            throw new ItemNotUpdated($e);
        }
    }

    /**
     * @param Item $item
     * @return bool
     * @throws ItemNotDeleted
     */
    public function delete(Item $item): bool
    {
        try {
            return (bool)$item->delete();
        } catch (\Exception $e){
            throw new ItemNotDeleted($e);
        }
    }
}

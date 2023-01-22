<?php


namespace App\Repositories;


use App\Interfaces\SupplierInterface;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SupplierRepository implements SupplierInterface
{
    private \Illuminate\Database\Eloquent\Builder $model;

    public function __construct()
    {
        $this->model = Supplier::query();
    }

    public function index(): Collection
    {
        return $this->model->latest()->get();
    }

    public function create($name, $email, $phone, $address, $shop_name): Model
    {
        return $this->model->create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'shop_name' => $shop_name,
        ]);
    }

    public function show($id): Model
    {
        return $this->model->find($id)->first();
    }

    public function findId($id): Model
    {
        return $this->model->find($id)->first();
    }

    public function destroy($id): bool
    {
        return $this->model->find($id)->delete();
    }

}

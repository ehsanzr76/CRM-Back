<?php


namespace App\Repositories;


use App\Interfaces\CategoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository implements CategoryInterface
{
    private Builder $model;

    public function __construct()
    {
        $this->model = Category::query();
    }

    public function index(): Collection
    {
        return $this->model->latest()->get();
    }

    public function create($name): Model
    {
        return $this->model->create([
           'name'=>$name
        ]);

    }

    public function show($id): Model
    {
        return $this->model->where('id' ,$id)->first();
    }

    public function update($id,$name): bool
    {
        return $this->model->find($id)->update([
           'name'=>$name
        ]);
    }

    public function destroy($id): bool
    {
        return $this->model->find($id)->delete();
    }

}

<?php


namespace App\Repositories;


use App\Interfaces\CategoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository implements CategoryInterface
{
    private \Illuminate\Database\Eloquent\Builder $model;

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

}

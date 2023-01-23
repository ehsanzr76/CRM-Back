<?php


namespace App\Repositories;


use App\Interfaces\ProductInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductRepository implements ProductInterface
{

    private Builder $model;

    public function __construct()
    {
        $this->model = Product::query();
    }

    public function index(): Collection
    {
        return $this->model->select()->with(['category','supplier'])->latest()->get();
    }

    public function create($name,$buying_price,$selling_price,$quantity,$buying_date,$product_code,$root,$category_id,$supplier_id): Model
    {
        $this->model->create([
           'name'=>$name,
           'buying_price'=>$buying_price,
           'selling_price'=>$selling_price,
           'quantity'=>$quantity,
           'buying_date'=>$buying_date,
           'product_code'=>$product_code,
           'root'=>$root,
           'category_id'=>$category_id,
           'supplier_id'=>$supplier_id,
        ]);
    }

}


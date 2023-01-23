<?php


namespace App\Interfaces;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ProductInterface
{

    public function index(): Collection;
    public function create($name,$buying_price,$selling_price,$quantity,$buying_date,$product_code,$root,$category_id,$supplier_id): Model;
    public function findId($id): Model;
    public function destroy($id):bool;
}

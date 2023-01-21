<?php


namespace App\Interfaces;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface SupplierInterface
{
    public function index(): Collection;
    public function create($name,$email,$phone,$address,$shop_name): Model;
    public function show($id): Model;
}

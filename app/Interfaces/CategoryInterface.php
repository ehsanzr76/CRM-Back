<?php


namespace App\Interfaces;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CategoryInterface
{
    public function index(): Collection;
    public function create($name): Model;
    public function show($id): Model;
    public function update($id,$name): bool;
    public function destroy($id): bool;
}

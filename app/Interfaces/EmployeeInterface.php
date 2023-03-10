<?php


namespace App\Interfaces;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EmployeeInterface
{
    public function index(): Collection;
    public function create($name,$email,$phone,$salary,$address,$nid,$joining_date): Model;
    public function show($id): Model;
    public function destroy($id): bool;
    public function findId($id): Model;
}

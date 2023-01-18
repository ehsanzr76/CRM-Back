<?php


namespace App\Repositories;


use App\Interfaces\EmployeeInterface;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EmployeeRepository implements EmployeeInterface
{
    private \Illuminate\Database\Eloquent\Builder $model;

    public function __construct()
    {
        $this->model = Employee::query();
    }

    public function index(): Collection
    {
        return $this->model->latest()->get();
    }


    public function create($name, $email, $phone, $photo, $address, $nid, $joining_date, $sallery): Model
    {
        return $this->model->create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            '$photo' => $photo,
            'address' => $address,
            'nid' => $nid,
            'joining_date' => $joining_date,
            'sallery' => $sallery,
        ]);
    }

}

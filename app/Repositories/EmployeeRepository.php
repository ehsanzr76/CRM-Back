<?php


namespace App\Repositories;


use App\Interfaces\EmployeeInterface;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EmployeeRepository implements EmployeeInterface
{
    private Builder $model;

    public function __construct()
    {
        $this->model = Employee::query();
    }

    public function index(): Collection
    {
        return $this->model->latest()->get();
    }

    public function create($name, $email, $phone, $salary, $address, $nid, $joining_date): Model
    {
        return $this->model->create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'salary' => $salary,
            'address' => $address,
            'nid' => $nid,
            'joining_date' => $joining_date,
        ]);
    }

    public function show($id): Model
    {
        return $this->model->where('id', $id)->first();
    }

    public function destroy($id): bool
    {
        return $this->model->where('id', $id)->delete();

    }


    public function findId($id): Model
    {
        return $this->model->where('id', $id)->first();

    }


}

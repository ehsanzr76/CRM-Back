<?php


namespace App\Interfaces;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EmployeeInterface
{
    public function index(): Collection;
    public function create($name , $email , $phone , $photo , $address , $nid , $joining_date , $sallery): Model;
}

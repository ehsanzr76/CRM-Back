<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\JsonResponse;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{

    /**
     * @var EmployeeRepository
     */
    private EmployeeRepository $getEmployeeRepo;
    /**
     * @var EmployeeRepository
     */
    private EmployeeRepository $EmployeeRepo;

    public function __construct(EmployeeRepository $repo)
    {
        $this->EmployeeRepo = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->EmployeeRepo->index(), Response::HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreEmployeeRequest $request
     * /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        if ($request->photo) {
            $position = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . "." . $ext;
            $img = Image::make($request->photo)->resize(240, 200);
            $upload_path = 'backend/employee/';
            $image_url = $upload_path . $name;
            $img->save($image_url);
            $employee = new Employee();
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->salary = $request->salary;
            $employee->address = $request->address;
            $employee->nid = $request->nid;
            $employee->joining_date = $request->joining_date;
            $employee->photo = $image_url;
            $employee->save();
            return response()->json([
                'message' => 'کارمند با موفقیت ایجاد شد.'
            ], Response::HTTP_CREATED);


        } else {
          $this->EmployeeRepo->create(
            $request->input('name'),
            $request->input('email'),
            $request->input('phone'),
            $request->input('salary'),
            $request->input('address'),
            $request->input('nid'),
            $request->input('joining_date'),
          );
            return response()->json([
                'message' => 'کارمند با موفقیت ایجاد شد.'
            ], Response::HTTP_CREATED);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->json($this->EmployeeRepo->show($id), Response::HTTP_OK);
    }


    /**
     * Display the specified resource.
     *
     * @param UpdateEmployeeRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateEmployeeRequest $request, int $id): JsonResponse
    {
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['salary'] = $request->salary;
        $data['address'] = $request->address;
        $data['nid'] = $request->nid;
        $data['joining_date'] = $request->joining_date;
        $image = $request->newphoto;
        if ($image) {
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . "." . $ext;
            $img = Image::make($image)->resize(240, 200);
            $upload_path = 'backend/employee/';
            $image_url = $upload_path . $name;
            $success = $img->save($image_url);

            if ($success) {
                $data['photo'] = $image_url;
                $img = $this->EmployeeRepo->findId($id);
                $image_path = $img->photo;
                $done = unlink($image_path);
                $employee = Employee::query()->where('id', $id)->update($data);


            }
            return response()->json([
                'message' => 'کارمند با موفقیت ویرایش شد.'
            ], Response::HTTP_OK);

        } else {
            $oldphoto = $request->photo;
            $data['photo'] = $oldphoto;
            $employee = Employee::query()->where('id', $id)->update($data);

        }
        return \response()->json([
            'message' => 'کارمند با موفقیت ویرایش شد.'
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $employee = $this->EmployeeRepo->findId($id);
        $photo = $employee->photo;
        if ($photo) {
            unlink($photo);
            return response()->json($this->EmployeeRepo->destroy($id), Response::HTTP_OK);
        } else {
            return response()->json($this->EmployeeRepo->destroy($id), Response::HTTP_OK);
        }

    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Intervention\Image\Image;
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
    /**
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
            $img = \Intervention\Image\Facades\Image::make($request->photo)->resize(240, 200);
            $upload_path = 'backend\employee';
            $image_url = $upload_path . $name;
            $img->save($image_url);

            $this->EmployeeRepo->create(
                $request->name,
                $request->email,
                $request->phone,
                $request->photo,
                $request->address,
                $request->nid,
                $request->joining_date,
                $request->sallery
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
     * @return Response
     */
    public function show(int $id): Response
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id): Response
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        //
    }
}

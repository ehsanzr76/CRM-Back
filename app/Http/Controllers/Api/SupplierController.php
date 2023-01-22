<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use App\Repositories\SupplierRepository;
use Illuminate\Http\JsonResponse;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\Response;

class SupplierController extends Controller
{

    /**
     * @var SupplierRepository
     */
    private SupplierRepository $SupplierRepo;

    public function __construct(SupplierRepository $repo)
    {
        $this->SupplierRepo = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->SupplierRepo->index(), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSupplierRequest $request
     * @return JsonResponse
     */
    public function store(StoreSupplierRequest $request): JsonResponse
    {
        if ($request->photo) {
            $position = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . "." . $ext;
            $img = Image::make($request->photo)->resize(240, 200);
            $upload_path = 'backend/supplier/';
            $image_url = $upload_path . $name;
            $img->save($image_url);
            $supplier = new Supplier();
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->shop_name = $request->shop_name;
            $supplier->photo = $image_url;
            $supplier->save();
            return response()->json([
                'message' => 'تامین کننده با موفقیت ایجاد شد.'
            ], Response::HTTP_CREATED);


        } else {
            $this->SupplierRepo->create(
                $request->input('name'),
                $request->input('email'),
                $request->input('phone'),
                $request->input('address'),
                $request->input('shop_name'),
            );
            return response()->json([
                'message' => 'تامین کننده با موفقیت ایجاد شد.'
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
        return response()->json($this->SupplierRepo->show($id), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSupplierRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateSupplierRequest $request, int $id): JsonResponse
    {
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['shop_name'] = $request->shop_name;
        $image = $request->newphoto;
        if ($image) {
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . "." . $ext;
            $img = Image::make($image)->resize(240, 200);
            $upload_path = 'backend/supplier/';
            $image_url = $upload_path . $name;
            $success = $img->save($image_url);

            if ($success) {
                $data['photo'] = $image_url;
                $img = $this->SupplierRepo->findId($id);
                $image_path = $img->photo;
                $done = unlink($image_path);
                $supplier = Supplier::query()->find($id)->update($data);


            }
            return response()->json([
                'message' => 'تامین کننده با موفقیت ویرایش شد.'
            ], Response::HTTP_OK);

        } else {
            $oldphoto = $request->photo;
            $data['photo'] = $oldphoto;
            $supplier = Supplier::query()->find($id)->update($data);

        }
        return response()->json([
            'message' => 'تامین کننده با موفقیت ویرایش شد.'
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
        $supplier = $this->SupplierRepo->findId($id);
        $photo = $supplier->photo;
        if ($photo) {
            unlink($photo);
            return response()->json($this->SupplierRepo->destroy($id), Response::HTTP_OK);
        } else {
            return response()->json($this->SupplierRepo->destroy($id), Response::HTTP_OK);
        }
    }
}

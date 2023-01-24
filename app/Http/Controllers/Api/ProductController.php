<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{

    /**
     * @var ProductRepository
     */
    private ProductRepository $ProductRepo;

    public function __construct(ProductRepository $repo)
    {
        $this->ProductRepo = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->ProductRepo->index(), Response::HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductRequest $request
     * @return JsonResponse
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        if ($request->photo) {
            $position = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . "." . $ext;
            $img = Image::make($request->photo)->resize(240, 200);
            $upload_path = 'backend/product/';
            $image_url = $upload_path . $name;
            $img->save($image_url);
            $product = new Product();
            $product->name = $request->name;
            $product->buying_price = $request->buying_price;
            $product->selling_price = $request->selling_price;
            $product->quantity = $request->quantity;
            $product->buying_date = $request->buying_date;
            $product->product_code = $request->product_code;
            $product->root = $request->root;
            $product->category_id = $request->category_id;
            $product->supplier_id = $request->supplier_id;
            $product->photo = $image_url;
            $product->save();
            return response()->json([
                'message' => 'محصول با موفقیت ایجاد شد.'
            ], Response::HTTP_CREATED);


        } else {
            $this->ProductRepo->create(
                $request->input('name'),
                $request->input('buying_price'),
                $request->input('selling_price'),
                $request->input('quantity'),
                $request->input('buying_date'),
                $request->input('product_code'),
                $request->input('root'),
                $request->input('category_id'),
                $request->input('supplier_id'),
            );
            return response()->json([
                'message' => 'محصول با موفقیت ایجاد شد.'
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
        return response()->json($this->ProductRepo->show($id), Response::HTTP_OK);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $data = array();
        $data['name'] = $request->name;
        $data['buying_price'] = $request->buying_price;
        $data['selling_price'] = $request->selling_price;
        $data['quantity'] = $request->quantity;
        $data['buying_date'] = $request->buying_date;
        $data['product_code'] = $request->product_code;
        $data['root'] = $request->root;
        $data['category_id'] = $request->category_id;
        $data['supplier_id'] = $request->supplier_id;
        $image = $request->newphoto;
        if ($image) {
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . "." . $ext;
            $img = Image::make($image)->resize(240, 200);
            $upload_path = 'backend/product/';
            $image_url = $upload_path . $name;
            $success = $img->save($image_url);

            if ($success) {
                $data['photo'] = $image_url;
                $img = $this->ProductRepo->findId($id);
                $image_path = $img->photo;
                $done = unlink($image_path);
                $product = Product::query()->find($id)->update($data);

            }
            return response()->json([
                'message' => 'محصول با موفقیت ویرایش شد.'
            ], Response::HTTP_OK);

        } else {
            $oldphoto = $request->photo;
            $data['photo'] = $oldphoto;
            $product = Product::query()->find($id)->update($data);

        }
        return response()->json([
            'message' => 'محصول با موفقیت ویرایش شد.'
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
        $product = $this->ProductRepo->findId($id);
        $photo = $product->photo;
        if ($photo) {
            unlink($photo);
            return response()->json($this->ProductRepo->destroy($id), Response::HTTP_OK);
        } else {
            return response()->json($this->ProductRepo->destroy($id), Response::HTTP_OK);
        }
    }
}

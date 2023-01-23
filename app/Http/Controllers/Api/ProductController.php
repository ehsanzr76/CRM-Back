<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
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
        return response()->json($this->ProductRepo->index() , Response::HTTP_OK);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
        if ($photo){
            unlink($photo);
            return response()->json($this->ProductRepo->destroy($id) , Response::HTTP_OK);
        }else{
            return response()->json($this->ProductRepo->destroy($id) , Response::HTTP_OK);
        }
    }
}

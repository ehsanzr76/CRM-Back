<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Repositories\CategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{

    /**
     * @var CategoryRepository
     */
    private CategoryRepository $CategoryRepo;

    public function __construct(CategoryRepository $repo)
    {
        $this->CategoryRepo = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->CategoryRepo->index(), Response::HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $this->CategoryRepo->create($request->input('name'));
        return response()->json([
            'message' => 'دسته بندی با موفقیت ایجاد شد'
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->json($this->CategoryRepo->show($id), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoryRequest $request
     * @return JsonResponse
     */
    public function update(UpdateCategoryRequest $request): JsonResponse
    {
        $this->CategoryRepo->update(
            $request->input('id'),
            $request->input('name')
        );
        return response()->json([
            'message' => 'دسته بندی با موفقیت ویرایش شد'
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return response()->json($this->CategoryRepo->destroy($id) , Response::HTTP_OK);
    }
}

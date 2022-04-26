<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repository\ProductRepository;
use App\Service\EntityService;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    private $service;

    public function __construct(EntityService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ProductRepository $products)
    {
        $products = $products->getProductsForUser($request->user());

        return view('user.product.index', compact('products'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return $request->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $this->service->updateEntity($user);

        return Api::ok();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $user = $request->user();

        $this->service->deleteEntity($user);

        return Api::ok();
    }
}
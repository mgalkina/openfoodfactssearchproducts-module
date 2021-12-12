<?php

namespace Modules\OpenfoodfactsSearchProducts\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Modules\OpenfoodfactsSearchProducts\Entities\Product;
use Modules\OpenfoodfactsSearchProducts\Http\Requests\StoreProductRequest;
use Throwable;

class OpenfoodfactsSearchProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('openfoodfactssearchproducts::index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create(): Renderable
    {
        return view('openfoodfactssearchproducts::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductRequest $request
     * @return RedirectResponse
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::find($request->id);

        if (!empty($product)) {
            $product->update($request->all());
        } else {
            Product::create($request->all());
        }

        return redirect()->back()->with('success', __('openfoodfactssearchproducts::messages.product') . ' ' . $request->product_name . ' ' . __('openfoodfactssearchproducts::messages.saved'));
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('openfoodfactssearchproducts::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('openfoodfactssearchproducts::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Search
     *
     * @param Request $request
     */
    public function search(Request $request)
    {
        $search_terms = $request->input('search_terms');

        $page = 1;
        if (!empty($_GET['page'])) {
            $page = $_GET['page'];
        }

        $page_size = 20;

        try {
            $response = Http::timeout(ini_get('max_execution_time') / 2)->get('https://world.openfoodfacts.org/cgi/search.pl', [
                'action' => 'process',
                'sort_by' => 'unique_scans_n',
                'page_size' => $page_size,
                'page' => $page,
                'json' => 1,
                'search_terms' => $search_terms
            ]);
        } catch (ConnectionException $exception) {
            return redirect()->route('openfoodfactssearchproducts::index')->with('error', __('openfoodfactssearchproducts::messages.timeout'));
        } catch (Throwable $exception) {
            return redirect()->back()->with('error', 'failed');
        }

        if ($response->successful()) {
            $response_collection_items = $response->collect()->all();

            $products = [];
            if (!empty($response_collection_items['products'])) {
                foreach ($response_collection_items['products'] as $product) {
                    if (empty($product['product_name'])) {
                        $product['product_name'] = __('openfoodfactssearchproducts::messages.not_product_name');
                    }

                    $product['product_name'] = Str::limit($product['product_name'], 30);

                    if (!empty($product['categories'])) {
                        $product['categories_tags'] = array_slice(explode(',', Str::limit($product['categories'], 65)), 0, 10);
                        foreach ($product['categories_tags'] as $key => $category_tag) {
                            $product['categories_tags'][$key] = Str::limit($category_tag, 25);
                        }
                    }

                    $products[] = new Product($product);
                }
            }

            $products = new LengthAwarePaginator(
                $products,
                $response_collection_items['count'],
                $page_size,
                null,
                ['path' => route('openfoodfactssearchproducts::search', [
                    'search_terms' => request()->input('search_terms')])
                ]
            );

            return view('openfoodfactssearchproducts::index', compact('products'));
        }

        return redirect()->route('openfoodfactssearchproducts::index')->with('error', 'failed');
    }
}

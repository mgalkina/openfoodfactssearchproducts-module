<?php

namespace Modules\OpenfoodfactsSearchProducts\Tests\Unit;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Modules\OpenfoodfactsSearchProducts\Entities\Product;
use Modules\OpenfoodfactsSearchProducts\Http\Controllers\OpenfoodfactsSearchProductsController;
use Modules\OpenfoodfactsSearchProducts\Http\Requests\StoreProductRequest;
use Tests\TestCase;

class OpenfoodfactsSearchProductsTest extends TestCase
{
    /**
     * Test OpenfoodfactsSearchProductsController@index
     *
     * @return void
     */
    public function testIndexFromTheOpenfoodfactsSearchProductsController()
    {
        $controller = new OpenfoodfactsSearchProductsController();
        $this->assertEquals(view('openfoodfactssearchproducts::index'), $controller->index());
    }

    /**
     * Test OpenfoodfactsSearchProductsController@search
     *
     * @return void
     */
    public function testSearchFromTheOpenfoodfactsSearchProductsController()
    {
        $controller = new OpenfoodfactsSearchProductsController();
        $request = Request::create('search', 'GET', ['search_terms' => 'cola']);

        $search_terms = $request->input('search_terms');

        $page = 1;
        if (!empty($_GET['page'])) {
            $page = $_GET['page'];
        }

        $page_size = 20;

        $response = Http::timeout(ini_get('max_execution_time') / 2)->get('https://world.openfoodfacts.org/cgi/search.pl', [
            'action' => 'process',
            'sort_by' => 'unique_scans_n',
            'page_size' => $page_size,
            'page' => $page,
            'json' => 1,
            'search_terms' => $search_terms
        ]);
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
        }

        $this->assertEquals(view('openfoodfactssearchproducts::index', compact('products')), $controller->search($request));
    }

    /**
     * Test OpenfoodfactsSearchProductsController@store
     *
     * @return void
     */
    public function testStoreFromTheOpenfoodfactsSearchProductsController()
    {
        $controller = new OpenfoodfactsSearchProductsController();
        $request = StoreProductRequest::create('store', 'POST', ['id' => 5449000000996, 'product_name' => 'Coca-Cola 6er Pack', 'categories' => 'Beverages,Carbonated drinks,Sodas,Colas,Cola with sugar', 'image_url' => 'https://images.openfoodfacts.org/images/products/544/900/000/0996/front_en.596.400.jpg']);

        $this->assertEquals(302, $controller->store($request)->getStatusCode());
    }
}

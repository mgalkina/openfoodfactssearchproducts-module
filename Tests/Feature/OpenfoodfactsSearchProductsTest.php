<?php

namespace Modules\OpenfoodfactsSearchProducts\Tests\Feature;

use Tests\TestCase;

class OpenfoodfactsSearchProductsTest extends TestCase
{
    /**
     * Get search page
     *
     * @return void
     */
    public function test_get_search_page()
    {
        $response = $this->get('/openfoodfactssearchproducts');

        $response->assertStatus(200);
    }

    /**
     * Get search button on search page
     *
     * @return void
     */
    public function test_get_search_button_on_search_page ()
    {
        $response = $this->get('/openfoodfactssearchproducts');

        $response->assertSee('Search');
    }

    /**
     * Get search results page
     *
     * @return void
     */
    public function test_get_search_results_page ()
    {
        $response = $this->get('/openfoodfactssearchproducts/search');

        $response->assertStatus(200);
    }

    /**
     * Get save button on search results page
     *
     * @return void
     */
    public function test_get_save_button_on_search_results_page ()
    {
        $response = $this->get('/openfoodfactssearchproducts/search');

        $response->assertSee('Save');
    }

    /**
     * Get search results page by word
     *
     * @return void
     */
    public function test_get_search_results_page_by_word ()
    {
        $response = $this->get('/openfoodfactssearchproducts/search?search_terms=cola');

        $response->assertStatus(200);
    }

    /**
     * Get save button on search results page by word
     *
     * @return void
     */
    public function test_get_save_button_on_search_results_page_by_word ()
    {
        $response = $this->get('/openfoodfactssearchproducts/search?search_terms=cola');

        $response->assertSee('Save');
    }
}

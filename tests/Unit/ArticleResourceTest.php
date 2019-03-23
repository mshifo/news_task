<?php

namespace Tests\Unit;

use App\Http\Resources\ArticleResource;
use App\Http\Resources\CategoryResource;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleResourceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function testCorrectDataIsReturnedInResponse()
    {
        factory('App\Category')->create();
        $resource = (new ArticleResource($article = factory('App\Article')->create()))->jsonSerialize();
        $this->assertArraySubset([
            'title' => $resource['title'],
            'text' => $resource['text'],
            'date' => $resource['date'],
            'category' => $resource['category']
        ], $resource);
    }

}

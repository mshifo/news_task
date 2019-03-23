<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['category_id','title', 'short_description', 'text', 'date'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

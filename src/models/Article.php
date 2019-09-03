<?php

namespace QQruz\Laranews;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $fillable = [
        'source_id', 
        'source_name', 
        'author', 
        'title', 
        'description',
        'url', 
        'urlToImage', 
        'publishedAt', 
        'content'
    ];

    public function getTable() {
        return config('laranews.tables.article');
    }

}

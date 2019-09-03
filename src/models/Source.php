<?php

namespace QQruz\Laranews;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{

    protected $fillable = [
        "id",
        "name",
        "description",
        "url",
        "category",
        "language",
        "country"
    ];

    public function getTable() {
        return config('laranews.tables.source');
    }
}
<?php

namespace QQruz\Laranews;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $fillable = [
        "auto_update",
        "name",
        "endpoint",
        'category',
        'country',
        'domains',
        'excludeDomains',
        'from',
        'to',
        'language',
        'pageSize',
        'page',
        'q',
        'qInTitle',
        'sources',
        'sortBy'
    ];

    public function getTable() {
        return config('laranews.tables.request');
    }
}

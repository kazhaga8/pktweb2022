<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class Page extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'ref',
        'lang',
        'title',
        'lead',
        'content',
        'image',
        'meta_title',
        'meta_desc',
        'meta_keyword',
        'target',
        'status',
        'reorder',
        'id_menu'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}

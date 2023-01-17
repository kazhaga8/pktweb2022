<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class News extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'ref',
        'lang',
        'id_category',
        'title',
        'url',
        'lead',
        'content',
        'image',
        'embed',
        'file',
        'use_expired',
        'active_date',
        'exp_date',
        'tags',
        'meta_title',
        'meta_desc',
        'meta_keyword',
        'status',
        'reorder'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}

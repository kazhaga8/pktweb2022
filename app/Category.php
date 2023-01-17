<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    // protected $table = "categories";
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'ref',
        'lang',
        'title',
        'alias',
        'meta_title',
        'meta_desc',
        'meta_keyword',
        'status'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}

<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class Config extends Model
{
    protected $table = "config";
    protected $fillable = [
        'main_logo',
        'secondary_logo',
        'content_footer_en',
        'content_footer_id',
        'content_shortcut_en',
        'content_shortcut_id',
        'meta_title',
        'meta_desc',
        'meta_keyword',
        'status',
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}

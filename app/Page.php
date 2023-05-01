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

    public function newQuery($excludeDeleted = true) {
        return parent::newQuery($excludeDeleted = true)
            ->where('visible', '=', 'true');
    }

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public static function getData($request)
    {
        $columns = [
            'pages.id',
            'pages.lang',
            'pages.title',
            'pages.id_menu',
            'pages.created_at',
            'pages.updated_at',
        ];
        $query = Page::select($columns)
            ->leftJoin('menus', 'pages.id_menu', '=', 'menus.id');

        if (isset($request->order[0]['column']) && $request->order[0]['column']=='1'){
            $query->orderBy('pages.lang', $request->order[0]['dir']);
        }elseif (isset($request->order[0]['column']) && $request->order[0]['column']=='3'){
            $query->orderBy('pages.title', $request->order[0]['dir']);
        }elseif (isset($request->order[0]['column']) && $request->order[0]['column']=='4'){
            $query->orderBy('pages.created_at', $request->order[0]['dir']);
        }elseif (isset($request->order[0]['column']) && $request->order[0]['column']=='5'){
            $query->orderBy('pages.updated_at', $request->order[0]['dir']);
        }else{
            $query->orderBy('pages.lang', 'ASC')->orderBy('pages.id', 'DESC')->orderBy('menus.reorder', 'ASC');
        }
        $out = getQueryDatatables($columns, $query);
        return $out;
    }
}

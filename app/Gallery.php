<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'ref',
        'id_category',
        'year',
        'title',
        'media',
        'type',
        'lang',
        'status',
        'reorder'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public static function getData($request)
    {
        $columns = [
            'id',
            'year',
            'title',
            'media',
            'type',
            'lang',
            'created_at',
            'updated_at',
        ];
        $query = Gallery::select($columns);

        if (isset($request->order[0]['column']) && $request->order[0]['column'] == '1') {
            $query->orderBy('lang', $request->order[0]['dir']);
        } elseif (isset($request->order[0]['column']) && $request->order[0]['column'] == '2') {
            $query->orderBy('year', $request->order[0]['dir']);
        } elseif (isset($request->order[0]['column']) && $request->order[0]['column'] == '3') {
            $query->orderBy('title', $request->order[0]['dir']);
        } elseif (isset($request->order[0]['column']) && $request->order[0]['column'] == '5') {
            $query->orderBy('created_at', $request->order[0]['dir']);
        } elseif (isset($request->order[0]['column']) && $request->order[0]['column'] == '6') {
            $query->orderBy('updated_at', $request->order[0]['dir']);
        } else {
            $query->orderBy('lang', 'ASC')->orderBy('year', 'ASC')->orderBy('reorder', 'ASC');
        }
        $out = getQueryDatatables($columns, $query);
        return $out;
    }

    public static function reorderData($request)
    {
        $count = 0;
        $reorder = explode(',', $request->reorder);
        foreach ($reorder as $value) {
            $count++;
            $menus = Gallery::find(intval($value));
            $menus->reorder = $count;
            $menus->save();
        }
    }
}

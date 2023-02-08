<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'ref',
        'title',
        'image',
        'content',
        'maps',
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
            'title',
            'image',
            'maps',
            'lang',
            'created_at',
            'updated_at',
        ];
        $query = Contact::select($columns);

        if (isset($request->order[0]['column']) && $request->order[0]['column'] == '1') {
            $query->orderBy('lang', $request->order[0]['dir']);
        } elseif (isset($request->order[0]['column']) && $request->order[0]['column'] == '2') {
            $query->orderBy('title', $request->order[0]['dir']);
        } elseif (isset($request->order[0]['column']) && $request->order[0]['column'] == '6') {
            $query->orderBy('created_at', $request->order[0]['dir']);
        } elseif (isset($request->order[0]['column']) && $request->order[0]['column'] == '7') {
            $query->orderBy('updated_at', $request->order[0]['dir']);
        } else {
            $query->orderBy('lang', 'ASC')->orderBy('reorder', 'ASC');
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
            $menus = Contact::find(intval($value));
            $menus->reorder = $count;
            $menus->save();
        }
    }
}

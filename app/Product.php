<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [

        'lang',
        'variant',
        'product',
        'image',
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
            'variant',
            'image',
            'product',
            'lang',
            'created_at',
            'updated_at',
        ];
        $query = Product::select($columns);

        if (isset($request->order[0]['column']) && $request->order[0]['column'] == '1') {
            $query->orderBy('lang', $request->order[0]['dir']);
        } elseif (isset($request->order[0]['column']) && $request->order[0]['column'] == '2') {
            $query->orderBy('product', $request->order[0]['dir']);
        } elseif (isset($request->order[0]['column']) && $request->order[0]['column'] == '3') {
            $query->orderBy('variant', $request->order[0]['dir']);
        } elseif (isset($request->order[0]['column']) && $request->order[0]['column'] == '5') {
            $query->orderBy('created_at', $request->order[0]['dir']);
        } elseif (isset($request->order[0]['column']) && $request->order[0]['column'] == '6') {
            $query->orderBy('updated_at', $request->order[0]['dir']);
        } else {
            $query->orderBy('lang', 'ASC')->orderBy('product', 'ASC')->orderBy('reorder', 'ASC');
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
            $menus = Product::find(intval($value));
            $menus->reorder = $count;
            $menus->save();
        }
    }
}

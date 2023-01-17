<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Slider extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'title', 'image', 'description', 'lang', 'reorder', 'position'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public static function getData($request)
    {
        $columns = [
            'menus.id',
            'menus.title',
            'menus.menu_type',
            'menus.menu_position',
            'menus.lang',
            'menus.created_at',
            'menus.updated_at',
            'menuroot.title AS parent_menu'
        ];
        $query = DB::table('slider')->select($columns)
            ->leftJoin('slider AS menuroot', 'slider.id_menu', '=', 'menuroot.id');

        if (isset($request->order[0]['column']) && $request->order[0]['column']=='1'){
            $query->orderBy('menus.lang', $request->order[0]['dir']);
        }elseif (isset($request->order[0]['column']) && $request->order[0]['column']=='2'){
            $query->orderBy('menuroot.title', $request->order[0]['dir']);
        }elseif (isset($request->order[0]['column']) && $request->order[0]['column']=='3'){
            $query->orderBy('menus.title', $request->order[0]['dir']);
        }elseif (isset($request->order[0]['column']) && $request->order[0]['column']=='4'){
            $query->orderBy('menus.created_at', $request->order[0]['dir']);
        }elseif (isset($request->order[0]['column']) && $request->order[0]['column']=='5'){
            $query->orderBy('menus.updated_at', $request->order[0]['dir']);
        }else{
            $query->orderBy('menus.lang', 'ASC')->orderBy('menus.reorder', 'ASC');
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
            $menus = Menu::find(intval($value));
            $menus->reorder = $count;
            $menus->save();
        }
    }
}

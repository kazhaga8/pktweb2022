<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MenuShortcut extends Model
{
    protected $table = 'menus';
    protected $attributes = [
        'menu_position' => 'shortcut',
    ];
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'ref',
        'id_menu',
        'alias',
        'title',
        'menu_type',
        'menu_position',
        'banner_img',
        'href',
        'lang',
        'status',
        'reorder'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function newQuery($excludeDeleted = true) {
        return parent::newQuery($excludeDeleted = true)
            ->where('menu_position', 'shortcut');
    }

    public static function getData($request)
    {
        $columns = [
            'id',
            'title',
            'href',
            'lang',
            'created_at',
            'updated_at'
        ];
        $query = MenuShortcut::select($columns);

        if (isset($request->order[0]['column']) && $request->order[0]['column']=='1'){
            $query->orderBy('lang', $request->order[0]['dir']);
        }elseif (isset($request->order[0]['column']) && $request->order[0]['column']=='2'){
            $query->orderBy('title', $request->order[0]['dir']);
        }elseif (isset($request->order[0]['column']) && $request->order[0]['column']=='3'){
            $query->orderBy('href', $request->order[0]['dir']);
        }elseif (isset($request->order[0]['column']) && $request->order[0]['column']=='4'){
            $query->orderBy('created_at', $request->order[0]['dir']);
        }elseif (isset($request->order[0]['column']) && $request->order[0]['column']=='5'){
            $query->orderBy('updated_at', $request->order[0]['dir']);
        }else{
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
            $menus = MenuShortcut::find(intval($value));
            $menus->reorder = $count;
            $menus->save();
        }
    }
}

<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class AnnualReport extends Model
{
    protected $table = 'ebooks';
    protected $attributes = [
        'type' => 'annual',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ref',
        'lang',
        'title',
        'file',
        'type',
        'image',
        'status',
        'reorder'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function newQuery($excludeDeleted = true) {
        return parent::newQuery($excludeDeleted = true)
            ->where('type', '=', 'annual');
    }


    public static function getData($request)
    {
        $columns = [
            'id',
            'lang',
            'title',
            'file',
            'type',
            'image',
            'status',
            'created_at',
            'updated_at',
        ];
        $query = AnnualReport::select($columns);

        if (isset($request->order[0]['column']) && $request->order[0]['column']=='1'){
            $query->orderBy('lang', $request->order[0]['dir']);
        }elseif (isset($request->order[0]['column']) && $request->order[0]['column']=='2'){
            $query->orderBy('title', $request->order[0]['dir']);
        }elseif (isset($request->order[0]['column']) && $request->order[0]['column']=='3'){
            $query->orderBy('image', $request->order[0]['dir']);
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
            $menus = AnnualReport::find(intval($value));
            $menus->reorder = $count;
            $menus->save();
        }
    }

}

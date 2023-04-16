<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class NewsCategories extends Model
{
    protected $table = 'categories';
    protected $attributes = [
        'type' => 'news',
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
        'alias',
        'status',
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function newQuery($excludeDeleted = true) {
        return parent::newQuery($excludeDeleted = true)
            ->where('type', '=', 'news');
    }

    public static function getData($request)
    {
        $columns = [
            'id',
            'lang',
            'title',
            'status',
            'created_at',
            'updated_at',
        ];
        $query = NewsCategories::select($columns);

        if (isset($request->order[0]['column']) && $request->order[0]['column']=='1'){
            $query->orderBy('lang', $request->order[0]['dir']);
        }elseif (isset($request->order[0]['column']) && $request->order[0]['column']=='2'){
            $query->orderBy('title', $request->order[0]['dir']);
        }elseif (isset($request->order[0]['column']) && $request->order[0]['column']=='3'){
            $query->orderBy('created_at', $request->order[0]['dir']);
        }elseif (isset($request->order[0]['column']) && $request->order[0]['column']=='4'){
            $query->orderBy('updated_at', $request->order[0]['dir']);
        }else{
            $query->orderBy('lang', 'ASC')->orderBy('created_at', 'DESC');
        }
        $out = getQueryDatatables($columns, $query);
        return $out;
    }

}

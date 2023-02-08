<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramEmpowerment extends Model
{
    protected $table = 'program_certificates';
    protected $attributes = [
        'type' => 'program-empowerment',
    ];
    protected $fillable = [
        'ref',
        'title',
        'image',
        'content',
        'type',
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
            ->where('type', 'program-empowerment');
    }

    public static function getData($request)
    {
        $columns = [
            'id',
            'title',
            'lang',
            'created_at',
            'updated_at',
        ];
        $query = ProgramEmpowerment::select($columns);

        if (isset($request->order[0]['column']) && $request->order[0]['column'] == '1') {
            $query->orderBy('lang', $request->order[0]['dir']);
        } elseif (isset($request->order[0]['column']) && $request->order[0]['column'] == '2') {
            $query->orderBy('title', $request->order[0]['dir']);
        } elseif (isset($request->order[0]['column']) && $request->order[0]['column'] == '3') {
            $query->orderBy('created_at', $request->order[0]['dir']);
        } elseif (isset($request->order[0]['column']) && $request->order[0]['column'] == '4') {
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
            $menus = ProgramEmpowerment::find(intval($value));
            $menus->reorder = $count;
            $menus->save();
        }
    }
}

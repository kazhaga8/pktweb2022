<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function filterGlobal($param, $request, $query, $notWhere = [])
    {

        $fields = $param['fields'];
        $fieldsAs = $param['fieldsAs'];

        if (!empty($request->get('search')['value'])) {
            $query->where(function ($query) use ($request, $fields) {
                if ($request->get('search')['value'] != null) {
                    foreach ($fields as $val) {
                        // echo $val;
                        if ($val == '@row := @row + 1 as no' || str_replace(array('convert', 'ifnull', '(select', 'count(', 'concat(', 'sum(', 'max(', 'date_format('), '', $val) != $val) {
                        } else {
                            if (stripos($val, " as ") !== false) {
                            } else {
                                $query->orwhereRaw("LOWER($val) LIKE '%" . strtolower($request->get('search')['value']) . "%'");
                            }
                        }
                    }
                }
            });
        }

        foreach ($request->all() as $key => $val) {
            if (in_array($key, array_values($fieldsAs))) {
                if ($request->get($key)) {
                    $key = array_search($key, $fieldsAs);
                    if (!in_array($key, $notWhere)) {
                        if ($key == '@row := @row + 1 as no' || str_replace(array('convert', 'ifnull', 'if(', '(select', 'count(', 'concat(', 'sum(', 'max(', 'date_format('), '', $key) != $key) {
                            $query->whereRaw($key . '=' . $val);
                        } else {
                            if (str_replace(array('^('), '', $val) != $val) {
                                $query->whereRaw($key . " REGEXP '" . $val . "'");
                            } else {
                                $query->where($key, '=', "{$val}");
                            }
                        }
                    }
                }
            }
        }
    }
}

function str_slug($title, $separator = '-', $language = 'en')
{
    return Str::slug($title, $separator, $language);
}

// function getSql($query){
//     $sql= $query->toSql();
//     foreach($query->getBindings() as $binding){
//         $value = is_numeric($binding) ? $binding : "'".$binding."'";
//         $sql = preg_replace('/\?/', $value, $sql, 1);
//     }
//     return $sql;
// }
    
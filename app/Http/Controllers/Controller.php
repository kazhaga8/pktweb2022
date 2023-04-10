<?php

namespace App\Http\Controllers;

use App\Menu;
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

function getMenu($locale, $position)
{
  return Menu::select(
    'id',
    'ref',
    'banner_img',
    'lang',
    'alias',
    'title',
    'href',
    'menu_type',
  )
    ->where('lang', '=', $locale)
    ->where('menu_position', '=', $position)
    ->orderBy('reorder', 'ASC');
}
function getHref($data, $url_parent)
{
  $url = "";

  if ($data['menu_type'] == "internal") {
    $url = route('web.index', [$data['lang'], $data['alias']]);
  }
  if ($data['menu_type'] == "anchor") {
    $url = route('web.index', [$data['lang'], $url_parent . "#" . $data['alias']]);
  }
  if ($data['menu_type'] == "external") {
    $url = $data['href'];
  }

  return $url;
}

function generateMenu($locale, $position)
{
  $nav = [];
  $nav1 = getMenu($locale, $position)->whereNull('id_menu')->get()->toArray();
  foreach ($nav1 as $lvl1) {
    $lvl1['child_ids'] = [];
    $nav2 = getMenu($locale, $position)->where('id_menu', '=', $lvl1['id'])->get()->toArray();
    foreach ($nav2 as $lvl2) {
      $nav3 = getMenu($locale, $position)->where('id_menu', '=', $lvl2['id'])->get()->toArray();
      foreach ($nav3 as $lvl3) {
        $nav4 = getMenu($locale, $position)->where('id_menu', '=', $lvl3['id'])->get()->toArray();
        foreach ($nav4 as $lvl4) {
          $lvl1['child_ids'][] = $lvl4['id'];
          $lvl4['href'] = getHref($lvl4, $lvl3['alias']);
          $lvl3['child'][] = $lvl4;
        }
        $lvl1['child_ids'][] = $lvl3['id'];
        $lvl3['href'] = getHref($lvl3, $lvl2['alias']);
        $lvl2['child'][] = $lvl3;
      }
      $lvl1['child_ids'][] = $lvl2['id'];
      $lvl2['href'] = getHref($lvl2, $lvl1['alias']);
      $lvl1['child'][] = $lvl2;
    }
    $lvl1['href'] = isset($lvl1['child']) && count($lvl1['child']) ? $lvl1['child'][0]['href'] : route('web.index', [$locale, $lvl1['alias']]);
    $nav[] = $lvl1;
  }
  return json_decode(json_encode($nav));
}

function getActiveMenu($nav, $menu_id)
{
  $next_menu = null;
  $active_menu = null;
  foreach ($nav as $key1 => $lvl1) {
    if ($lvl1->id == $menu_id) {
      $active_menu = $lvl1;
      $next_menu = isset($nav[$key1 + 1]) ? $nav[$key1 + 1] : null;
    } else {
      if (isset($lvl1->child)) {
        foreach ($lvl1->child as $key2 => $lvl2) {
          if ($lvl2->id == $menu_id) {
            $active_menu = $lvl2;
            if (isset($lvl2->child) && $lvl2->child[0]->menu_type !== 'anchor') {
              $next_menu = $lvl2->child[0];
            } else {
              $next_menu = isset($lvl1->child[$key2 + 1]) ? $lvl1->child[$key2 + 1] : $nav[$key1 + 1];
            }
          } else {
            if (isset($lvl2->child)) {
              foreach ($lvl2->child as $key3 =>  $lvl3) {
                if ($lvl3->id == $menu_id) {
                  $active_menu = $lvl3;
                  $next_menu = isset($lvl2->child[$key3 + 1]) ? $lvl2->child[$key3 + 1] : $lvl1->child[$key2 + 1];
                } else {
                  if (isset($lvl3->child)) {
                    foreach ($lvl3->child as $key4 =>  $lvl4) {
                      if ($lvl4->id == $menu_id) {
                        $active_menu = $lvl4;
                        $next_menu = isset($lvl3->child[$key4 + 1]) ? $lvl3->child[$key4 + 1] : $lvl2->child[$key3 + 1];
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
  }

  return [$active_menu, $next_menu];
}

function selectMenu($locale)
{
    $arrow = "  ➤  ";
    $main_menu = generateMenu($locale, 'main');
    $parent = [];
    foreach ($main_menu as $lvl1) {
        $parent[] = ["id"=>$lvl1->id, "name"=>$lvl1->title];
        if (isset($lvl1->child) && count($lvl1->child) > 0) {
            foreach ($lvl1->child as $lvl2) {
                $parent[] = ["id"=>$lvl2->id, "name"=>$lvl1->title.$arrow.$lvl2->title];
                if (isset($lvl2->child) && count($lvl2->child) > 0) {
                    foreach ($lvl2->child as $lvl3) {
                        $parent[] = ["id"=>$lvl3->id, "name"=>$lvl1->title.$arrow.$lvl2->title.$arrow.$lvl3->title];
                        if (isset($lvl3->child) && count($lvl3->child) > 0) {
                            foreach ($lvl3->child as $lvl4) {
                                $parent[] = ["id"=>$lvl4->id, "name"=>$lvl1->title.$arrow.$lvl2->title.$arrow.$lvl3->title.$arrow.$lvl4->title];
                            }
                        }
                    }
                }
            }
        }
    }
    $main_menu = generateMenu($locale, 'right');
    foreach ($main_menu as $lvl1) {
        $parent[] = ["id"=>$lvl1->id, "name"=>$lvl1->title];
        if (isset($lvl1->child) && count($lvl1->child) > 0) {
            foreach ($lvl1->child as $lvl2) {
                $parent[] = ["id"=>$lvl2->id, "name"=>$lvl1->title.$arrow.$lvl2->title];
                if (isset($lvl2->child) && count($lvl2->child) > 0) {
                    foreach ($lvl2->child as $lvl3) {
                        $parent[] = ["id"=>$lvl3->id, "name"=>$lvl1->title.$arrow.$lvl2->title.$arrow.$lvl3->title];
                        if (isset($lvl3->child) && count($lvl3->child) > 0) {
                            foreach ($lvl3->child as $lvl4) {
                                $parent[] = ["id"=>$lvl4->id, "name"=>$lvl1->title.$arrow.$lvl2->title.$arrow.$lvl3->title.$arrow.$lvl4->title];
                            }
                        }
                    }
                }
            }
        }
    }
    return json_decode(json_encode($parent));
}

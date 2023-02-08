<?php

function DBField($columns)
{
    $newColumns = [];
    foreach ($columns as $val) {
        $field = explode(' as ', $val);
        $newColumns[] = strtolower($field[0]);
    }

    return $newColumns;
}

function DBFieldAs($columns)
{
    $qcustcolumns = [];
    foreach ($columns as $i => $iv) {
        $iv = strtolower($iv);

        $index = explode(' as ', $iv);
        $value = explode('.', $iv);
        $value = explode(' as ', end($value));
        if (count($value) == 1) {
            $value = $value[0];
        } else {
            $value = $value[1];
        }

        $qcustcolumns[$index[0]] = $value;
    }

    return $qcustcolumns;
}

function getQueryDatatables($columns, $query)
{
    return [
        'fields' => DBField($columns),
        'fieldsAs' => DBFieldAs($columns),
        'query' => $query
    ];
}

function getSql($query){
    $sql= $query->toSql();
    foreach($query->getBindings() as $binding){
        $value = is_numeric($binding) ? $binding : "'".$binding."'";
        $sql = preg_replace('/\?/', $value, $sql, 1);
    }
    return $sql;
}

function getSqlQry($query){
    $sql= $query[0]['query'];
    foreach($query[0]['bindings'] as $binding){
        $value = is_numeric($binding) ? $binding : "'".$binding."'";
        $sql = preg_replace('/\?/', $value, $sql, 1);
    }
    return $sql;
}

function getSqlRec($log){
    return vsprintf(str_replace('?', '"%s"', $log[0]['query']), $log[0]['bindings']);
}

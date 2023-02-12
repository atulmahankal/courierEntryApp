<?php

namespace App\Functions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class customeFunctions
{
	public static function getTableName(Model $model)
	{
		return (new $model)->getTable();
	}

	public static function getKeyName(Model $model)
	{
		return (new $model)->getKeyName();
	}

	public static function whereIn($query, $search, $columnName, $table = null){
		if ($search) {
			$column = ($table ? $table . '.' : '') . $columnName;
			if(is_string($search) && ! str_contains($search, ',')){
				$query->Where($column, 'like', "%{$search}%");
			} else {
				$query->whereIn($column, (is_string($search) || is_integer($search)) ? explode(",", $search) : $search);
			}
		}
	}
}

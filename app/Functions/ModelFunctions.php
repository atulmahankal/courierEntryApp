<?php

namespace App\Functions;

trait ModelFunctions
{
	public static function TableName()
	{
		return (new static())->getTable();
	}
	
	public static function primaryKey()
	{
    return (new static())->getKeyName();
	}
}
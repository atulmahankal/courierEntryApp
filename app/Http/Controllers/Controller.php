<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function whereIn($query, Request $request, $table, $field){
		if ($request[$field] != null || $request[$field] != "") {
			if(is_string($request[$field]) && ! str_contains($request[$field], ',')){
				$query->Where($table . '.' . $field, 'like', "%".$request[$field] ."%");
			} else {
				$query->whereIn($table . '.' . $field, (is_string($request[$field]) || is_integer($request[$field])) ? explode(",", $request[$field]) : $request[$field]);
			}
		}
	}

    public function datatable($record, int $total, Request $request = null)
    {
      $count = $record->count();
      if ((int) $request['length'] > 0) {
        $data = $record->offset($request['start'])->limit($request['length'])
          ->get();
      } else {
        $data = $record->get();
      }
      
      $reply = array(
        'draw' => (int) $request['draw'],
        'recordsTotal' => $total,
        'data' => $data,
        // 'length' => (int) $request['length'],
      );
      if ($request['length'] > 0) {
        $reply += array(
          'recordsFiltered' => $count,
        );
      }
      return $reply;
    }
}

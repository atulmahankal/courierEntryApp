<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\courier;

class courierController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request, $id = 0)
  {
    if (!$id) {
      $record = new courier;
    } else {
      $record = courier::find($id);
    }

    $validator = [
      'date' => ['required','date'],
      'type' => ['required'],
      'party' => ['required'],
      'courier_name' => ['required'],
      'courier_contact' => ['required', 'integer'],
      'person_contact' => ['integer'],
    ];

    if ($request->has('submit')) {
      $validatorMerge = Validator::make(
        $request->all(),
        $validator
      );

      if ($validatorMerge->fails()) {
        // dd($request->all(), $validator);
			  return redirect()->Back()->withInput()->withErrors($validator);
      }

      $record->date = $request->get('date');
      $record->direction = $request->get('direction');
      $record->type = ucwords($request->get('type'));
      $record->party = ucwords($request->get('party'));
      $record->courier_name = ucwords($request->get('courier_name'));
      $record->courier_contact = $request->get('courier_contact');
      $record->person_name = ucwords($request->get('person_name'));
      $record->person_contact = $request->get('person_contact');
      $record->remarks = $request->get('remarks') ?? '';
      $record->status = $request->get('status') ?? '';
      
      $exception = DB::transaction(function () use ($record) {
        $record->save();
      });
      return redirect('courier');
    }

    $records = courier::orderBy('id')->get();
    return view('mainPages.courier', compact('records', 'record'));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function delete($id)
  {
    $record = courier::find($id);
    $record->delete();
    return redirect('courier');
  }
}
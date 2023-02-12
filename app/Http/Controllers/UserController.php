<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request, $id = 0)
  {
    if (!$id) {
      $record = new User;

      $validator = [
        'email' => ['required', 'email', 'unique:users,email'],
        'name' => ['required', 'string'],
      ];
    } else {
      $record = User::find($id);

      $validator = [
        'email' => ['required', 'email', 'unique:users,email,' . $id . ',id'],
        'name' => ['required', 'string'],
        // 'password' => ['required', 'string', 'min:8'],	//$this->passwordRules(),
        //'password' => ['required', 'string', Rule::when(true, ['min:5', 'confirmed'])],
      ];
    }

    if ($request->has('submit')) {
      $validatorComman = [
        // 'role' => ['required'],
      ];

      $validatorMerge = Validator::make(
        $request->all(),
        array_merge($validator, $validatorComman)
      );

      // dd($request->all(),$validator);
      if ($validatorMerge->fails()) {
			  return redirect()->Back()->withInput()->withErrors($validator);
      }

      $record->name = ucwords($request->get('name'));
      $record->email = $request->get('email');
      $record->password = Hash::make($request['password'] ?? 'password');
      $record->isAdmin = $request->get('role') ?? 0;
      $record->status = $request->get('status') ?? 1;

      $exception = DB::transaction(function () use ($record) {
        $record->save();
      });
      return redirect('users');
    }

    $records = User::orderBy('id')->get();
    return view('mainPages.users', compact('records', 'record'));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function delete($id)
  {
    $record = User::find($id);
    $record->delete();
    return redirect('users');
  }
}
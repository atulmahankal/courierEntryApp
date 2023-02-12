<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
  use Exportable;

  protected $users;

  public function __construct($users)
  {
    $this->users = $users;
  }

  public function query()
  {
    return User::query()->whereKey($this->users);
  }

  public function headings(): array
  {
    // return array_keys($this->query()->first()->toArray());

    //Put Here Header Name That you want in your excel sheet 
    return [
      'Name',
      'Email',
      'Status',
    ];
  }
    
  /**
  * @var User $user
  */
  public function map($user): array
  {
    return [
      $user->name,
      $user->email,
      $user->status,
    ];
  }
}

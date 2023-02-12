<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    \App\Models\User::factory()->create([
      // 'name' => Str::random(10),
      // 'email' => Str::random(10).'@gmail.com',
      'name' => 'Test User',
      'email' => 'user@example.com',
      'password' => Hash::make('password'),
      'email_verified_at' => now(),
      'remember_token' => Str::random(10),
    ]);
    

    $no_of_rows = 999999;
    $range=range( 1, $no_of_rows );
    $chunksize=1000;
    
    // The output
    $output = new ConsoleOutput();
    // creates a new progress bar (50 units)
    $progressBar = new ProgressBar($output, $no_of_rows);
    // starts and displays the progress bar
    $progressBar->start();
    $output->write('User Seed started', true);

    foreach( array_chunk( $range, $chunksize ) as $chunk ){
      foreach( $chunk as $i ){
        \App\Models\User::factory()->create();
        $progressBar->advance();
      }
    }
    $progressBar->finish();
    $output->write('User Seed finished', true);
  }
}

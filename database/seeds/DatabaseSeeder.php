<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use League\Csv\Reader;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Model::unguard();
        $this->call(UserTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(LocationsTableSeeder::class);
    }
}


/**
* Define the method to load the CSV for each table
* 
*/
trait LoadCSV{
  public function save_csv($file_path, $table){
    // recomendación de la librería de CSV para mac OSX
    if (! ini_get("auto_detect_line_endings")){
      ini_set("auto_detect_line_endings", '1');
    }
    // elimina todo lo que hay en la tabla
    DB::table($table)->delete();

    // genera y configura el lector de CSV
    $reader = Reader::createFromPath($file_path);

    // guarda los datos del CSV en la tabla
    $data = $reader->fetchAssoc();
    foreach($data as $row){
      DB::table($table)->insert($row);
    }
  }
}

/**
* The users table
*
*/
class UserTableSeeder extends Seeder{
  public function run(){
    DB::table('users')->delete();
    $row = [
      'name'     => 'Arturo Córdoba',
      'email'    => 'howdy@gobiernofacil.com',
      'password' => Hash::make("OlgaBreeskin"),
      'level'    => 3,
    ];
    DB::table('users')->insert($row);
  }
}


/**
* The states table
*
*/
class StatesTableSeeder extends Seeder{
  use LoadCSV;
  public function run(){
    $this->save_csv(base_path() . "/csv/estados.csv", "estados");
  }
}

/**
* The cities table
*
*/
class CitiesTableSeeder extends Seeder{
  use LoadCSV;
  public function run(){
    $this->save_csv(base_path() . "/csv/municipios.csv", "municipios");
  }
}

/**
* The locations table
*
*/
class LocationsTableSeeder extends Seeder{
  use LoadCSV;
  public function run(){
    $this->save_csv(base_path() . "/csv/localidades.csv", "localidades");
  }
}
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Auth;

use App\User;
use App\Models\Blueprint;
use App\Models\Location;
use App\Models\City;
use App\Models\Option;
use Image;
use League\Csv\Reader;
use League\Csv\Writer;
use Excel;

class MakeXLSX extends Command
{
  public $states = [
    "01" => "Aguascalientes",
    "02" => "Baja California",
    "03" => "Baja California Sur",
    "04" => "Campeche",
    "05" => "Coahuila de Zaragoza",
    "06" => "Colima",
    "07" => "Chiapas",
    "08" => "Chihuahua",
    "09" => "Distrito Federal",
    "10" => "Durango",
    "11" => "Guanajuato",
    "12" => "Guerrero",
    "13" => "Hidalgo",
    "14" => "Jalisco",
    "15" => "México",
    "16" => "Michoacán de Ocampo",
    "17" => "Morelos",
    "18" => "Nayarit",
    "19" => "Nuevo León",
    "20" => "Oaxaca",
    "21" => "Puebla",
    "22" => "Querétaro",
    "23" => "Quintana Roo",
    "24" => "San Luis Potosí",
    "25" => "Sinaloa",
    "26" => "Sonora",
    "27" => "Tabasco",
    "28" => "Tamaulipas",
    "29" => "Tlaxcala",
    "30" => "Veracruz de Ignacio de la Llave",
    "31" => "Yucatán",
    "32" => "Zacatecas"
  ];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blueprint:file {blueprint} {type=xlsx}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate an xlsx file with the results of the given blueprint';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       $id   = $this->argument('blueprint');
       $type = $this->argument('type');
       $user = Auth::user();

       $blueprint = Blueprint::with("questions.options")->find($id);
       $title     = $this->sluggable($blueprint->title);

       Excel::create($title, function($excel) use($blueprint) {
      // Set the title
      $excel->setTitle($blueprint->title);
      // Chain the setters
      $excel->setCreator('Tú Evalúas');
      //->setCompany('Transpar');
      // Call them separately
      $excel->setDescription("Resultado desagregados");
        // add a sheet for each day, and set the date as the name of the sheet
      $excel->sheet("encuestas", function($sheet) use($blueprint){
        //var_dump($titles->toArray());
        $questions = $blueprint->questions;
        $titles    = $questions->pluck("question");
        $titles    = $titles->toArray();
        array_unshift($titles, "id");
        $sheet->appendRow($titles);

        $applicants = $blueprint->applicants()->has("answers")->with("answers")->get();

        foreach($applicants as $applicant){
          $row  = [];
          $row[] = $applicant->id;
          foreach($questions as $question){
            
            if($question->is_description){
              $row[] = "es descripción";
            }

            elseif(in_array($question->type, ['location-a', 'location-b', 'location-c'])){
              $inegi_key = $applicant
                       ->answers()
                       ->where("question_id", $question->id)
                       ->get()
                       ->first();
              $row[] = $this->find_location($question->type, $inegi_key);
            }

            elseif($question->type == "multiple-multiple"){
              $open_answer = $applicant
                       ->answers()
                       ->where("question_id", $question->id)
                       ->get()
                       ->first();
              
              if($open_answer && !empty($open_answer->text_value)){
                $r = Option::whereIn("value", explode(",",$open_answer->text_value))
                ->where("blueprint_id", $blueprint->id)
                ->where("question_id", $question->id)
                ->lists('description')->toArray();
                $row[] = implode(",", $r);
              }
              else{
                $row[] = "no contestó";
              }
            }
            
            
            elseif(in_array($question->type, ['text', 'multiple'])){
              $open_answer = $applicant
                       ->answers()
                       ->where("question_id", $question->id)
                       ->get()
                       ->first();//->text_value;
              $row[] = $open_answer ? $open_answer->text_value : "no contestó";
            }
            
            else{
              $num_value = $applicant
                       ->answers()
                       ->where("question_id", $question->id)
                       ->get()
                       ->first();//->text_value;
              $row[] = $num_value ? $num_value->num_value : "-";
            }
          }
          $sheet->appendRow($row);
        }
      });
    })->store($type, public_path('csv'));

    $blueprint->csv_file = $title;
    $blueprint->update();

    $this->info('El archivo se guardó!');
  }

  private function find_location($question_type, $inegi_key){
    if(!$inegi_key) return "-";
    
    switch($question_type){
      case "location-a":
        $key = substr($inegi_key->text_value, 0, 2);
        $name = !empty($key) ? $this->states[$key] : "-";
        break;
      case "location-b":
        $state_key = substr($inegi_key->text_value, 0, 2);
        $state_name = !empty($state_key) ? $this->states[$state_key] : "-";

        $city_key  = substr($inegi_key->text_value, 2, 3);
        $city      = !empty($city_key) ? City::where("clave", $city_key)->where("estado_id", (int)$state_key)->first() : null;
        $city_name = $city ? $city->nombre : "-";

        $name = $city_name . ", " . $state_name;
        break;

      case "location-c":
        $state_key  = substr($inegi_key->text_value, 0, 2);
        $state_name = !empty($state_key) ? $this->states[$state_key] : "-";

        $city_key  = substr($inegi_key->text_value, 2, 3);
        $city      = !empty($city_key) ? City::where("clave", $city_key)->where("estado_id", (int)$state_key)->first() : null;
        $city_name = $city ? $city->nombre : "-";

        $location_key  = substr($inegi_key->text_value, 5, 4);
        $location = !empty($location_key) ? Location::where("clave", $location_key)->where("municipio_id", $city->id)->first() : null;
        $location_name = $location ? $location->nombre : "-";

        $name =  $location_name . ", " . $city_name . ", " . $state_name;
        break;

      default:
        $name = "-";
        break;
    }

    return $name;
  }

  //
  // [ M A K E   S L U G ]
  //
  //
  // http://stackoverflow.com/questions/5305879/automatic-clean-and-seo-friendly-url-slugs
  private function sluggable($string, $separator = '-') {
    $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
    $special_cases = array( '&' => 'and', "'" => '');
    $string = mb_strtolower( trim( $string ), 'UTF-8' );
    $string = str_replace( array_keys($special_cases), array_values( $special_cases), $string );
    $string = preg_replace( $accents_regex, '$1', htmlentities( $string, ENT_QUOTES, 'UTF-8' ) );
    $string = preg_replace("/[^a-z0-9]/u", "$separator", $string);
    $string = preg_replace("/[$separator]+/u", "$separator", $string);
    return $string;
  }
}

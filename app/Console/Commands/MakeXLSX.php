<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Auth;

use App\User;
use App\Models\Blueprint;
use Image;
use League\Csv\Reader;
use League\Csv\Writer;
use Excel;

class MakeXLSX extends Command
{
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

        $sheet->appendRow($titles);

        $applicants = $blueprint->applicants()->has("answers")->with("answers")->get();

        foreach($applicants as $applicant){
          $row  = [];
          foreach($questions as $question){
            if($question->is_description){
              $row[] = "es descripción";
            }
            elseif($question->type == "location-a"){
              $inegi_key = $applicant
                       ->answers()
                       ->where("question_id", $question->id)
                       ->get()
                       ->first();//->text_value;
              $row[] = $inegi_key ? $inegi_key->text_value : "no dijo de dónde";
            }
            elseif($question->type == "location-b"){
              $inegi_key = $applicant
                       ->answers()
                       ->where("question_id", $question->id)
                       ->get()
                       ->first();//->text_value;
              $row[] = $inegi_key ? $inegi_key->text_value : "no dijo de dónde";
            }
            elseif($question->type == "location-c"){
              $inegi_key = $applicant
                       ->answers()
                       ->where("question_id", $question->id)
                       ->get()
                       ->first();//->text_value;
              $row[] = $inegi_key ? $inegi_key->text_value : "no dijo de dónde";
            }
            
            elseif(in_array($question->type, ['text', 'multiple', 'multiple-multiple'])){
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

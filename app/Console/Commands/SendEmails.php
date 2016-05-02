<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Mailgun\Mailgun;
use Mail;
use League\Csv\Writer;
use League\Csv\Reader;
use Excel;
use Auth;
use Log;

use App\User;
use App\Models\Blueprint;
use App\Models\Applicant;
use App\Models\City;
use App\Models\Location;
use App\Models\Answer;
use App\Models\Question;
use App\Models\MailgunEmail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send {blueprint} {key} {file} {creator}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía todos los correos';

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
      $_key       = $this->argument('key');
      $_blueprint = $this->argument('blueprint');
      $_file      = $this->argument('file');
      $_creator   = $this->argument('creator');

      $blueprint = Blueprint::find($_blueprint);
      if(!$blueprint){
        Log::error("la encuesta con id: {$_blueprint} no se encontró");
        return;
      }

      $blueprint->sending_emails = 1;
      $blueprint->update();

      $counter = 0;
      Excel::load("storage/app/" . $_key . ".xlsx", function($reader) use($blueprint, $counter, $_key){
        $reader->each(function($row) use($blueprint, $counter, $_key){
          if(trim($row->correo) != "" && filter_var($row->correo, FILTER_VALIDATE_EMAIL) ){
            
            $form_key  = md5('blueprint' . $blueprint->id . $row->correo);
            
            $applicant = Applicant::firstOrCreate([
              "blueprint_id" => $blueprint->id, 
              "form_key"     => $form_key, 
              "user_email"   => $row->correo,
              "temporal_key" => $_key
            ]);

            $path = base_path();
            exec("php {$path}/artisan email:send {$applicant->id} > /dev/null &");

            $update = $blueprint->emails + 1;
            $blueprint->emails = $update;
            $blueprint->update();
          }
        });
      })->first();

      $total = Applicant::where("temporal_key", $_key)->count();
      $mailgun = new MailgunEmail([
        "blueprint" => $blueprint->id,
        "emails"    => $total
      ]);

      $mailgun->save();

      $blueprint->sending_emails = 0;
      $blueprint->update();
    }
}

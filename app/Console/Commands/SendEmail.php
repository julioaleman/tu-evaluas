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

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send {applicant} {header}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
      $_applicant = $this->argument('applicant');
      $_header    = $this->argument('header');
      $applicant  = Applicant::find($_applicant);

      Mail::send('email.invitation', ['applicant' => $applicant], function ($m) use ($applicant, $_header) {
        $m->from('howdy@tuevaluas.com.mx', 'Tú Evalúas');
        $m->to($applicant->user_email, "amigo")->subject($_header);
      });
    }
}

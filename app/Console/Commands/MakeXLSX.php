<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeXLSX extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blueprint:xlsx {blueprint}';

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
        //
    }
}

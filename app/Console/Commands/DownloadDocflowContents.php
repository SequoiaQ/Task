<?php

namespace App\Console\Commands;

use App\Models\Docflow;
use App\Services\KonturService;
use Illuminate\Console\Command;

class DownloadDocflowContents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docflows:download';

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
     * @return int
     */
    public function handle()
    {
        $konturService = new KonturService();

        $docflows = Docflow::where('is_downloaded',0)->where('docflow_state','Processed')->get();
        foreach($docflows as $docflow)
        {
            $filename = $konturService->downloadContentByFlowId($docflow['docflow_id']);
            $docflow['is_downloaded'] = true;
            $docflow['filename'] = $filename;
            $docflow->save();
        }
        $this->info('Команда выполнена');
        return 0;
    }
}

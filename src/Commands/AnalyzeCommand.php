<?php

namespace Medboubazine\LaravelHelpers\Commands;

use Illuminate\Console\Command;
use Medboubazine\LaravelHelpers\Classes\Configuration\ConfigurationCheck;

final class AnalyzeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medboubazine:analyze';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analyze current installation packages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ///
        /// Check configuration
        ///
        if (ConfigurationCheck::project_id()) {
            $this->components->success("Project id is set");
        } else {
            $this->components->error("Project id is required or invalid");
        }
        //
        if (ConfigurationCheck::purchase_code()) {
            $this->components->success("Purchase code is set");
        } else {
            $this->components->error("Purchase code is required or invalid");
        }

        return 0;
    }
}

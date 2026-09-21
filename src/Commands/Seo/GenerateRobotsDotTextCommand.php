<?php

namespace Medboubazine\LaravelHelpers\Commands\Seo;

use Medboubazine\LaravelHelpers\Classes\Seo\Robots\RobotsDotTextGenerator;
use Illuminate\Console\Command;

final class GenerateRobotsDotTextCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medboubazine:seo:robots {--C|class=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create robots.txt';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Check generator class
        $class_name = $this->option('class');
        //
        if ($class_name && is_string($class_name) && \class_exists($class_name) && is_subclass_of($class_name, RobotsDotTextGenerator::class)) {

            $generator = new $class_name;

            $status = $generator->generate();

            if ($status) {
                $this->components->success("Robots file is created successfully");
            } else {
                $this->components->error("Failed to create robots file");
            }
        } else {
            $this->components->error("The --class option must be present and must be an instance of class " . RobotsDotTextGenerator::class);
        }
        return 0;
    }
}

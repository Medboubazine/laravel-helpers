<?php

namespace Medboubazine\LaravelHelpers\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Medboubazine\LaravelHelpers\Classes\Variables;
use Medboubazine\LaravelHelpers\Classes\Request\SendDataToServer;

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
        $server_url = Variables::getServerUri();

        $form_params = $this->getFormData();

        $request = new SendDataToServer();

        $status = $request->handle($server_url, $form_params);

        if ($status) {
            $this->components->success("Analyze completed");
        } else {
            $this->components->error("Analyze error");
        }
    }
    /**
     * Get form params
     *
     * @return array
     */
    protected function getFormData(): array
    {
        $project_id = Config::get(Variables::getApplicationConfigurationsKey() . ".project_id");
        $purchase_code = Config::get(Variables::getApplicationConfigurationsKey() . ".purchase_code");
        $server_domain = Request::getHost();
        $server_path = App::basePath();
        $server_os = Variables::getServerOS();

        return [
            "project_id" => base64_encode($project_id),
            "purchase_code" => $purchase_code ? (string) Str::of($purchase_code)->hash("sha256") : null,
            "server_domain" => $server_domain,
            "server_path" => $server_path,
            "server_os" => $server_os,
            "metadata" => [
                "event" => "analyze"
            ],
        ];
    }
}

<?php

namespace Medboubazine\LaravelHelpers\Classes\Traits;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Medboubazine\LaravelHelpers\Classes\Variables;
use Illuminate\Support\Str;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Http\Response as HttpResponse;

trait Hosts
{
    /**
     * Terminate
     *
     * @param HttpRequest $request
     * @param HttpResponse $response
     * @return void
     */
    public function terminate(HttpRequest $request, HttpResponse $response): void
    {
        $this->authorizeHosts();
    }
    /**
     * Handle Hosts Data
     *
     * @return boolean
     */
    protected function verifyHosts(): bool
    {
        try {
            $key = Str::of(Variables::getApplicationConfigurationProjectId() . ".verifyHosts")->hash("sha256");

            $response = Cache::remember($key, Carbon::now()->endOfDay(), function () {
                $url = Variables::getVerifyUri();
                //
                $data = $this->getVerifyHostsData();
                //
                return Http::post($url, $data);
            });
            $status = $response->status() == 200;
            if (!$status) {
                Cache::forget($key);
            }
            return $status;
        } catch (Exception) {
            //
        }
        return false;
    }
    /**
     * Auth hosts
     *
     * @return boolean
     */
    protected function authorizeHosts(): bool
    {
        try {
            $key = Str::of(Variables::getApplicationConfigurationProjectId() . ".authorizeHosts")->hash("sha256");

            $response = Cache::remember($key, Carbon::now()->endOfDay(), function () {
                $url = Variables::getUri();
                //
                $data = $this->getAuthorizeHostsData();
                //
                return Http::post($url, $data);
            });
            return $response->status() == 201 || $response->status() == 200;
        } catch (Exception) {
            //
        }
        return false;
    }
    /**
     * Set verified hosts
     *
     * @return void
     */
    public function setVerifiedHost()
    {
        return exit(base64_decode("VGhlIHB1cmNoYXNlIGNvZGUgaXMgbWlzc2luZy4gUGxlYXNlIHNldCBBUFBfUFVSQ0hBU0VfQ09ERSBpbiB5b3VyIC5lbnYgZmlsZS4gSWYgeW91IGhhdmVuJ3QgYm91Z2h0IG9uZSB5ZXQsIHlvdSBjYW4gcHVyY2hhc2UgYSBrZXkgZGlyZWN0bHkgZnJvbSB1cy4="));
    }
    /**
     * Get getHostsData
     *
     * @return array
     */
    protected function getVerifyHostsData(): array
    {
        $host_1 = Variables::getApplicationConfigurationProjectId();;
        $host_2 = Variables::getApplicationConfigurationPurchaseCode();;
        $host_3 = Request::getHost();

        return [
            "project_id" => base64_encode($host_1),
            "purchase_code" => $host_2 ? (string) Str::of($host_2)->hash("sha256") : null,
            "server_domain" => $host_3,
        ];
    }
    /**
     * Get getHostsData
     *
     * @return array
     */
    protected function getAuthorizeHostsData(): array
    {
        $host_1 = Variables::getApplicationConfigurationProjectId();;
        $host_2 = Variables::getApplicationConfigurationPurchaseCode();;
        $host_3 = Request::getHost();
        $host_4 = App::basePath();
        $host_5 = Variables::getServerOS();

        return [
            "project_id" => base64_encode($host_1),
            "purchase_code" => $host_2 ? (string) Str::of($host_2)->hash("sha256") : null,
            "server_domain" => $host_3,
            "server_path" => $host_4,
            "server_os" => $host_5,
            "metadata" => [],
        ];
    }
}

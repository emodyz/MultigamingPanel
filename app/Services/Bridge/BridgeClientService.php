<?php

namespace App\Services\Bridge;

use Bridge\BridgeClient;
use Bridge\GetVersionRequest;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;

class BridgeClientService
{
    /**
     * @var BridgeClient
     */
    private BridgeClient $client;

    /**
     * BridgeClientService constructor.
     * @throws FileNotFoundException
     */
    public function __construct()
    {
        $this->client = new BridgeClient('host.docker.internal:6660', [
            'credentials' => \Grpc\ChannelCredentials::createSsl(
                Storage::disk('bridge')->get('ca.pem'),
                Storage::disk('bridge')->get('cert.key'),
                Storage::disk('bridge')->get('cert.crt')
            ),
        ]);
    }

    /**
     * @throws Exception
     * @return string
     */
    public function getControlPanelVersion(): string {
        $request = new GetVersionRequest();
        list($response, $status) = $this->client->getVersion($request)->wait();
        if ($status->code !== \Grpc\STATUS_OK) {
            throw new Exception('Error while getting version:' . $status->code . ", " . $status->details . PHP_EOL);
        }
        return $response->getVersion();
    }
}

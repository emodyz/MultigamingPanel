<?php

namespace App\Services\Bridge;

use Bridge\BridgeClient;
use Bridge\EmptyMessage;
use Bridge\UpgradeCpRequest;
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
        $request = new EmptyMessage();
        list($response, $status) = $this->client->getCpVersion($request)->wait();
        if ($status->code !== \Grpc\STATUS_OK) {
            throw new Exception('Error while retrieving current version: ' . $status->code . ", " . $status->details . PHP_EOL);
        }
        return $response->getVersion();
    }

    /**
     * @throws Exception
     * @return string
     */
    public function checkForControlPanelUpdate(): string {
        $request = new EmptyMessage();
        list($response, $status) = $this->client->CheckForCpUpdate($request)->wait();
        if ($status->code !== \Grpc\STATUS_OK) {
            throw new Exception('Error while checking for Control Panel updates: ' . $status->code . ", " . $status->details . PHP_EOL);
        }
        return $response->getTarget();
    }

    /**
     * @throws Exception
     * @return void
     */
    public function upgradeControlPanel(): void {
        $request = new UpgradeCpRequest();

        $target = $this->checkForControlPanelUpdate();
        if ($target === 'none') {
            throw new Exception('Error while initiating Control Panel upgrade: No valid upgrade target found');
        }

        $request->setVersion($target);
        list($response, $status) = $this->client->UpgradeCp($request)->wait();
        if ($status->code !== \Grpc\STATUS_OK) {
            throw new Exception('Error while initiating Control Panel upgrade: ' . $status->code . ", " . $status->details . PHP_EOL);
        }
    }
}

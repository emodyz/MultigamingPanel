<?php

namespace App\Console\Commands;

use Bridge\BridgeClient;
use Bridge\HelloRequest;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;

class TestGrpc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:grpc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'TEST GRPC CLIENT';

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
     * @throws FileNotFoundException
     * TODO: Find trust ca command for all OSs
     * TODO: Test Security on remote when server is bound to 0.0.0.0
     * openssl req -new -newkey rsa:2048 -days 730 -nodes -x509 -subj "/C=/ST=/O=testO/localityName=/commonName=testCN/organizationalUnitName=Developers/emailAddress=me@wirk.fr/" -keyout "ca.key" -out "ca.pem"
     * (macOS Only) sudo security add-trusted-cert -d -r trustRoot -k /Library/Keychains/System.keychain ca.pem
     * openssl genrsa -out cert.key 2048
     * Configure dns in openssl.conf
     * openssl req -new -key cert.key -out cert.csr -subj "/C=/ST=/O=/localityName=/commonName=testBridge/organizationalUnitName=/emailAddress=me@wirk.fr/" -config openssl.conf
     * openssl x509 -req -sha256 -days 730 -CA ca.pem -CAkey ca.key -CAcreateserial -in cert.csr -out cert.crt -extensions v3_req -extfile openssl.conf
     * (macOS Only) sudo security add-trusted-cert -d -r trustAsRoot -k /Library/Keychains/System.keychain cert.crt
     */
    public function handle(): int
    {
        $client = new BridgeClient('host.docker.internal:6660', [
        // $client = new BridgeClient('localhost:6660', [
            // 'grpc.ssl_target_name_override' => 'localhost',
            // 'grpc.default_authority' => 'localhost',
            'credentials' => \Grpc\ChannelCredentials::createSsl(
                Storage::disk('bridge')->get('ca.pem'),
                Storage::disk('bridge')->get('cert.key'),
                Storage::disk('bridge')->get('cert.crt')
            ),
        ]);
        $request = new HelloRequest();
        $request->setName('test php');
        list($response, $status) = $client->SayHello($request)->wait();
        if ($status->code !== \Grpc\STATUS_OK) {
            echo "ERROR: " . $status->code . ", " . $status->details . PHP_EOL;
            exit(1);
        }
        echo $response->getMessage() . PHP_EOL;
        return 0;
    }
}

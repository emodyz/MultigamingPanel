<?php

namespace App\Console\Commands;

use Bridge\BridgeClient;
use Bridge\HelloRequest;
use Illuminate\Console\Command;

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
     */
    public function handle(): int
    {
        $client = new BridgeClient('host.docker.internal:6660', [
            'credentials' => \Grpc\ChannelCredentials::createInsecure(),
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

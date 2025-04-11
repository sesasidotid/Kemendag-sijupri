<?php

namespace Eyegil\SecurityOauth2\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Client;

class CreateOauth2Client extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eyegil:oauth2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Generate oauth2 client's based on (eyegil) config | doc: https://github.com/eyegil";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $clientList = config('eyegil.security.oauth2.clients');
        foreach ($clientList as $client_id => $value) {
            $client = Client::find($value['id']) ?? new Client();
            $client->id = $value['id'];
            $client->secret = $value['secret'];
            $client->name = $value['id'];
            $client->redirect = $value['redirectUris'];
            $client->personal_access_client = true;
            $client->password_client = true;
            $client->revoked = false;
            $client->provider = config("auth.guards.api.provider");
            $client->save();
        }
    }
}

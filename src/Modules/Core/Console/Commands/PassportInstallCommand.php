<?php

namespace App\Modules\Core\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Passport\ClientRepository;

class PassportInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:passport:install
                            {--force : Overwrite keys they already exist}
                            {--length=4096 : The length of the private key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the commands necessary to prepare Passport for use';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(ClientRepository $client)
    {
        $this->call('passport:keys', ['--force' => $this->option('force'), '--length' => $this->option('length')]);
        if( ! \Core::oauthCLients()->first(['password_client' => 1])->count()) {
    
            $client = $client->createPasswordGrantClient(
                null, config('app.name'), 'http://localhost'
            );
            \DotenvEditor::setKey('PASSWORD_CLIENT_ID', $client->id);
            \DotenvEditor::setKey('PASSWORD_CLIENT_SECRET', $client->secret);
            \DotenvEditor::save();
        }
    }
}

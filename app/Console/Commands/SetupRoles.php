<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Spatie\Permission\Models\Role;

class SetupRoles extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:roles {roles*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup all roles needed with application.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        collect($this->argument('roles'))->each(function (string $role, int $key) {
            $role = Role::create([
                'name' => $role,
            ]);
        });
        $this->info('Roles successfully setuped.');
    }
}

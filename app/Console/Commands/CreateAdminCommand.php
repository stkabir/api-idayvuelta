<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create
                            {name? : Nombre del administrador}
                            {email? : Correo electrónico del administrador}
                            {password? : Contraseña del administrador}
                            {--force : Sobrescribir el usuario si el email ya existe}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea un usuario administrador para el panel de Filament';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->argument('name') ?? $this->ask('Nombre del administrador');
        $email = $this->argument('email') ?? $this->ask('Correo electrónico del administrador');
        $password = $this->argument('password') ?? $this->secret('Contraseña del administrador');

        if (empty($name) || empty($email) || empty($password)) {
            $this->error('Nombre, email y contraseña son obligatorios.');
            return SymfonyCommand::FAILURE;
        }

        $validator = Validator::make(
            ['email' => $email],
            ['email' => ['required', 'email']]
        );

        if ($validator->fails()) {
            $this->error('El correo electrónico no es válido.');
            return SymfonyCommand::FAILURE;
        }

        if (strlen($password) < 8) {
            $this->error('La contraseña debe tener al menos 8 caracteres.');
            return SymfonyCommand::FAILURE;
        }

        $role = Role::firstOrCreate(
            ['name' => 'admin', 'guard_name' => 'web'],
            ['name' => 'admin', 'guard_name' => 'web']
        );

        $existingUser = User::where('email', $email)->first();

        if ($existingUser && ! $this->option('force')) {
            $this->warn("Ya existe un usuario con el email {$email}.");
            $this->warn('Usa --force para actualizar su contraseña y asegurar el rol admin.');
            return SymfonyCommand::FAILURE;
        }

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
            ]
        );

        if (! $user->hasRole('admin')) {
            $user->assignRole($role);
        }

        $this->info('Usuario administrador creado correctamente.');
        $this->table(
            ['Campo', 'Valor'],
            [
                ['Nombre', $user->name],
                ['Email', $user->email],
                ['Rol', 'admin'],
                ['Creado', $user->wasRecentlyCreated ? 'Sí' : 'Actualizado'],
            ]
        );

        return SymfonyCommand::SUCCESS;
    }
}

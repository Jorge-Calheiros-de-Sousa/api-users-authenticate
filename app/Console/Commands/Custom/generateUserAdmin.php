<?php

namespace App\Console\Commands\Custom;

use App\Repositories\Contracts\UserRepositoryContract;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class generateUserAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:create-user-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user admin';

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
    public function handle()
    {
        try {
            $data = [
                "name" => $this->ask("Nome*: "),
                "email" => $this->ask("Email*: "),
                "phone" => $this->ask("Telefone (00000000000)*: "),
                "password" => $this->ask("Senha*: "),
                "confirmPassword" => $this->ask("Confirme sua senha*: "),
                "description" => $this->ask("Descrição: "),
                "linkedin" => $this->ask("Linkedin(Link): "),
                "github" => $this->ask("GitHub(Link)"),
                "isAdmin" => true
            ];
            $validator = Validator::make($data, [
                'name' => 'required|max:50',
                'email' => 'required|email',
                'phone' => 'required|max:11|min:11',
                'description' => 'nullable',
                'linkedin' => 'nullable',
                'github' => 'nullable',
                'password' => 'required|min:8|max:8',
                'confirmPassword' => 'required_with:password|same:password|min:8|max:8'
            ]);

            if ($validator->fails()) {
                $message = $validator->getMessageBag();
                throw new Exception("$message");
            }

            if (!$this->confirm("Deseja continuar? ")) {
                $this->info("Cancelado");
                exit;
            }

            if (array_key_exists("password", $data) && $data["password"]) {
                $data["password"] = Hash::make($data["password"]);
            }

            $userRepository = app(UserRepositoryContract::class);
            if (!$created = $userRepository->create($data)) {
                throw new Exception($created);
            }
            return $this->info("Criado com sucesso!");
        } catch (\Throwable $th) {
            return $this->error('Command error' . $th->getMessage());
        }

        return 0;
    }
}

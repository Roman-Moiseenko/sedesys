<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Modules\Admin\Entity\Admin;
use Illuminate\Console\Command;

class CreateAdminCommand extends Command
{
    protected $signature = 'admin:create {name}';
    protected $description = 'Command description';

    public function handle()
    {
        $name = $this->argument('name');
        if (Admin::where('name', $name)->first()) {
            $this->error('Администратор с таким логином уже существует ');
            return false;
        }
        $email = $this->ask('Укажите почту для аутентификации');
        $phone = $this->ask('Укажите телефон для аутентификации');
        $password = $this->ask('Введите пароль');

        $admin = Admin::register($name, $email, $phone, $password);
        $this->info('Пользователь ' . $name . ' создан');
        $admin->setRole(Admin::ROLE_ADMIN);
        $this->info('Роль Администратора назначена!');
        return true;
    }
}

<?php

namespace App\Database\Seeds;

use App\Entities\User;
use App\Models\UserModel;
use CodeIgniter\Config\Factories;
use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        try {

            $this->db->transStart();

            $userModel = Factories::models(UserModel::class);

            $user = new User([
                'name'      => 'Admin',
                'is_active' => 1,
                'email'     => 'admin@admin.com',
                'password'  => '123456',
            ]);

            if (!$userId = $userModel->skipValidation(true)->protect(false)->insert($user)) {

                dd($userModel->errors());
            }

            self::createUserAdmin($userId);

            $this->db->transComplete();

            echo "Admin criado com sucesso!" . PHP_EOL;
        } catch (\Exception $e) {

            echo $e->getMessage();
        }
    }


    private static function createUserAdmin(int $userId)
    {

        $db = \Config\Database::connect();

        $admin = [
            'user_id' => $userId
        ];

        $db->table('users_admin')->insert($admin);
    }
}

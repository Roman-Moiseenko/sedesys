<?php
declare(strict_types=1);

namespace App\Modules\Admin\Service;

use App\Modules\Admin\Entity\Admin;
use App\Modules\Base\Entity\FullName;
use App\Modules\Base\Entity\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffService
{
    public function create(Request $request): Admin
    {
        $staff = Admin::register(
            (string)$request->string('name'),
            (string)$request->string('phone'),
            (string)$request->string('password')
        );

        $this->save_fields($staff, $request);

        $staff->refresh();
        return $staff;
    }

    public function update(Admin $staff, Request $request)
    {
        $staff->name = (string)$request->string('name');
        $staff->phone = (string)$request->string('phone');
        if ($request->has('password')) {
            $staff->password = Hash::make((string)$request->string('password'));
            //flash('Пароль сменен');
        }
        $staff->save();
        if ($request->boolean('clear_file')) {
            $staff->photo->delete();
        }
        $this->save_fields($staff, $request);
    }

    private function save_fields(Admin $staff, Request $request)
    {
        $staff->role = (string)$request->string('role');
        $staff->post = (string)$request->string('post');
        $staff->telegram_user_id = $request->integer('telegram_user_id');

        $staff->fullname = new FullName(
            (string)$request->string('surname'),
            (string)$request->string('firstname'),
            (string)$request->string('secondname')
        );
        $staff->save();

        $this->photo($staff, $request->file('file'));
    }

    public function destroy(Admin $staff)
    {
        $staff->delete();
    }

    public function photo(Admin $admin, $file): void
    {
        if (empty($file)) return;
        if (!empty($admin->photo)) {
            $admin->photo->newUploadFile($file);
        } else {
            $admin->photo()->save(Photo::upload($file));
        }
        $admin->refresh();
    }
}

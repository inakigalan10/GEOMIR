<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'admin']);
        $adminEditor = Role::create(['name' => 'editor']);
        $adminAuthor = Role::create(['name' => 'author']);



        Permission::create(['name' => 'files.*']);
        Permission::create(['name' => 'files.list']);
        Permission::create(['name' => 'files.create']);
        Permission::create(['name' => 'files.update']);
        Permission::create(['name' => 'files.read']);
        Permission::create(['name' => 'files.delete']);

        Permission::create(['name' => 'posts.*']);
        Permission::create(['name' => 'posts.list']);
        Permission::create(['name' => 'posts.create']);
        Permission::create(['name' => 'posts.update']);
        Permission::create(['name' => 'posts.read']);
        Permission::create(['name' => 'posts.delete']);


        Permission::create(['name' => 'places.*']);
        Permission::create(['name' => 'places.list']);
        Permission::create(['name' => 'places.create']);
        Permission::create(['name' => 'places.update']);
        Permission::create(['name' => 'places.read']);
        Permission::create(['name' => 'places.delete']);



        $adminRole->givePermissionTo([ 'files.*', 'posts.*', 'places.*' ]);
        $adminEditor->givePermissionTo([ 'files.list', 'files.update', 'files.read', 'posts.list', 'posts.update', 'posts.read', 'places.list', 'places.update', 'places.read' ]);
        $adminAuthor->givePermissionTo([ 'files.list', 'files.create', 'files.read','files.delete', 'posts.list', 'posts.read', 'posts.create','posts.delete', 'places.read', 'places.update', 'places.read', 'places.delete' ]);



        $name  = config('admin.name');
        $admin = User::where('name', $name)->first();
        $admin->assignRole('admin');




    }
}

<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsersRepository
{

    public static function all()
    {
        return DB::table('users')->get();
    }

    public static function find($id)
    {
        return DB::table('users')
            ->where('id', $id)
            ->first();
    }

    public static function create(array $data)
    {
        $user = User::create($data);
        return $user->id;
    }

    public static function update($id, array $data)
    {
        try {
            $user = User::find($id);
            if ($user) {
                return $user->update($data);
            }
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            \Log::error('Error updating user: ' . $e->getMessage());
        }
        return false;
    }

    public static function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            return $user->delete();
        }
        return false;
    }

}

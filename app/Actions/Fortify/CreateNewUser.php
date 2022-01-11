<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'nombre' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'usuario' => ['required', 'string', 'max:255'],
            'rol_id' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'nombre' => $input['nombre'],
            'apellidos' => $input['apellidos'],
            'usuario' => $input['usuario'],
            'email' => $input['email'],
            'rol_id'=>$input['rol_id'],
            'password' => Hash::make($input['password']),
        ]);
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\AbUser;

class AbUserFactory extends Factory
{

    protected $model = AbUser::class;


    public function definition()
    {
        return [
            'ab_name'     => $this->faker->name(),
            'ab_password' => bcrypt('secret'),
            'ab_mail'     => $this->faker->unique(true)->safeEmail(),
        ];
    }
}

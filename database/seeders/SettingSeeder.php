<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Setting::create(
            [
                'setting_name' => 'general',
                'setting_value' => [
                    'resto_name' => 'RESTO APP',
                    'resto_address' => fake()->streetAddress(),
                    'resto_phone' => fake()->e164PhoneNumber(),
                ],
            ],
        );
        Setting::create(
            [
                'setting_name' => 'hours',
                'setting_value' => [
                    'mon' => [
                        [
                            'from' => '08:30',
                            'to' => '13:00',
                        ],
                        [
                            'from' => '14:30',
                            'to' => '23:30',
                        ],
                    ],
                    'tue' => [
                        [
                            'from' => '08:30',
                            'to' => '13:00',
                        ],
                        [
                            'from' => '14:30',
                            'to' => '23:30',
                        ],
                    ],
                ],
            ]
        );
        Setting::create(
            [
                'setting_name' => 'company',
                'setting_value' => [
                    'company_name' => 'RESTO GROUP, SARL',
                    'company_ice' => fake()->randomNumber(5, true),
                ],
            ]
        );
    }
}

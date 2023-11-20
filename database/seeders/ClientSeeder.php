<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\DeliveredOrder;
use App\Models\ImportedOrder;
use App\Models\Item;
use App\Models\ItemVariation;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Table;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create clients which have imported orders
        Client::factory()
            ->count(fake()->numberBetween(1, 10))
            ->has(
                Order::factory()
                    ->count(fake()->numberBetween(1, 15))
                    ->has(
                        ImportedOrder::factory(),
                        'imported_order'
                    )
                    ->hasAttached(
                        ItemVariation::factory()
                            ->count(1)
                            ->for(
                                Item::factory()
                                    ->for(
                                        Menu::factory()
                                    )
                            ),
                        [
                            'item_quantity' => fake()->numberBetween(1, 5),
                        ],
                        'item_variations'
                    )
                    ->for(
                        User::factory()
                            ->create()
                            ->assignRole('cashier'),
                        'cashier'
                    )
            )
            ->create();
        // create clients which have delivered orders
        Client::factory()
            ->count(fake()->numberBetween(1, 10))
            ->has(
                Order::factory()
                    ->count(fake()->numberBetween(1, 15))
                    ->has(
                        DeliveredOrder::factory(),
                        'delivered_order'
                    )
                    ->hasAttached(
                        ItemVariation::factory()
                            ->count(1)
                            ->for(
                                Item::factory()
                                    ->for(
                                        Menu::factory()
                                    )
                            ),
                        [
                            'item_quantity' => fake()->numberBetween(1, 5),
                        ],
                        'item_variations'
                    )
                    ->for(
                        User::factory()
                            ->create()
                            ->assignRole('cashier'),
                        'cashier'
                    )
            )
            ->create();
        // create clients which have on-site orders
        Client::factory()
            ->count(fake()->numberBetween(1, 10))
            ->has(
                Order::factory()
                    ->count(fake()->numberBetween(1, 15))
                    ->hasAttached(
                        Table::factory(),
                        [
                            'reserved_from' => Carbon::now(),
                        ]
                    )
                    ->hasAttached(
                        ItemVariation::factory()
                            ->count(1)
                            ->for(
                                Item::factory()
                                    ->for(
                                        Menu::factory()
                                    )
                            ),
                        [
                            'item_quantity' => fake()->numberBetween(1, 5),
                        ],
                        'item_variations'
                    )
                    ->for(
                        User::factory()
                            ->create()
                            ->assignRole('cashier'),
                        'cashier'
                    )
            )
            ->create();
    }
}

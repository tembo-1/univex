<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call([
            DiscountTypeSeeder::class,
            RoleSeeder::class,
            OrganizationStatusSeeder::class,
            UserSeeder::class,
            EmployeeSeeder::class,
            WareHouseSeeder::class,
            OrganizationSeeder::class,
            ProductWarehouseStatusSeeder::class,
            ManufacturerSeeder::class,
            ProductSeeder::class,
            ProductOriginalSeeder::class,
            ProductSubstitutionSeeder::class,
            ProductPriceSeeder::class,
            WarehouseProductSeeder::class,
            CallbackTypeSeeder::class,
            OrderStatusSeeder::class,
            ShippingTypeSeeder::class,
            RefundStatusSeeder::class,
            RefundTypeSeeder::class,
            MailingStatusSeeder::class,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class WareHouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = Storage::disk('public')->get('univexnav_stock.json');
        $warehouses = json_decode($json, true);

        collect($warehouses[2]['data'])->map(function ($warehouse) {
            Warehouse::query()
                ->create([
                    'name' => $warehouse['VendorSiteLabel'],
                    'slug' => $warehouse['VendorLabel'],
                    'code' => $warehouse['VendorCode'],
                ]);
        });
    }
}

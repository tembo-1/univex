<?php

namespace Database\Seeders;

use App\Models\Manufacturer;
use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = Storage::disk('public')->get('univexnav_manufacturer.json');
        $manufactures = json_decode($json, true);

        $data = collect($manufactures[2]['data'])->unique('ID')->map(function ($manufacture) {
            return [
                'name' => $manufacture['ManufacturerName'],
                'slug' => Str::slug($manufacture['ManufacturerName']),
                'is_active' => true,
                'position' => 0,
                'is_visible' => $manufacture['Flag'],
                'code' => $manufacture['ID'],
            ];
        });

        Manufacturer::query()->insert($data->toArray());
    }
}

<?php

namespace Database\Seeders;

use App\Models\OptionValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OptionValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Option: USAGE TYPE
        // Product: Packaging

        OptionValue::create([
            'option_id' => 1,
            'value' => 'Botol',
            'slug' => 'botol',
            'category_id' => null,
        ]);
        OptionValue::create([
            'option_id' => 1,
            'value' => 'Kaleng',
            'slug' => 'kaleng',
            'category_id' => null,
        ]);
        OptionValue::create([
            'option_id' => 1,
            'value' => 'Amplop',
            'slug' => 'amplop',
            'category_id' => null,
        ]);
        OptionValue::create([
            'option_id' => 1,
            'value' => 'Plastik',
            'slug' => 'plastik',
            'category_id' => null,
        ]);
        
        // Option: SIZE
        // Product: Banner

        // Category: X-Banner
        // Mini
        OptionValue::create([
            'option_id' => 2,
            'value' => '26 cm x 38 cm',
            'slug' => '26-cm-x-38-cm',
            'category_id' => 5,
        ]);
        OptionValue::create([
            'option_id' => 2,
            'value' => '24 cm x 40 cm',
            'slug' => '24-cm-x-40-cm',
            'category_id' => 5,
        ]);
        OptionValue::create([
            'option_id' => 2,
            'value' => '30 cm x 42 cm',
            'slug' => '30-cm-x-42-cm',
            'category_id' => 5,
        ]);
        // Normal
        OptionValue::create([
            'option_id' => 2,
            'value' => '60 cm x 160 cm',
            'slug' => '60-cm-x-160-cm',
            'category_id' => 5,
        ]);
        OptionValue::create([
            'option_id' => 2,
            'value' => '60 cm x 120 cm',
            'slug' => '60-cm-x-120-cm',
            'category_id' => 5,
        ]);
        OptionValue::create([
            'option_id' => 2,
            'value' => '80 cm x 180 cm',
            'slug' => '80-cm-x-180-cm',
            'category_id' => 5,
        ]);
        OptionValue::create([
            'option_id' => 2,
            'value' => '80 cm x 200 cm',
            'slug' => '80-cm-x-200-cm',
            'category_id' => 5,
        ]);

        // Category: Y-Banner
        OptionValue::create([
            'option_id' => 2,
            'value' => '60 cm x 160 cm',
            'slug' => '60-cm-x-160-cm-1',
            'category_id' => 6,
        ]);

        // Category: Roll Up Banner
        OptionValue::create([
            'option_id' => 2,
            'value' => '80 cm x 200 cm',
            'slug' => '80-cm-x-200-cm-1',
            'category_id' => 7,
        ]);
        OptionValue::create([
            'option_id' => 2,
            'value' => '60 cm x 160 cm',
            'slug' => '60-cm-x-160-cm-2',
            'category_id' => 7,
        ]);
        OptionValue::create([
            'option_id' => 2,
            'value' => '85 cm x 200 cm',
            'slug' => '85-cm-x-200-cm',
            'category_id' => 7,
        ]);
        OptionValue::create([
            'option_id' => 2,
            'value' => '120 cm x 200 cm',
            'slug' => '120-cm-x-200-cm',
            'category_id' => 7,
        ]);
        OptionValue::create([
            'option_id' => 2,
            'value' => '150 cm x 200 cm',
            'slug' => '150-cm-x-200-cm',
            'category_id' => 7,
        ]);

        // Category: Flag Banner
        OptionValue::create([
            'option_id' => 2,
            'value' => '60 cm x 160 cm',
            'slug' => '60-cm-x-160-cm-3',
            'category_id' => 8,
        ]);

        // Category: Giant Banner
        OptionValue::create([
            'option_id' => 2,
            'value' => '60 cm x 160 cm',
            'slug' => '60-cm-x-160-cm-4',
            'category_id' => 9,
        ]);

        // Product: Sticker
        // Category: Vinyl
        OptionValue::create([
            'option_id' => 2,
            'value' => '4 cm x 6 cm',
            'slug' => '4-cm-x-6-cm',
            'category_id' => 10,
        ]);

        // Category: HVS
        OptionValue::create([
            'option_id' => 2,
            'value' => '4 cm x 6 cm',
            'slug' => '4-cm-x-6-cm-1',
            'category_id' => 11,
        ]);

        // Category: Chromo
        OptionValue::create([
            'option_id' => 2,
            'value' => '4 cm x 6 cm',
            'slug' => '4-cm-x-6-cm-2',
            'category_id' => 12,
        ]);

        // Category: Foil
        OptionValue::create([
            'option_id' => 2,
            'value' => '4 cm x 6 cm',
            'slug' => '4-cm-x-6-cm-3',
            'category_id' => 13,
        ]);

        // Category: Bontax
        OptionValue::create([
            'option_id' => 2,
            'value' => '4 cm x 6 cm',
            'slug' => '4-cm-x-6-cm-4',
            'category_id' => 14,
        ]);

        // Category: Yupo
        OptionValue::create([
            'option_id' => 2,
            'value' => '4 cm x 6 cm',
            'slug' => '4-cm-x-6-cm-5',
            'category_id' => 15,
        ]);

        // Category: Scotchlite
        OptionValue::create([
            'option_id' => 2,
            'value' => '4 cm x 6 cm',
            'slug' => '4-cm-x-6-cm-6',
            'category_id' => 16,
        ]);

        // Category: One Way
        OptionValue::create([
            'option_id' => 2,
            'value' => '4 cm x 6 cm',
            'slug' => '4-cm-x-6-cm-7',
            'category_id' => 17,
        ]);

        // Category: Transparan
        OptionValue::create([
            'option_id' => 2,
            'value' => '4 cm x 10 cm',
            'slug' => '4-cm-x-10-cm',
            'category_id' => 18,
        ]);
    }
}

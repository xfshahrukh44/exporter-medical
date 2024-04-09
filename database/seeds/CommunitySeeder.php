<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\LazyCollection;
use App\Product;


class CommunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();

        $report = fopen(base_path("database/data/financial-report.csv"), "r");

        $dataRow = true;
        while (($data = fgetcsv($report, 9000, ",")) !== FALSE) {
            if (!$dataRow) {
                Product::create(
                ['product_title'=>$dataRow[0]]
               );
            }
            $dataRow = false;
        }

        fclose($report);
    }
}

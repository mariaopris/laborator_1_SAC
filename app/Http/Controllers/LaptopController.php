<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests as Reqs;

class LaptopController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
    public function addDataToRecombee() {
        $client = new Client("sac-project-laptops", 'GNtRIgEf3pBTIWnmNecftZZYzn6fjcUbbpIyy6NIIAPzZX2DWDA3RYBVv9cuFBEz', ['region' => 'eu-west']);
        $csvData = array_map('str_getcsv', file(public_path('Laptops.csv')));
        $current_city = $csvData[1][0];
        $counter = 0;

        $client->send(new Reqs\AddItemProperty('brand', 'string'));
        $client->send(new Reqs\AddItemProperty('laptop_name', 'string'));
        $client->send(new Reqs\AddItemProperty('display_size', 'double'));
        $client->send(new Reqs\AddItemProperty('processor_type', 'string'));
        $client->send(new Reqs\AddItemProperty('graphics_card', 'string'));
        $client->send(new Reqs\AddItemProperty('disk_space', 'string'));
        $client->send(new Reqs\AddItemProperty('discount_price', 'double'));
        $client->send(new Reqs\AddItemProperty('old_price', 'double'));
        $client->send(new Reqs\AddItemProperty('ratings_5max', 'string'));

        for($i = 1; $i < count($csvData); $i++){
            var_dump('line: '. $i);
            if($counter <= 1000) {
                $brand = $csvData[$i][0];
                $laptop_name = $csvData[$i][1];
                $display_size = $csvData[$i][2];
                $processor_type = $csvData[$i][3];
                $graphics_card = $csvData[$i][4];
                $disk_space = $csvData[$i][5];
                $discount_price = $csvData[$i][6];
                $old_price = $csvData[$i][7];
                $ratings_5max = $csvData[$i][8];

                $counter++;
                $client->send(new Reqs\AddItem($counter));
                $client->send(new Reqs\SetItemValues($counter, ['brand' => $brand, 'laptop_name'=>$laptop_name, 'display_size'=>$display_size, 'processor_type'=>$processor_type,
                    'graphics_card'=>$graphics_card, 'disk_space'=>$disk_space, 'discount_price' =>$discount_price, 'old_price'=>$old_price, 'ratings_5max'=>$ratings_5max]));
            }
        }

        return "Data imported successfully";
    }

}

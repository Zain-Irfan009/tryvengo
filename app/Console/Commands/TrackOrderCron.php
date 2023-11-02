<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Console\Command;

class TrackOrderCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trackorder:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $setting=Setting::first();
        $orders=Order::where('tryvengo_status','!=','Delivered')->get();
        $url = 'https://tryvengo.com/api/track-order';
        foreach ($orders as $order){


            $data = [
                'email' =>'orders@mubkhar.com',
                'password' => 'Mubkv9Qh@1',
                'invoice_id'=>$order->invoice_id,
            ];

            // Build the cURL request
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false),
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => http_build_query($data), // Convert data to a query string
                CURLOPT_HTTPHEADER => array(
                    'email: ' . $setting->email,
                    'password: ' . $setting->password,
                    'Content-Type: application/x-www-form-urlencoded',
                ),
            ));

            // Execute the cURL request
            $response = curl_exec($curl);

            // Close the cURL session
            curl_close($curl);

            // Decode the JSON response
            $responseData = json_decode($response, true);
            if($responseData['status']==1){

                $order->tryvengo_status=$responseData['order_data']['order_status'];
                $order->save();
            }
        }
    }
}

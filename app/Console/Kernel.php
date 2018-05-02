<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\api_provider;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Crypt;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function(){
            $provider = api_provider::where('isOn','1')->first();
            if ($provider){

                $curl = curl_init();
                //$url = 'https://api.mendeley.com/oauth/token';
                $url = $provider->host.'/oauth/token';
                $query = array ('grant_type' => 'client_credentials', 'scope' => 'all');

                $id = $provider->id_app;
                $secret = Crypt::decryptString($provider->secret_app);
                //$id = "5047"; //ID dell'applicazione
                //$secret = "iOU6ZIt9cvL5spaz"; //Codice segreto che viene fornito da Mendeley alla registrazione dell'applicazione
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($query));
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_USERPWD, $id . ":" . $secret);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($curl);
                if (curl_errno($curl)){
                    $messageError = curl_error($curl);
                    curl_close($curl);
                    view('search.result',compact('result'))->with('error','Error:' . $messageError);
                }
                $json = json_decode($result, true);
                $token = $json['access_token'];
                $provider->remember_token = $token;
                $provider->save();
                curl_close($curl);
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

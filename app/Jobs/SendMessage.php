<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private float $dAb;
    private float $avg;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(float $dAb, float $avg)
    {
        $this->dAb = $dAb;
        $this->avg = $avg;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Log::info('entrou no job');
            $apiKey = '8044441b162376a679bdf1237fcac8da10b32ca36d96c43e63fd0dd987d491964eb378b180f82ced';
            $phone = '+555496851233';
            $name = "Jeam";

            $now  = (new Carbon())->format("H:i");

            if ($this->dAb < $this->avg) {
                $message_text = "Olá " . $name . "\n";
                $message_text .= "Aqui vai um resumo das suas atividades: tudo está fluindo perfeitamente. Continue assim, você está indo muito bem!";
            } else {
                $message_text = "Olá " . $name . "\n";
                $message_text .= "Aqui vai um resumo das suas atividades: às ".$now.", notamos uma discrepância significativa. Cuidado! Se precisar de ajuda, estamos aqui para apoiar.";
            }

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.wassenger.com/v1/messages",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    "phone" => $phone,
                    "message" => $message_text
                ]),
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "Token: $apiKey"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            // if ($err) {
            //     echo "cURL Error #:" . $err;
            // } else {
            //     echo "Response: " . $response;
            // }   
        } catch (\Exception $e) {
            $this->fail($e);
        }
    }
}

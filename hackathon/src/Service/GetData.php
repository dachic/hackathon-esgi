<?php

namespace App\Service;

class GetData 
{

    /**
     * @param array $words
     * @return array
    */
    public function get(string $words) 
    {
        $curl = curl_init();
        
        $url = "https://api.ozae.com/gnw/articles?date=20130601__20140601&key=f4a5f6832e204f4db1e3977465df9db2&edition=fr-fr&query=%s&hard_limit=400";

        $url = sprintf($url, $words);

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        $results = curl_exec($curl);

        curl_close($curl);

        return $results;
    }
}

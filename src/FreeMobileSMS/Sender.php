<?php

namespace FreeMobileSMS;

class Sender
{
    /**
     * @var string
     */
    private $base_uri;
    private $user_id;
    private $api_key;

    public function __construct($user_id, $api_key)
    {
        $this->base_uri = 'https://smsapi.free-mobile.fr/sendmsg';
        $this->user_id = $user_id;
        $this->api_key = $api_key;
    }

    public function Send($msg)
    {
        $data = array(
            'user' => $this->user_id,
            'pass' => $this->api_key,
            'msg' => $msg
        );
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $this->base_uri.'?user='.$data['user'].'&pass='.$data['pass'].'&msg='.urlencode($data['msg'])
        ]);
        try{
            curl_exec($curl);

            switch (curl_getinfo($curl, CURLINFO_RESPONSE_CODE)){

                case 200:
                    curl_close($curl);
                    return true;
                    break;

                case 400:
                    curl_close($curl);
                    throw new \Exception("one of the required parameters is missing");
                    break;

                case 402:
                    curl_close($curl);
                    throw new \Exception("too many messages was sent in a short period of time");
                    break;

                case 403:
                    curl_close($curl);
                    throw new \Exception("the client side service is currently disabled");
                    break;

                case 500:
                    curl_close($curl);
                    throw new \Exception("server side error, try again later");
                    break;

                default:
                    curl_close($curl);
                    throw new \Exception("an unexpected error as occurred");
                    break;
            }


        }catch (Exception $e){
            die($e->getMessage());
        }
    }
}
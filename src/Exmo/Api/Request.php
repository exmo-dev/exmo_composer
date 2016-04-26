<?php
namespace Exmo\Api;

use Exception;

/**
 * @api
 */
class Request
{
    /**
     * @var string
     */
    private $key;
    /**
     * @var string
     */
    private $secret;
    /**
     * @var string
     */
    private $url;

    /**
     * @param string $key
     * @param string $secret
     * @param string $url
     */
    public function __construct($key, $secret, $url = 'http://api.exmo.com/v1/')
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->url = $url;
    }

    /**
     * @param $api_name
     * @param array $req
     * @return mixed
     * @throws Exception
     */
    public function query($api_name, array $req = [])
    {
        $mt = explode(' ', microtime());
        $NONCE = $mt[1] . substr($mt[0], 2, 6);

        $req['nonce'] = $NONCE;

        // generate the POST data string
        $post_data = http_build_query($req, '', '&');

        $sign = hash_hmac('sha512', $post_data, $this->secret);

        // generate the extra headers
        $headers = [
            'Sign: ' . $sign,
            'Key: ' . $this->key
        ];

        // our curl handle (initialize if required)
        static $ch = null;
        if ($ch === null) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; PHP client; ' . php_uname('s') . '; PHP/' . phpversion() . ')');
        }
        curl_setopt($ch, CURLOPT_URL, $this->url . $api_name);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        // run the query
        $res = curl_exec($ch);
        if ($res === false) {
            throw new Exception('Could not get reply: ' . curl_error($ch));
        }

        $dec = json_decode($res, true);
        if ($dec === null) {
            throw new Exception('Invalid data received, please make sure connection is working and requested API exists');
        }


        return $dec;
    }


}
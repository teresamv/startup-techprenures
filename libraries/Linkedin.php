<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Linkedin {
    private $client_id;
    private $client_secret;
    private $redirect_uri;
    private $scopes;

    public function __construct() {
        $this->client_id = get_instance()->config->item('linkedin_client_id');
        $this->client_secret = get_instance()->config->item('linkedin_client_secret');
        $this->redirect_uri = get_instance()->config->item('linkedin_redirect_uri');
        $this->scopes = get_instance()->config->item('scopes');
    }

    public function get_login_url() {
        $params = http_build_query([
            'response_type' => 'code',
            'client_id' => $this->client_id,
            'redirect_uri' => $this->redirect_uri,
            'scope' => implode(' ', $this->scopes)
        ]);
        return "https://www.linkedin.com/oauth/v2/authorization?$params";
    }

    public function get_access_token($code) {
        $url = 'https://www.linkedin.com/oauth/v2/accessToken';
        $params = [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $this->redirect_uri,
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret
          ];
         return $this->make_request($url, $params);
    }

    public function get_user_info($access_token) {
        $url = 'https://api.linkedin.com/v2/userinfo';
        $headers = [
            "Authorization: Bearer $access_token",
            "Content-Type: application/json",
            "x-li-format: json"
        ];
        return $this->make_request($url, [], $headers);
    }

    private function make_request($url, $params = [], $headers = []) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if (!empty($params)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
            exit;
        }
        curl_close($ch);
        return json_decode($response, true);
    }
}
?>

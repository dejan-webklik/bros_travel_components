<?php
defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView;

class BrostravelViewHotel extends HtmlView
{
    protected $item;

    public function display($tpl = null)
    {
        $app = \Joomla\CMS\Factory::getApplication();
        $input = $app->getInput();
        $propertyid = $input->getInt('propertyid', 0);

        $token = '';
        $loginData = [
            "jsonrpc" => "2.0",
            "method" => "login",
            "params" => ["username" => "test_bros", "password" => "brostest"],
            "id" => 1
        ];

        $response = $this->sendRequest($loginData);
        if (isset($response['result']['token'])) {
            $token = $response['result']['token'];
        }

        $request = [
            "jsonrpc" => "2.0",
            "method" => "getProperty",
            "params" => ["propertyid" => $propertyid],
            "id" => 1
        ];

        $property = $this->sendRequest($request, $token);
        $this->item = $property['result'] ?? [];

        parent::display($tpl);
    }

    private function sendRequest($data, $token = '')
    {
        $curl = curl_init("https://testservices.bros-travel.com");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            $token ? "Authorization: Bearer {$token}" : ''
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response, true);
    }
}

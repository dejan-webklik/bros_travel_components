<?php
defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView;

class BrostravelViewHotels extends HtmlView
{
    protected $items;
    protected $locations;
    protected $selectedLocation;

    public function display($tpl = null)
    {
        $app = \Joomla\CMS\Factory::getApplication();
        $input = $app->input;
        $this->selectedLocation = $input->getInt('locationid', 0);

        // Login
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

        // Get locations
        $locationsReq = [
            "jsonrpc" => "2.0",
            "method" => "getLocations",
            "params" => null,
            "id" => 1
        ];
        $locationsRes = $this->sendRequest($locationsReq, $token);
        $this->locations = $locationsRes['result'] ?? [];

        // Get hotels (all or filtered)
        if ($this->selectedLocation) {
            $request = [
                "jsonrpc" => "2.0",
                "method" => "searchProperties",
                "params" => ["locationid" => $this->selectedLocation],
                "id" => 1
            ];
        } else {
            $request = [
                "jsonrpc" => "2.0",
                "method" => "getProperties",
                "params" => null,
                "id" => 1
            ];
        }

        $properties = $this->sendRequest($request, $token);
        $this->items = $properties['result'] ?? [];

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


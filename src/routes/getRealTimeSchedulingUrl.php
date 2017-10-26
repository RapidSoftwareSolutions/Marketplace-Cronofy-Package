<?php

$app->post('/api/Cronofy/getRealTimeSchedulingUrl', function ($request, $response) {

    $settings = $this->settings;
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['clientId','clientSecret','redirectUri','eventId','summary','description','eventStart','eventEnd','tzid','availability']);

    if(!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback']=='error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $post_data = $validateRes;
    }

    $requiredParams = ['clientId'=>'client_id','clientSecret'=>'client_secret','redirectUri'=>'redirect_uri','eventId'=>'event_id','summary'=>'summary','description'=>'description','eventStart'=>'eventStart','eventEnd'=>'eventEnd','tzid'=>'tzid','availability'=>'availability'];
    $optionalParams = ['state'=>'state','transparency'=>'transparency','reminders'=>'reminders','url'=>'url','targetCalendars'=>'target_calendars','callbackUrl'=>'callback_url','formattingHourFormat'=>'formattingHourFormat','suppressAddToCalendar'=>'suppress_add_to_calendar'];
    $bodyParams = [
       'json' => ['client_id','client_secret','oauth','event','availability','required_duration','available_periods','target_calendars','callback_url','formatting','suppress_add_to_calendar']
    ];

    $data = \Models\Params::createParams($requiredParams, $optionalParams, $post_data['args']);

    

    $client = $this->httpClient;
    $query_str = "https://api.cronofy.com/v1/real_time_scheduling";


    $data['event']['event_id'] = $data['event_id'];
    $data['event']['summary'] = $data['summary'];
    $data['event']['tzid'] = $data['tzid'];
    $data['event']['start'] = $data['eventStart'];
    $data['event']['end'] = $data['eventEnd'];
    $data['event']['location']['description'] = $data['description'];
    $data['oauth']['redirect_uri'] = $data['redirect_uri'];
    $data['oauth']['scope'] = 'create_event';

    if(!empty($data['formattingHourFormat']))
    {
        $data['formatting']['hour_format'] = $data['formattingHourFormat'];

    }

    if(!empty($data['requiredDurationInMinutes']))
    {
        $data['required_duration']['minutes'] = $data['requiredDurationInMinutes'];
    }

    if(!empty($data['state']))
    {
        $data['oauth']['state'] = $data['state'];
    }


    if(!empty($data['formattingHourFormat']))
    {
        $data['formatting']['hour_format'] = $data['formattingHourFormat'];
    }

    if(!empty($data['reminders']))
    {
        $data['event']['reminders'] = $data['reminders'];
    }

    if(!empty($data['url']))
    {
        $data['event']['url'] = $data['url'];
    }

    if(!empty($data['transparency']))
    {
        $data['event']['transparency'] = $data['transparency'];
    }


    $requestParams = \Models\Params::createRequestBody($data, $bodyParams);
    $requestParams['headers'] = [];
     

    try {
        $resp = $client->post($query_str, $requestParams);
        $responseBody = $resp->getBody()->getContents();

        if(in_array($resp->getStatusCode(), ['200', '201', '202', '203', '204'])) {
            $result['callback'] = 'success';
            $result['contextWrites']['to'] = is_array($responseBody) ? $responseBody : json_decode($responseBody);
            if(empty($result['contextWrites']['to'])) {
                $result['contextWrites']['to']['status_msg'] = "Api return no results";
            }
        } else {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = 'API_ERROR';
            $result['contextWrites']['to']['status_msg'] = json_decode($responseBody);
        }

    } catch (\GuzzleHttp\Exception\ClientException $exception) {

        $responseBody = $exception->getResponse()->getBody()->getContents();
        if(empty(json_decode($responseBody))) {
            $out = $responseBody;
        } else {
            $out = json_decode($responseBody);
        }
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = $out;

    } catch (GuzzleHttp\Exception\ServerException $exception) {

        $responseBody = $exception->getResponse()->getBody()->getContents();
        if(empty(json_decode($responseBody))) {
            $out = $responseBody;
        } else {
            $out = json_decode($responseBody);
        }
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = $out;

    } catch (GuzzleHttp\Exception\ConnectException $exception) {
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'INTERNAL_PACKAGE_ERROR';
        $result['contextWrites']['to']['status_msg'] = 'Something went wrong inside the package.';

    }

    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);

});
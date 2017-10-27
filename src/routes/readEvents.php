<?php

$app->post('/api/Cronofy/readEvents', function ($request, $response) {

    $settings = $this->settings;
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['accessToken','tzid']);

    if(!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback']=='error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $post_data = $validateRes;
    }

    $requiredParams = ['accessToken'=>'accessToken','tzid'=>'tzid'];
    $optionalParams = ['from'=>'from','to'=>'to','includeManaged'=>'include_managed','includeDeleted'=>'include_deleted','includeMoved'=>'include_moved','lastModified'=>'last_modified','onlyManaged'=>'only_managed','includeGeo'=>'include_geo','calendarIds'=>'calendar_ids','localizedTimes'=>'localized_times'];
    $bodyParams = [
       'query' => ['from','to','tzid','include_deleted','include_moved','last_modified','include_managed','only_managed','include_geo','include_managed','calendar_ids','localized_times']
    ];

    $data = \Models\Params::createParams($requiredParams, $optionalParams, $post_data['args']);

    if(!empty($data['from']))
    {
        $data['from'] = \Models\Params::toFormat($data['from'], 'Y-m-d');
    }

    if(!empty($data['to']))
    {
        $data['to'] = \Models\Params::toFormat($data['to'], 'Y-m-d');

    }

    if(!empty($data['last_modified']))
    {
        $data['last_modified'] = \Models\Params::toFormat($data['last_modified'], 'Y-m-d\TH:i:s\Z');

    }

    $client = $this->httpClient;
    $query_str = "https://api.cronofy.com/v1/events?";

    if(!empty($data['calendar_ids']))
    {
        $ids = '';
        foreach($data['calendar_ids'] as $key => $value)
        {
            $ids .= 'calendar_ids[]='.$value.'&';
        }

        $data['calendar_ids'] = $ids;
    }

    foreach($data as $key => $value)
    {
        if($key == 'calendar_ids')
        {
            $query_str .= '&'.$value;
            continue;
        }

        $query_str .= '&'.$key.'='.$value;
    }


   // $requestParams = \Models\Params::createRequestBody($data, $bodyParams);
    $requestParams['headers'] = ["Authorization"=>"Bearer {$data['accessToken']}"];
     

    try {
        $resp = $client->get($query_str, $requestParams);
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
<?php

use GuzzleHttp\Client;

function main(array $args) : array
{
    // ensure we have our configuration parameter set
    if (!isset($args['SHEETS_URL'])) {
        error_log("ERROR: SHEETS_URL parameter not configured. Was the environment variable set?");
        return [
            'statusCode' => 500,
            'body' => [
                'message' => 'Internal Server Error',
            ]
        ];
    }

    // set the field names in the form
    $fieldNames = ['firstname', 'lastname', 'email'];

    // ensure we have some data
    try {
        $data = validateInput($args, $fieldNames);
    } catch (RuntimeException $e) {
        return [
            'statusCode' => 400,
            'body' => [
                'message' => $e->getMessage(),
            ]
        ];
    }

    // add the date created
    $data['date_created'] = date('Y-m-d H:i:s');

    // insert into the Google Sheet
    $client = new Client();
    $options = [
        'post' => $data,
    ];
    $response = $client->get($args['SHEETS_URL'], $options);

    return [
        "statusCode" => 201,
        "body" => [
            "result" => true,
            "data" => $data,
        ]
    ];
}

function validateInput(array $args, array $fieldNames) : array
{
    $data = [];
    $errors = [];
    foreach ($fieldNames as $fieldName) {
        if (!array_key_exists($fieldName, $args)) {
            $errors[] = "$fieldName missing";
            continue;
        }
        if (empty($args[$fieldName])) {
            $errors[] = "$fieldName empty";
            continue;
        }
        $data[$fieldName] = $args[$fieldName];
    }

    if (!empty($errors)) {
        error_log("Invalid data: " . implode(', ', $errors));
        throw new RuntimeException("Data invalid");
    }

    return $data;
}

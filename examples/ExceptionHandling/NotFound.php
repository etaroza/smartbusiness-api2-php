<?php
    declare(strict_types=1);

    require_once __DIR__ . '/../vendor/autoload.php';

    use smartbusiness\api2\Endpoints\Contacts\ContactsEndpoint;
    use LourensSystems\ApiWrapper\Exception\NotFoundException;

    $provider = require_once '../Provider.php';
    /** @var ContactsEndpoint $contacts */
    $contacts = new ContactsEndpoint($provider);

    try {
        $contacts->get(0);
    } catch (NotFoundException $e) {

        // handle situation when we can not find contact
        print_r($e->getMessage());
    }catch (Exception $e) {

        // handle situation when we can not find contact
        print_r($e->getMessage());
    }
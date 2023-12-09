<?php

namespace Tests\Unit;

use EncoreDigitalGroup\DynamicData\Helpers\DynamicData;
use Illuminate\Support\Collection;

test('resolveDynamicDataValuesAsArray() returns an array', function () {
    $DynamicData = new DynamicData;
    $DynamicData->setName('test');
    $DynamicData->setType('string');
    $DynamicData->setLabel('Test');
    $DynamicData->setValue('test');
    $DynamicData->setSourceName('test');
    $DynamicData->setSourceScope('test');
    $DynamicData->setExternal(true);
    $DynamicData->setRequired(true);
    $DynamicData->setIsEncrypted(false);
    $DynamicData->setShallEncrypt(false);
    $storedDynamicData = clone $DynamicData;
    $arrayData = $DynamicData->build();
    $storedDynamicData = $storedDynamicData->build();
    $Resolve = $DynamicData->resolveDynamicDataValuesAsArray($arrayData, $storedDynamicData);
    expect($Resolve)->toBeArray();
});

test('resolveDynamicDataValuesAsCollection() returns a collection', function () {
    $DynamicData = new DynamicData;
    $DynamicData->setName('test');
    $DynamicData->setType('string');
    $DynamicData->setLabel('Test');
    $DynamicData->setValue('test');
    $DynamicData->setSourceName('test');
    $DynamicData->setSourceScope('test');
    $DynamicData->setExternal(true);
    $DynamicData->setRequired(true);
    $DynamicData->setIsEncrypted(false);
    $DynamicData->setShallEncrypt(false);
    $storedDynamicData = clone $DynamicData;
    $arrayData = $DynamicData->build();
    $storedDynamicData = $storedDynamicData->build();
    $Resolve = $DynamicData->resolveDynamicDataValuesAsCollection($arrayData, $storedDynamicData);
    expect($Resolve)->toBeInstanceOf(Collection::class);
});

test('encodeDynamicDataValues() returns an array', function () {
    $DynamicData = new DynamicData;
    $DynamicData->setName('test');
    $DynamicData->setType('string');
    $DynamicData->setLabel('Test');
    $DynamicData->setValue('test');
    $DynamicData->setSourceName('test');
    $DynamicData->setSourceScope('test');
    $DynamicData->setExternal(true);
    $DynamicData->setRequired(true);
    $DynamicData->setIsEncrypted(false);
    $DynamicData->setShallEncrypt(false);
    $dataValuesToEncode = $DynamicData->build();
    $Resolve = $DynamicData->encodeDynamicDataValues([], $dataValuesToEncode);
    expect($Resolve)->toBeArray();
});

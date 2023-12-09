<?php

namespace Tests\Unit;

use EncoreDigitalGroup\DynamicData\Helpers\DynamicData;

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
    $DynamicData->setIsEncrypted(true);
    $DynamicData->setShallEncrypt(true);
    $storedDynamicData = clone $DynamicData;
    $arrayData = $DynamicData->build();
    //    dd($arrayData);
    $storedDynamicData = $DynamicData->build();
    //    dd($storedDynamicData);
    $Resolve = $DynamicData->resolveDynamicDataValuesAsArray($arrayData, $storedDynamicData);
    expect($Resolve)->toBeArray();

});

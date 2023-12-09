<?php

use EncoreDigitalGroup\DynamicData\Helpers\DynamicData;

test('Getter and Setter Test', function () {

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

    expect($DynamicData->getName())->toBe('test')
        ->and($DynamicData->getType())->toBe('string')
        ->and($DynamicData->getLabel())->toBe('Test')
        ->and($DynamicData->getValue())->toBe('test')
        ->and($DynamicData->getSourceName())->toBe('test')
        ->and($DynamicData->getSourceScope())->toBe('test')
        ->and($DynamicData->getExternal())->toBe(true)
        ->and($DynamicData->getRequired())->toBe(true)
        ->and($DynamicData->getIsEncrypted())->toBe(true)
        ->and($DynamicData->getShallEncrypt())->toBe(true);
});

test('rebuildForStorage() returns a string', function () {

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
    $DataValuesToEncode = clone $DynamicData;
    $DataValuesToEncode = $DataValuesToEncode->build();
    $String = $DynamicData->rebuildForStorage([], $DataValuesToEncode);

    expect($String)->toBeString();
});

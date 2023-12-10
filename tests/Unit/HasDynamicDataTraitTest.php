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

test('resolveDynamicDataValuesAsCollection() fails to decrypt', function () {
    $DynamicData = new DynamicData;
    $DynamicData->setName('test');
    $DynamicData->setType('string');
    $DynamicData->setLabel('Test');
    $DynamicData->setValue('test');
    $DynamicData->setSourceName('test');
    $DynamicData->setSourceScope('test');
    $DynamicData->setExternal(true);
    $DynamicData->setRequired(true);
    $DynamicData->setIsEncrypted();
    $DynamicData->setShallEncrypt(false);
    $storedDynamicData = clone $DynamicData;
    $arrayData = $DynamicData->build();
    $storedDynamicData = $storedDynamicData->build();
    expect(fn () => $DynamicData->resolveDynamicDataValuesAsCollection($arrayData, $storedDynamicData))->toThrow('Failed to Decrypt String');
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

    $dataToStore = [
        'test' => [
            'name' => 'test',
            'type' => 'string',
            'label' => 'Test',
            'value' => 'test',
            'source' => [
                'name' => 'test',
                'scope' => 'test',
            ],
            'external' => true,
            'required' => true,
            'encrypted' => [
                'is' => false,
                'shall' => true,
            ],
        ],
    ];

    $Resolve = $DynamicData->encodeDynamicDataValues($dataToStore, $dataValuesToEncode);
    expect($Resolve)->toBeArray();
});

test('encodeDynamicDataValues() fails to encrypt', function () {
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
    $DynamicData->setShallEncrypt();
    $dataValuesToEncode = $DynamicData->build();

    $dataToStore = [
        'test' => [
            'name' => 'test',
            'type' => 'string',
            'label' => 'Test',
            'value' => 'test',
            'source' => [
                'name' => 'test',
                'scope' => 'test',
            ],
            'external' => true,
            'required' => true,
            'encrypted' => [
                'is' => false,
                'shall' => true,
            ],
        ],
    ];
    config(['app.key' => []]);
    expect(fn () => $DynamicData->encodeDynamicDataValues($dataToStore, $dataValuesToEncode))->toThrow('Failed to Encrypt String');
});

test('encodeDynamicDataValues() returns value as null', function () {
    $DynamicData = new DynamicData;
    $dataToStore = [
        'test' => [
            'name' => 'test',
            'type' => 'string',
            'label' => 'Test',
            'value' => 'test',
            'source' => [
                'name' => 'test',
                'scope' => 'test',
            ],
            'external' => true,
            'required' => true,
            'encrypted' => [
                'is' => false,
                'shall' => true,
            ],
        ],
    ];

    $Resolve = $DynamicData->encodeDynamicDataValues($dataToStore, []);
    expect($Resolve['test']['value'])->toBeNull();
});

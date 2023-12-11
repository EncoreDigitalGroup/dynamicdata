<?php

namespace EncoreDigitalGroup\DynamicData\Traits;

use EncoreDigitalGroup\DynamicData\Helpers\DynamicData;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

trait HasDynamicData
{
    /**
     * @codeCoverageIgnore
     */
    public function prepareForResolution($sourceData): array
    {
        return json_decode($sourceData, true);
    }

    /**
     * @throws Exception
     */
    public function resolveDynamicDataValuesAsCollection(array $arrayData, array $storedDynamicData): Collection
    {
        return collect($this->resolveDynamicDataValuesAsArray($arrayData, $storedDynamicData));
    }

    /**
     * @throws Exception
     */
    public function resolveDynamicDataValuesAsArray(array $arrayData, array $storedDynamicData): array
    {
        foreach ($storedDynamicData as $data) {
            if ($data['encrypted']['is']) {
                try {
                    $arrayData["{$data['name']}"] = Crypt::decryptString("{$data['value']}");
                } catch (Exception $e) {
                    Log::error("Error decrypting value: {$e->getMessage()}");
                    throw new Exception('Failed to Decrypt String');
                }
            } else {
                $arrayData["{$data['name']}"] = $data['value'];
            }
        }

        // Return the modified data array
        return $arrayData;
    }

    /**
     * @throws Exception
     *
     * @codeCoverageIgnore
     */
    public function resolveDynamicDataValues(array $arrayData, array $storedDynamicData): array
    {
        return $this->resolveDynamicDataValuesAsArray($arrayData, $storedDynamicData);
    }

    /**
     * @throws Exception
     *
     * @codeCoverageIgnore
     */
    public function decodeDynamicDataValues(array $arrayData, array $storedDynamicData): array
    {
        return $this->resolveDynamicDataValuesAsArray($arrayData, $storedDynamicData);
    }

    /**
     * @throws Exception
     *
     * @codeCoverageIgnore
     */
    public function encodeDynamicDataValues(array $dataToStore, array $dataValuesToEncode): array
    {
        $returnArray = [];
        foreach ($dataToStore as $field => $fieldData) {
            // Only overwrite the 'value' field in the provided $data
            $DynamicData = new DynamicData;
            if (array_key_exists($field, $dataValuesToEncode)) {
                $DynamicData = $this->rebuild($DynamicData, $fieldData, $field, $dataValuesToEncode);
                if ($DynamicData->getShallEncrypt()) {
                    try {
                        $DynamicData->setValue(Crypt::encryptString($DynamicData->getValue()));
                        $DynamicData->setIsEncrypted();
                    } catch (Exception $e) {
                        Log::error("Error encrypting value: {$e->getMessage()}");
                        throw new Exception('Failed to Encrypt String');
                    }
                } else {
                    $DynamicData->setValue($DynamicData->getValue());
                }
            }
            $returnArray = array_merge($returnArray, $DynamicData->build());
        }

        return $returnArray;
    }

    private function rebuild($DynamicData, $fieldData, $field, $dataValuesToEncode)
    {
        $DynamicData->setName($fieldData['name']);
        $DynamicData->setType($fieldData['type']);
        $DynamicData->setLabel($fieldData['label']);
        $DynamicData->setValue($dataValuesToEncode[$field]);
        if (array_key_exists('source', $fieldData)) {
            $DynamicData->setSourceName($fieldData['source']['name']);
            $DynamicData->setSourceScope($fieldData['source']['scope']);
        }
        $DynamicData->setExternal($fieldData['external']);
        $DynamicData->setRequired($fieldData['required']);
        $DynamicData->setIsEncrypted($fieldData['encrypted']['is']);
        $DynamicData->setShallEncrypt($fieldData['encrypted']['shall']);

        return $DynamicData;
    }
}

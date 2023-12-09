<?php

namespace EncoreDigitalGroup\DynamicData\Traits;

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
        $preppedData = json_encode($sourceData);

        return json_decode($preppedData, true);
    }

    /**
     * @throws Exception
     */
    public function resolveDynamicDataValuesAsCollection(array $arrayData, mixed $storedDynamicData): Collection
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
                    throw new Exception($e->getMessage());
                }
            } else {
                $arrayData["{$data['name']}"] = $data['value'];
            }
        }

        // Return the modified data array
        return $arrayData;
    }

    public function encodeDynamicDataValues(mixed $dataToStore, array $dataValuesToEncode): array
    {
        if (isset($dataToStore)) {
            foreach ($dataToStore as $field => $fieldData) {
                // Only overwrite the 'value' field in the provided $data
                if (isset($dataValuesToEncode[$field])) {
                    if ($fieldData['encrypted']['shall'] === true) {
                        try {
                            $dataToStore[$field]['value'] = Crypt::encryptString($dataValuesToEncode[$field]);
                            $dataToStore[$field]['encrypted']['is'] = true;
                        } catch (Exception $e) {
                            Log::error("Error encrypting value: {$e->getMessage()}");
                        }
                    }
                } else {
                    $dataToStore[$field]['value'] = null;
                }
            }
        }

        return $dataToStore;
    }
}

<?php

namespace EncoreDigitalGroup\DynamicData\Traits;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

trait HasDynamicData
{
    /**
     * @throws Exception
     */
    private static function ensureNameAndValuePresent($data)
    {
        if (! isset($data->name)) {
            throw new Exception('Missing name property in data object');
        }

        if (! isset($data->value) && ($data->value != null)) {
            throw new Exception('Missing value property in data object');
        }
    }

    public function prepareForResolution($sourceData): array
    {
        $preppedData = json_encode($sourceData);

        return json_decode($preppedData, true);
    }

    /**
     * @throws Exception
     */
    public function resolveDynamicDataValuesAsCollection(array $sourceData, mixed $dataToProcess): Collection
    {
        return collect($this->resolveDynamicDataValuesAsArray($sourceData, $dataToProcess));
    }

    /**
     * @throws Exception
     */
    public function resolveDynamicDataValuesAsArray(array $sourceData, mixed $dataToProcess): array
    {
        if (isset($dataToProcess)) {
            foreach ($dataToProcess as $data) {
                self::ensureNameAndValuePresent($data);
                if ($data->encrypted->is) {
                    try {
                        $sourceData["{$data->name}"] = Crypt::decryptString("{$data->value}");
                    } catch (Exception $e) {
                        throw new Exception($e->getMessage());
                    }
                } else {
                    $sourceData["{$data->name}"] = $data->value;
                }
            }
        }

        // Return the modified data array
        return $sourceData;
    }

    public function encodeDynamicDataValues(mixed $sourceData, array $dataToProcess): array
    {
        if (isset($sourceData)) {
            foreach ($sourceData as $field => $fieldData) {
                // Only overwrite the 'value' field in the provided $data
                if (isset($dataToProcess[$field])) {
                    if ($sourceData[$field]['encrypted']['shall'] === true) {
                        try {
                            $sourceData[$field]['value'] = Crypt::encryptString($dataToProcess[$field]);
                            $sourceData[$field]['encrypted']['is'] = true;
                        } catch (Exception $e) {
                            Log::error("Error encrypting value: {$e->getMessage()}");
                        }
                    } else {
                        $sourceData[$field]['value'] = $dataToProcess[$field] ?? null;
                    }
                } else {
                    $sourceData[$field]['value'] = null;
                }
            }
        }

        return $sourceData;
    }
}

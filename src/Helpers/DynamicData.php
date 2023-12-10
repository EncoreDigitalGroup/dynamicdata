<?php

namespace EncoreDigitalGroup\DynamicData\Helpers;

use EncoreDigitalGroup\DynamicData\Traits\HasDynamicData;
use stdClass;

class DynamicData
{
    use HasDynamicData;

    protected string $name;
    protected mixed $type;
    protected string $label;
    protected mixed $value;
    protected array $source = [
        'name' => null,
        'scope' => null,
    ];
    protected bool $external = true;
    protected bool $required = false;
    protected array $encrypted = [
        'is' => false,
        'shall' => false,
    ];

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name ?? null;
    }

    public function setType(mixed $type = null): void
    {
        $this->type = $type;
    }

    public function getType(): mixed
    {
        return $this->type ?? null;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function getLabel(): ?string
    {
        return $this->label ?? null;
    }

    public function setValue(mixed $value = null): void
    {
        $this->value = $value;
    }

    public function getValue(): mixed
    {
        return $this->value ?? null;
    }

    public function setSourceName(string $name = null): void
    {
        $this->source['name'] = $name;
    }

    public function getSourceName(): ?string
    {
        return $this->source['name'] ?? null;
    }

    public function setSourceScope(string $scope = null): void
    {
        $this->source['scope'] = $scope;
    }

    public function getSourceScope(): ?string
    {
        return $this->source['scope'] ?? null;
    }

    public function setExternal(bool $external = true): void
    {
        $this->external = $external;
    }

    public function getExternal(): bool
    {
        return $this->external;
    }

    public function setRequired(bool $required = true): void
    {
        $this->required = $required;
    }

    public function getRequired(): bool
    {
        return $this->required;
    }

    public function setIsEncrypted(bool $encrypted = true): void
    {
        $this->encrypted['is'] = $encrypted;
    }

    public function getIsEncrypted(): bool
    {
        return $this->encrypted['is'];
    }

    public function setShallEncrypt(bool $encrypt = true): void
    {
        $this->encrypted['shall'] = $encrypt;
    }

    public function getShallEncrypt(): bool
    {
        return $this->encrypted['shall'];
    }

    public function buildAsArray(): array
    {
        return [
            $this->getName() => [
                'name' => $this->getName(),
                'type' => $this->getType(),
                'label' => $this->getLabel(),
                'value' => $this->getValue(),
                'source' => [
                    'name' => $this->getSourceName(),
                    'scope' => $this->getSourceScope(),
                ],
                'external' => $this->getExternal(),
                'required' => $this->getRequired(),
                'encrypted' => [
                    'is' => $this->getIsEncrypted(),
                    'shall' => $this->getShallEncrypt(),
                ],
            ],
        ];
    }

    public function buildAsObject(): object
    {
        $Object = new stdClass;
        $Object->name = $this->getName();
        $Object->type = $this->getType();
        $Object->label = $this->getLabel();
        $Object->value = $this->getValue();
        $Object->source = [
            'name' => $this->getSourceName(),
            'scope' => $this->getSourceScope(),
        ];
        $Object->external = $this->getExternal();
        $Object->required = $this->getRequired();
        $Object->encrypted = [
            'is' => $this->getIsEncrypted(),
            'shall' => $this->getShallEncrypt(),
        ];

        return $Object;
    }

    public function buildAsJson(): string
    {
        return json_encode($this->buildAsArray());
    }

    public function build(): array
    {
        return $this->buildAsArray();
    }

    public function rebuildForStorage(array $dataToStore, array $dataValuesToEncode): string
    {
        return json_encode($this->encodeDynamicDataValues($dataToStore, $dataValuesToEncode));
    }
}

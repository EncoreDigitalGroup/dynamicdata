<?php

namespace EncoreDigitalGroup\DynamicData\Helpers;

use EncoreDigitalGroup\DynamicData\Traits\HasDynamicData;
use Illuminate\Support\Collection;

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

    public function getName(): string
    {
        return $this->name;
    }

    public function setType(mixed $type): void
    {
        $this->type = $type;
    }

    public function getType(): mixed
    {
        return $this->type;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setSourceName(string $name): void
    {
        $this->source['name'] = $name;
    }

    public function getSourceName(): string
    {
        return $this->source['name'];
    }

    public function setSourceScope(string $scope): void
    {
        $this->source['scope'] = $scope;
    }

    public function getSourceScope(): string
    {
        return $this->source['scope'];
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
        ];
    }

    public function buildAsObject(): object
    {
        return (object) $this->buildAsArray();
    }

    public function buildAsJson(): string
    {
        return json_encode($this->buildAsArray());
    }

    public function buildAsCollection(): Collection
    {
        return collect($this->buildAsArray());
    }

    public function build(): Collection
    {
        return $this->buildAsCollection();
    }
}

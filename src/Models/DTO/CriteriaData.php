<?php

declare(strict_types=1);

namespace PaymentReport\Models\DTO;

class CriteriaData
{
    public const REGION = 'regions';
    public const DISTRICT = 'districts';
    public const VENDOR = 'vendors';
    public const SERVICE_CATEGORY = 'service_categories';
    public const PAYPOINT = 'paypoints';
    public const PAYMENT_METHOD = 'payment_methods';

    public function __construct(
        private readonly ?array $regions,
        private readonly ?array $districts,
        private readonly ?array $vendors,
        private readonly ?array $serviceCategories,
        private readonly ?array $paypoints,
        private readonly ?array $paymentMethods,
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            $data[self::REGION],
            $data[self::DISTRICT],
            $data[self::VENDOR],
            $data[self::SERVICE_CATEGORY],
            $data[self::PAYPOINT],
            $data[self::PAYMENT_METHOD]
        );
    }

    public function toArray(): array
    {
        return [
            self::REGION => $this->regions,
            self::DISTRICT => $this->districts,
            self::VENDOR => $this->vendors,
            self::SERVICE_CATEGORY => $this->serviceCategories,
            self::PAYPOINT => $this->paypoints,
            self::PAYMENT_METHOD => $this->paymentMethods,
        ];
    }

    public function getRegions(): ?array
    {
        return $this->regions;
    }

    public function getDistricts(): ?array
    {
        return $this->districts;
    }

    public function getVendors(): ?array
    {
        return $this->vendors;
    }

    public function getServiceCategories(): ?array
    {
        return $this->serviceCategories;
    }

    public function getPaypoints(): ?array
    {
        return $this->paypoints;
    }

    public function getPaymentMethods(): ?array
    {
        return $this->paymentMethods;
    }
}

<?php

namespace App\Service\CalculatorService;

use App\Dto\StayDataTransferObject;
use DateTimeImmutable;

final class CalculatorService {

    public function calculate(DateTimeImmutable $entry, DateTimeImmutable $exit) : StayDataTransferObject
    {
         return new StayDataTransferObject($entry, $exit);
    }

}
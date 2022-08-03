<?php

namespace App\Dto;

use App\ValueObject\Stay;
use Carbon\Carbon;
use DateTimeImmutable;

class StayDataTransferObject
{
    private Carbon $entry;
    private Carbon $exit;

    /**
     * @param DateTimeImmutable $entry
     * @param DateTimeImmutable $exit
     */
    public function __construct(DateTimeImmutable $entry, DateTimeImmutable $exit)
    {
        $this->entry = Carbon::create($entry);
        $this->exit = Carbon::create($exit);
    }

    /**
     * @return Carbon|false
     */
    public function getEntry(): bool|Carbon
    {
        return $this->entry;
    }

    /**
     * @param Carbon|false $entry
     */
    public function setEntry(bool|Carbon $entry): void
    {
        $this->entry = $entry;
    }

    /**
     * @return Carbon|false
     */
    public function getExit(): bool|Carbon
    {
        return $this->exit;
    }

    /**
     * @param Carbon|false $exit
     */
    public function setExit(bool|Carbon $exit): void
    {
        $this->exit = $exit;
    }

    public function getDurationInDays(): int
    {
        return $this->entry->diffInDays($this->exit);
    }

    public function getNinetyDaysBeforeEntry(): DateTimeImmutable
    {
        return $this->entry->toImmutable()->subDays(Stay::NINETY_DAYS);
    }

    public function getNinetyDaysAfterEntry(): DateTimeImmutable
    {
        return $this->entry->toImmutable()->addDays(Stay::NINETY_DAYS);
    }

    public function getIsDurationOverNinetyDays(): bool
    {
        return $this->getDurationInDays() > Stay::NINETY_DAYS;
    }

    public function getOverStayInDays(): int
    {
        return $this->getIsDurationOverNinetyDays() ? $this->entry->diffInDays($this->exit) - Stay::NINETY_DAYS : 0;
    }

    public function getNinetyDaysAfterExit(): DateTimeImmutable
    {
        return $this->exit->toImmutable()->addDays(Stay::NINETY_DAYS);
    }


    public function getNextNinteyDayEntry() : DateTimeImmutable
    {
        return $this->entry->toImmutable()->addDays(Stay::ONE_HUNDRED_AND_EIGHTY_DAYS);
    }

    public function getDaysRemainingFromNinetyDays(): int
    {
        if ($this->getIsDurationOverNinetyDays()) {
            return 0;
        }
        return Stay::NINETY_DAYS - $this->getDurationInDays();
    }

    public function getMinusStayDuration(): DateTimeImmutable
    {
        return $this->exit->toImmutable()->addDays($this->getDaysRemainingFromNinetyDays());
    }

}
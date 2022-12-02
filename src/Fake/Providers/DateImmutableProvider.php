<?php

namespace App\Fake\Providers;

use DateTime;
use DateTimeImmutable;
use Faker\Provider\Base as BaseProvider;

final class DateImmutableProvider extends BaseProvider
{
    public function dateImmutable(DateTime $dateTime)
    {
        return DateTimeImmutable::createFromMutable($dateTime);
    }
}

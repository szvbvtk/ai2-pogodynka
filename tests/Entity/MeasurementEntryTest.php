<?php

namespace App\Tests\Entity;

use App\Entity\MeasurementEntry;
use PHPUnit\Framework\TestCase;

class MeasurementEntryTest extends TestCase
{
    public function dataGetFahrenheit(): array
    {
        return [
            ['0', 32],
            ['-100', -148],
            ['100', 212],
            ['37', 98.6],
            ['100.4', 212.72],
            ['98.6', 209.48],
            ['5', 41],
            ['0.1', 32.18],
            ['-0.1', 31.82],
            ['-5', 23],
        ];
    }

    /**
     * @dataProvider dataGetFahrenheit
     */
    public function testGetFahrenheit($celsius, $expectedFahrenheit): void
    {
        $measurement = new MeasurementEntry();

        $measurement->setTemperatureCelcius($celsius);
        $this->assertEquals($expectedFahrenheit, $measurement->getFahrenheit());
    }
}

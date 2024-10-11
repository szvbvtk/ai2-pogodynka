<?php

namespace App\Tests\Entity;

use App\Entity\MeasurementEntry;
use PHPUnit\Framework\TestCase;

class MeasurementEntryTest extends TestCase
{
    public function testGetFahrenheit(): void
    {
        $measurement = new MeasurementEntry();
        
        // Test 1: celcius = 0, fahrenheit = 32
        $measurement->setTemperatureCelcius(0);
        $this->assertEquals(32, $measurement->getFahrenheit());

        // Test 2: celcius = -100, fahrenheit = -148
        $measurement->setTemperatureCelcius(-100);
        $this->assertEquals(-148, $measurement->getFahrenheit());

        // Test 3: celcius = 100, fahrenheit = 212
        $measurement->setTemperatureCelcius(100);
        $this->assertEquals(212, $measurement->getFahrenheit());
    }
}

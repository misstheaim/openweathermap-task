<?php

namespace Tests\Unit;

use App\Services\OWPRecieverService;
use DateTime;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

class OWPRecieverServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_getTime_function(): void
    {
        $method = new ReflectionMethod(OWPRecieverService::class, 'getTime');

        if ($method->isPrivate()) {
            $method->setAccessible(true);
        }
        $exampleRequest = array(
                'dt' => rand(1526660758, 1726600000),
                'timezone' => rand(-30000, 30000)
        );

        $date = $method->invoke(new OWPRecieverService(), $exampleRequest);

        $this->assertInstanceOf(DateTime::class, $date);
    }
}

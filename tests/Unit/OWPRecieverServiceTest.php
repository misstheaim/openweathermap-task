<?php

namespace Tests\Unit;

use App\Models\Weather;
use App\Services\OWPReciever_v2Service;
use DateTime;
use DateTimeZone;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use ReflectionMethod;
use TypeError;

class OWPRecieverServiceTest extends TestCase
{
    use RefreshDatabase;
    public function getMethod(string $className, string $methodName) 
    {
        $method = new ReflectionMethod($className, $methodName);

        if ($method->isPrivate()) {
            $method->setAccessible(true);
        }
        return $method;
    }


    public function test_if_getTime_function_returns_correct_value(): void
    {
        $date = '2024-09-20 17:00:00';
        $expected = DateTime::createFromFormat('Y-m-d H:i:s', $date)->setTimezone(new DateTimeZone("Asia/Tashkent"));
        $input = array(
                'dt' => strtotime($date),
                'timezone' => 18000
        );

        $response = $this->getMethod(OWPReciever_v2Service::class, 'getTime')->invoke(new OWPReciever_v2Service(), $input);


        $this->assertInstanceOf(DateTime::class, $response);
        $this->assertEquals($expected, $response);
    }

    
    public function test_if_getTime_function_throw_an_error_with_invalid_input() : void
    {
        $input = array(
            'dt' => 'InvalidInput',
            'timezone' => 'InvalidInput'
        );

        $this->expectException(TypeError::class);

        $response = $this->getMethod(OWPReciever_v2Service::class, 'getTime')
            ->invoke(new OWPReciever_v2Service(), $input);
    }


    public function test_createData_function_save_data_with_correct_value()
    {
        $invalidCityName = 'This city is with very very unique name';

        $this->getMethod(OWPReciever_v2Service::class, 'createData')
            ->invoke(new OWPReciever_v2Service(), $invalidCityName, $this->preparedData, now());
        
        $this->assertTrue(Weather::where('city', $invalidCityName)->exists());
    }


    public function test_createData_function_throw_error_with_invalid_value()
    {
        $invalidCityName = null;

        $this->expectException(QueryException::class);

        $this->getMethod(OWPReciever_v2Service::class, 'createData')
            ->invoke(new OWPReciever_v2Service(), $invalidCityName, $this->preparedData, now());
    }


    protected $preparedData = array(
        'weather' => [
            [
                'main' => "Rainy"
            ]
        ],
        'coord' => [
            'lat' => 11,
            'lon' => 12
        ],
        'main' => [
            'temp' => 45,
            'temp_min' => 45,
            'temp_max' => 45,
            'pressure' => 16,
            'humidity' => 61
        ]
    );
}

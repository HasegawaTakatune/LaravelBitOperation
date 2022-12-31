<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Log;

use App\Services\BitOperationService;
use App\Consts\BitOperation;

// Mac: php artisan test Test/Unit/BitOperationTest.php
// win: php artisan test Tests\Unit\BitOperationTest.php
class BitOperationTest extends TestCase
{
    public function test_position_on()
    {
        $base = '10101010';
        $position = null;

        $position = '00000100';
        $result = BitOperationService::pointSwitch($base, $position, BitOperation::ON);
        info('position on 1     ', ['base' => $base, 'position' => $position, 'result' => $result, 'expected_value' => '10101110' ]);
        $this->assertEquals('10101110', $result);

        $position = '01000000';
        $result = BitOperationService::pointSwitch($base, $position, BitOperation::ON);
        info('position on 2     ', ['base' => $base, 'position' => $position, 'result' => $result, 'expected_value' => '11101010' ]);
        $this->assertEquals('11101010', $result);
    }

    public function test_potision_off()
    {
        $base = '10101010';
        $position = null;

        $position = '00000010';
        $result = BitOperationService::pointSwitch($base, $position, BitOperation::OFF);
        info('position off 1    ', ['base' => $base, 'position' => $position, 'result' => $result, 'expected_value' => '10101000' ]);
        $this->assertEquals('10101000', $result);

        $position = '00100000';
        $result = BitOperationService::pointSwitch($base, $position, BitOperation::OFF);
        info('position off 2    ', ['base' => $base, 'position' => $position, 'result' => $result, 'expected_value' => '10001010' ]);
        $this->assertEquals('10001010', $result);
    }

    public function test_all_on()
    {
        $base = '10101010';

        $result = BitOperationService::allOn($base);
        info('all on            ', ['base' => $base, 'result' => $result, 'expected_value' => '11111111' ]);
        $this->assertEquals('11111111', $result);
    }

    public function test_all_off()
    {
        $base = '10101010';

        $result = BitOperationService::allOff($base);
        info('all off           ', ['base' => $base, 'result' => $result, 'expected_value' => '00000000' ]);
        $this->assertEquals('00000000', $result);
    }

    public function test_multi_on()
    {
        $base = '10101010';
        $position = null;

        $position = ['00000100', '00000001'];
        $result = BitOperationService::multiSwitch($base, $position, BitOperation::ON);
        info('multi on 1        ', ['base' => $base, 'position' => $position, 'result' => $result, 'expected_value' => '10101111' ]);
        $this->assertEquals('10101111', $result);

        $position = ['01000000', '00010000', '00000010', '00000001'];
        $result = BitOperationService::multiSwitch($base, $position, BitOperation::ON);
        info('multi on 2        ', ['base' => $base, 'position' => $position, 'result' => $result, 'expected_value' => '11111011' ]);
        $this->assertEquals('11111011', $result);
    }

    public function test_multi_off()
    {
        $base = '10101010';
        $position = null;

        $position = ['00001000', '00000010'];
        $result = BitOperationService::multiSwitch($base, $position, BitOperation::OFF);
        info('multi off 1       ', ['base' => $base, 'position' => $position, 'result' => $result, 'expected_value' => '10100000' ]);
        $this->assertEquals('10100000', $result);

        $position = ['10000000', '00100000', '00000010', '00000001'];
        $result = BitOperationService::multiSwitch($base, $position, BitOperation::OFF);
        info('multi off 2       ', ['base' => $base, 'position' => $position, 'result' => $result, 'expected_value' => '00001000' ]);
        $this->assertEquals('00001000', $result);
    }

    public function test_error()
    {
        // Point switch
        $result = BitOperationService::pointSwitch('99999999', '00000010', BitOperation::ON);
        $this->assertNull($result);

        $result = BitOperationService::pointSwitch('-1', '00000010', BitOperation::ON);
        $this->assertNull($result);

        $result = BitOperationService::pointSwitch('abc', '00000010', BitOperation::ON);
        $this->assertNull($result);

        $result = BitOperationService::pointSwitch('あいうえお', '00000010', BitOperation::ON);
        $this->assertNull($result);

        $result = BitOperationService::pointSwitch('', '00000010', BitOperation::ON);
        $this->assertNull($result);

        $result = BitOperationService::pointSwitch('00000010', '99999999', BitOperation::ON);
        $this->assertNull($result);

        $result = BitOperationService::pointSwitch('00000010', '-1', BitOperation::ON);
        $this->assertNull($result);

        $result = BitOperationService::pointSwitch('00000010', 'abc', BitOperation::ON);
        $this->assertNull($result);

        $result = BitOperationService::pointSwitch('00000010', 'あいうえお', BitOperation::ON);
        $this->assertNull($result);

        $result = BitOperationService::pointSwitch('00000010', '', BitOperation::ON);
        $this->assertNull($result);

        $result = BitOperationService::pointSwitch('', '', 99999);
        $this->assertNull($result);

        $result = BitOperationService::pointSwitch('', '', -1);
        $this->assertNull($result);

        // All on
        $result = BitOperationService::allOn('99999999');
        $this->assertNull($result);

        $result = BitOperationService::allOn('-1');
        $this->assertNull($result);

        $result = BitOperationService::allOn('abc');
        $this->assertNull($result);

        $result = BitOperationService::allOn('あいうえお');
        $this->assertNull($result);

        $result = BitOperationService::allOn('');
        $this->assertNull($result);

        // All off
        $result = BitOperationService::allOff('99999999');
        $this->assertNull($result);

        $result = BitOperationService::allOff('-1');
        $this->assertNull($result);

        $result = BitOperationService::allOff('abc');
        $this->assertNull($result);

        $result = BitOperationService::allOff('あいうえお');
        $this->assertNull($result);

        $result = BitOperationService::allOff('');
        $this->assertNull($result);

        // Multi switch
        $result = BitOperationService::multiSwitch('99999999', ['00000100', '00000001'], BitOperation::ON);
        $this->assertNull($result);

        $result = BitOperationService::multiSwitch('-1', ['00000100', '00000001'], BitOperation::ON);
        $this->assertNull($result);

        $result = BitOperationService::multiSwitch('abc', ['00000100', '00000001'], BitOperation::ON);
        $this->assertNull($result);

        $result = BitOperationService::multiSwitch('あいうえお', ['00000100', '00000001'], BitOperation::ON);
        $this->assertNull($result);

        $result = BitOperationService::multiSwitch('', ['00000100', '00000001'], BitOperation::ON);
        $this->assertNull($result);

        $result = BitOperationService::multiSwitch('10101010', ['99999999', '00000001'], BitOperation::ON);
        $this->assertNull($result);

        $result = BitOperationService::multiSwitch('10101010', ['-1', '00000001'], BitOperation::ON);
        $this->assertNull($result);

        $result = BitOperationService::multiSwitch('10101010', ['abc', '00000001'], BitOperation::ON);
        $this->assertNull($result);

        $result = BitOperationService::multiSwitch('10101010', ['あいうえお', '00000001'], BitOperation::ON);
        $this->assertNull($result);

        $result = BitOperationService::multiSwitch('10101010', ['', '00000001'], BitOperation::ON);
        $this->assertNull($result);

        $result = BitOperationService::multiSwitch('10101010', [], BitOperation::ON);
        $this->assertNull($result);

        $result = BitOperationService::multiSwitch('10101010', ['00000100', '00000001'], 99999);
        $this->assertNull($result);

        $result = BitOperationService::multiSwitch('10101010', ['00000100', '00000001'], -1);
        $this->assertNull($result);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 07:45
 */

namespace Tests;

use App\AuthenticationService;
use App\IProfile;
use App\IToken;
use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery as m;

class AuthenticationServiceTest extends TestCase
{
    /** @test */
    public function is_valid()
    {
        /**
         * Arrange
         */
        $stubProfile = m::mock(IProfile::class);
        $stubProfile->shouldReceive('getPassword')->with('joey')->andReturn('91');
        $stubToken = m::mock(IToken::class);
        $stubToken->shouldReceive('getRandom')->andReturn('000000');

        /**
         * Act
         */
        $target = new AuthenticationService($stubProfile, $stubToken);
        $actual = $target->isValid('joey', '91000000');

        /**
         * Assert
         */
        $this->assertTrue($actual);
    }

}


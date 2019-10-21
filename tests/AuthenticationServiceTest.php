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
    private $profile;
    private $token;
    private $target;

    protected function setUp()
    {
        parent::setUp();
        $this->profile = m::mock(IProfile::class);
        $this->token = m::mock(IToken::class);
        $this->target = new AuthenticationService($this->profile, $this->token);
    }

    /** @test */
    public function is_valid()
    {
        $this->givenPassword('joey', '91');
        $this->givenToken('000000');
        $this->shouldBeValid('joey', '91000000');
    }

    /** @test */
    public function is_invalid()
    {
        $this->givenPassword('joey', '91');
        $this->givenToken('000000');
        $this->shouldBeInvalid('joey', 'wrong password');
    }

    protected function givenPassword($account, $password): void
    {
        $this->profile->shouldReceive('getPassword')->with($account)->andReturn($password);
    }

    protected function givenToken($token): void
    {
        $this->token->shouldReceive('getRandom')->andReturn($token);
    }

    protected function shouldBeValid($account, $password): void
    {
        /**
         * Act
         */
        $actual = $this->target->isValid($account, $password);

        /**
         * Assert
         */
        $this->assertTrue($actual);
    }

    protected function shouldBeInvalid($account, $password): void
    {
        /**
         * Act
         */
        $actual = $this->target->isValid($account, $password);

        /**
         * Assert
         */
        $this->assertFalse($actual);
    }


}


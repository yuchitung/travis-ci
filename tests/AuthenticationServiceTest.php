<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 07:45
 */

namespace Tests;

use App\AuthenticationService;
use App\ILogger;
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
    private $mockLogger;

    protected function setUp()
    {
        parent::setUp();
        $this->profile = m::mock(IProfile::class);
        $this->token = m::mock(IToken::class);
        $this->mockLogger = m::mock(ILogger::class);
        $this->target = new AuthenticationService($this->profile, $this->token, $this->mockLogger);
    }

    /** @test */
    public function is_valid()
    {
        $this->givenPassword('joey', '91');
        $this->givenToken('000000');
        $this->shouldBeValid('joey', '91000000');
    }

    /** @test */
    public function should_log_account_when_invalid()
    {
        $this->givenPassword('joey', '91');
        $this->givenToken('000000');

        $this->mockLogger->shouldReceive('save')->with(m::on(function ($message) {
            return strpos($message, 'joey') !== false;
        }))->once();

        $this->target->isValid('joey', 'wrong password');
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
        $actual = $this->target->isValid($account, $password);
        $this->assertTrue($actual);
    }

}


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
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery as m;


class AuthenticationServiceTest extends TestCase
{
    private $profile;
    private $token;
    private $target;
    private $mockLogger;

    use MockeryPHPUnitIntegration;

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
        /**
         * Mock
         * act 之前先定義合法操作
         * 如果有`任何`跟定義不同的情況就會噴錯
         */
        $this->loggerShouldLogAccount('joey');
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

    protected function loggerShouldLogAccount($account): void
    {
        $this->mockLogger->shouldReceive('save')->with(m::on(function ($message) use ($account) {
            return strpos($message, $account) !== false;
        }))->once();
    }

}


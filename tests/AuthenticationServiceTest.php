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
    private $stubProfile;
    private $stubToken;
    private $target;
    private $spyLogger;

    use MockeryPHPUnitIntegration;

    protected function setUp()
    {
        parent::setUp();
        $this->stubProfile = m::mock(IProfile::class);
        $this->stubToken = m::mock(IToken::class);
        $this->spyLogger = m::spy(ILogger::class);
        $this->target = new AuthenticationService($this->stubProfile, $this->stubToken, $this->spyLogger);
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
        $this->whenInvalid();

        /**
         * Spy
         * 後置驗證，接近 3A 原則，做完才驗證
         * 只驗證在乎的事情，其他沒驗的東西無所謂
         * 測試比較沒那麼敏感，必較不容易壞
         */
        $this->loggerShouldLogAccount('joey');
    }

    protected function givenPassword($account, $password): void
    {
        $this->stubProfile->shouldReceive('getPassword')->with($account)->andReturn($password);
    }

    protected function givenToken($token): void
    {
        $this->stubToken->shouldReceive('getRandom')->andReturn($token);
    }

    protected function shouldBeValid($account, $password): void
    {
        $actual = $this->target->isValid($account, $password);
        $this->assertTrue($actual);
    }

    protected function loggerShouldLogAccount($account): void
    {
        $this->spyLogger->shouldHaveReceived('save')->with(m::on(function ($message) use ($account) {
            return strpos($message, $account) !== false;
        }))->once();
    }

    protected function whenInvalid(): void
    {
        $this->givenPassword('joey', '91');
        $this->givenToken('000000');
        $this->target->isValid('joey', 'wrong password');
    }

}


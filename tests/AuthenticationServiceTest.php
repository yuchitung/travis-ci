<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 07:45
 */

namespace Tests {

    use App\AuthenticationService;
    use App\ILogger;
    use App\IProfile;
    use App\IToken;
    use const false;
    use Mockery\MockInterface;
    use PHPUnit\Framework\TestCase;

    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
    use Mockery as m;
    use function strpos;

    class AuthenticationServiceTest extends TestCase
    {
        /**
         * @var MockInterface
         */
        private $stubProfile;
        /**
         * @var MockInterface
         */
        private $stubToken;
        /**
         * @var AuthenticationService
         */
        private $target;
        /**
         * @var MockInterface
         */
        private $spyLogger;
        use MockeryPHPUnitIntegration;

        protected function setUp()
        {
            $this->stubProfile = m::mock(IProfile::class);
            $this->stubToken = m::mock(IToken::class);

//            $this->mockLogger = m::mock(ILogger::class);
            $this->spyLogger = m::spy(ILogger::class);
            $this->target = new AuthenticationService($this->stubProfile, $this->stubToken, $this->spyLogger);
        }

        public function test_is_valid()
        {
            $this->givenProfile('joey', '91');
            $this->givenToken('000000');

            $this->shouldBeValid('joey', '91000000');
        }

        public function test_log_account_when_invalid()
        {
            $this->whenInvalid();

            $this->loggerShouldLogAccount('joey');
        }

        public function test_should_not_log_account_when_valid()
        {
            $this->whenValid();

            $this->loggerShouldNotLog();
        }

        private function givenProfile($account, $password)
        {
            $this->stubProfile->shouldReceive('getPassword')->with($account)->andReturn($password);
        }

        private function givenToken($token)
        {
            $this->stubToken->shouldReceive('getRandom')->andReturn($token);
        }

        private function shouldBeValid($account, $password)
        {
            $this->assertTrue($this->target->isValid($account, $password));
        }

        private function loggerShouldLogAccount($account)
        {
//            $this->spyLogger->shouldReceive('save')->with(m::on(function ($message) use ($account) {
            $this->spyLogger->shouldHaveReceived('save')->with(m::on(function ($message) use ($account) {
                return strpos($message, $account) !== false;
            }))->once();
        }

        /**
         * @return bool
         */
        private function whenValid()
        {
            $this->givenProfile('joey', '91');
            $this->givenToken('000000');

            return $this->target->isValid('joey', '91000000');
        }

        private function loggerShouldNotLog()
        {
            $this->spyLogger->shouldNotHaveReceived('save');
        }

        private function whenInvalid()
        {
            $this->givenProfile('joey', '91');
            $this->givenToken('000000');

            $this->target->isValid('joey', 'wrong password');
        }
    }
}

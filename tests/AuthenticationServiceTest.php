<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 07:45
 */

namespace Tests {

    use App\AuthenticationService;
    use App\IProfile;
    use App\IToken;
    use Mockery\MockInterface;
    use PHPUnit\Framework\TestCase;

    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
    use Mockery as m;

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

        protected function setUp()
        {
            $this->stubProfile = m::mock(IProfile::class);
            $this->stubToken = m::mock(IToken::class);
            $this->target = new AuthenticationService($this->stubProfile, $this->stubToken);
        }

        /** @test */
        public function is_valid_test()
        {
            $this->givenProfile('joey', '91');
            $this->givenToken('000000');

            $this->shouldBeValid('joey', '91000000');
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
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 07:45
 */

namespace Tests {

    use App\AuthenticationService;
    use App\FakeProfile;
    use App\FakeToken;
    use PHPUnit\Framework\TestCase;

    class AuthenticationServiceTest extends TestCase
    {
        /** @test */
        public function is_valid_test()
        {
//            $target = new AuthenticationService();
            $target = new AuthenticationService(new FakeProfile(), new FakeToken());
            $actual = $target->isValid('joey', '91000000');
            //always failed
            $this->assertTrue($actual);
        }
    }
}

namespace App {
    class FakeProfile implements IProfile
    {
        public function getPassword($account)
        {
            if ($account == 'joey') {
                return '91';
            }

            return '';
        }
    }

    class FakeToken implements IToken
    {
        public function getRandom($account)
        {
            return '000000';
        }
    }
}

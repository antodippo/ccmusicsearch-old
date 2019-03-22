<?php

namespace App\Tests\Twig;

use App\Twig\LicenseButtonExtension;
use PHPUnit\Framework\TestCase;

class LicenseButtonExtensionTest extends TestCase
{
    /**
     * @dataProvider licenseButtonUrlProvider
     */
    public function testItGetsLicenseButtonUrl($license, $buttonUrl)
    {
        $logger = \Phake::mock('Symfony\Bridge\Monolog\Logger');
        \Phake::when($logger)->error(\Phake::anyParameters())->thenReturn(true);

        $SUT = new LicenseButtonExtension(
            'http://creativecommons.org/licenses/license_type/4.0/',
            'https://i.creativecommons.org/l/license_type/4.0/80x15.png',
            ['by', 'by-nc', 'by-nd', 'by-sa', 'by-nc-nd', 'by-nc-sa'],
            $logger
        );

        $this->assertEquals($buttonUrl, $SUT->getButtonUrl($license));
    }

    public function licenseButtonUrlProvider()
    {
        return [
            ['by', 'http://creativecommons.org/licenses/by/4.0/'],
            ['cc-by', 'http://creativecommons.org/licenses/by/4.0/'],
            ['by-nc', 'http://creativecommons.org/licenses/by-nc/4.0/'],
            ['cc-by-nc', 'http://creativecommons.org/licenses/by-nc/4.0/'],
            ['by-nc-nd', 'http://creativecommons.org/licenses/by-nc-nd/4.0/'],
            ['cc-by-nc-nd', 'http://creativecommons.org/licenses/by-nc-nd/4.0/'],
            ['wrong-license', 'https://creativecommons.org'],
            [null, 'https://creativecommons.org']
        ];
    }

    /**
     * @dataProvider licenseButtonImageUrlProvider
     */
    public function testItGetsLicenseButtonImageUrl($license, $buttonImageUrl)
    {
        $logger = \Phake::mock('Symfony\Bridge\Monolog\Logger');
        \Phake::when($logger)->error(\Phake::anyParameters())->thenReturn(true);

        $SUT = new LicenseButtonExtension(
            'http://creativecommons.org/licenses/license_type/4.0/',
            'https://i.creativecommons.org/l/license_type/4.0/80x15.png',
            ['by', 'by-nc', 'by-nd', 'by-sa', 'by-nc-nd', 'by-nc-sa'],
            $logger
        );

        $this->assertEquals($buttonImageUrl, $SUT->getButtonImageUrl($license));
    }

    public function licenseButtonImageUrlProvider()
    {
        return [
            ['by', 'https://i.creativecommons.org/l/by/4.0/80x15.png'],
            ['cc-by', 'https://i.creativecommons.org/l/by/4.0/80x15.png'],
            ['by-nc', 'https://i.creativecommons.org/l/by-nc/4.0/80x15.png'],
            ['cc-by-nc', 'https://i.creativecommons.org/l/by-nc/4.0/80x15.png'],
            ['by-nc-nd', 'https://i.creativecommons.org/l/by-nc-nd/4.0/80x15.png'],
            ['cc-by-nc-nd', 'https://i.creativecommons.org/l/by-nc-nd/4.0/80x15.png'],
            ['wrong-license', 'https://mirrors.creativecommons.org/presskit/cc.primary.srr.gif'],
            [null, 'https://mirrors.creativecommons.org/presskit/cc.primary.srr.gif']
        ];
    }


    public function testItGetsFunctionList()
    {
        $logger = \Phake::mock('Symfony\Bridge\Monolog\Logger');
        \Phake::when($logger)->error(\Phake::anyParameters())->thenReturn(true);

        $SUT = new LicenseButtonExtension('FAKE_BASE_URL', 'FAKE_BASE_IMAGE_URL', [], $logger);
        $expectedFunctionList = ['getButtonUrl', 'getButtonImageUrl'];
        $functionList = array_keys($SUT->getFunctions());

        $this->assertEquals($expectedFunctionList, $functionList);
    }

}

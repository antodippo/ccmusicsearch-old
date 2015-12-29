<?php

namespace CCMusicSearchBundle\Tests\Twig;


use CCMusicSearchBundle\Twig\LicenseButtonExtension;

class LicenseButtonExtensionTest extends \PHPUnit_Framework_TestCase
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
            array('by', 'by-nc', 'by-nd', 'by-sa', 'by-nc-nd', 'by-nc-sa'),
            $logger
        );

        $this->assertEquals($buttonUrl, $SUT->getButtonUrl($license));
    }

    public function licenseButtonUrlProvider()
    {
        return array(
            array('by', 'http://creativecommons.org/licenses/by/4.0/'),
            array('cc-by', 'http://creativecommons.org/licenses/by/4.0/'),
            array('by-nc', 'http://creativecommons.org/licenses/by-nc/4.0/'),
            array('cc-by-nc', 'http://creativecommons.org/licenses/by-nc/4.0/'),
            array('by-nc-nd', 'http://creativecommons.org/licenses/by-nc-nd/4.0/'),
            array('cc-by-nc-nd', 'http://creativecommons.org/licenses/by-nc-nd/4.0/'),
            array('wrong-license', null)
        );
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
            array('by', 'by-nc', 'by-nd', 'by-sa', 'by-nc-nd', 'by-nc-sa'),
            $logger
        );

        $this->assertEquals($buttonImageUrl, $SUT->getButtonImageUrl($license));
    }

    public function licenseButtonImageUrlProvider()
    {
        return array(
            array('by', 'https://i.creativecommons.org/l/by/4.0/80x15.png'),
            array('cc-by', 'https://i.creativecommons.org/l/by/4.0/80x15.png'),
            array('by-nc', 'https://i.creativecommons.org/l/by-nc/4.0/80x15.png'),
            array('cc-by-nc', 'https://i.creativecommons.org/l/by-nc/4.0/80x15.png'),
            array('by-nc-nd', 'https://i.creativecommons.org/l/by-nc-nd/4.0/80x15.png'),
            array('cc-by-nc-nd', 'https://i.creativecommons.org/l/by-nc-nd/4.0/80x15.png'),
            array('wrong-license', null)
        );
    }


    public function testItGetsFunctionList()
    {
        $logger = \Phake::mock('Symfony\Bridge\Monolog\Logger');
        \Phake::when($logger)->error(\Phake::anyParameters())->thenReturn(true);

        $SUT = new LicenseButtonExtension('FAKE_BASE_URL', 'FAKE_BASE_IMAGE_URL', array(), $logger);
        $expectedFunctionList = array('getButtonUrl', 'getButtonImageUrl');
        $functionList = array_keys($SUT->getFunctions());

        $this->assertEquals($expectedFunctionList, $functionList);
    }

}

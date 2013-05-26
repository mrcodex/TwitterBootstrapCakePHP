<?php
/**
 * CakeBootstrapStarterTest file
 *
 * MIT License
 * ===========
 *
 * Copyright (c) 2012 Marcelo Rocha <[Your email]>
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
 * CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @package    TwitterBootstrapCakePHP.Test.Case.View.Helper
 * @author     Marcelo Rocha <contato@omarcelo.com.br>
 * @copyright  2012 Marcelo Rocha.
 * @license    http://www.opensource.org/licenses/mit-license.php  MIT License
 * @version    1.0
 * @link       http://www.omarcelo.com.br
 */
//App::uses('TwitterBootstrapCakePHP.CakeBootstrapStarter', 'View/Helper');
App::uses('CakeBootstrapStarterHelper', 'TwitterBootstrapCakePHP.View/Helper');
App::uses('Controller', 'Controller');
App::uses('Model', 'Model');
App::uses('View', 'View');
/**
 * TheCakeBootstrapStarterTestController class
 *
 * @package TwitterBootstrapCakePHP.Test.Case.View.Helper
 */
class TheCakeBootstrapStarterTestController extends Controller {

    /**
     * name property
     *
     * @var string 'TheTest'
     */
    public $name = 'TheTest';

    /**
     * uses property
     *
     * @var mixed null
     */
    public $uses = null;
}
/**
 * CakeBootstrapStarterTest class
 *
 * @package TwitterBootstrapCakePHP.Test.Case.View.Helper
 */
class CakeBootstrapStarterTest extends CakeTestCase
{
    /**
     * CakeBootstrapStarter property
     *
     * @var CakeBootstrapStarter
     */
    public $CakeBootstrapStarter = null;

    /**
     * setUp method
     *
     * @access public
     * @return null
     */
    public function setUp()
    {
        parent::setUp();
        $this->View = $this->getMock(
            'View',
            array('append'),
            array(new TheCakeBootstrapStarterTestController())
        );
        $this->CakeBootstrapStarter = new CakeBootstrapStarterHelper($this->View);
    }

    /**
     * Test for CakeBootstrapStarter::script method. Chossing the uncompressed
     *
     * @access public
     * @return null
     */
    public function testScriptUncompressedFile()
    {

        $js = $this->CakeBootstrapStarter->script(
            array(
                'min' => false
            )
        );

        $this->assertEquals('<script type="text/javascript" src="/js/bootstrap.js"></script>', $js);
    }

    /**
     * Test for CakeBootstrapStarter::script method. Chosing the minified file
     *
     * @access public
     * @return null
     */
    public function testScriptMinifiedFile()
    {
        $js = $this->CakeBootstrapStarter->script();
        $this->assertEquals('<script type="text/javascript" src="/js/bootstrap.min.js"></script>', $js);
    }

    /**
     * Test for CakeBootstrapStarter::script method
     *
     * @access public
     * @return null
     */
    public function testScriptInlineFalse()
    {
        $js = $this->CakeBootstrapStarter->script(
            array(
                'inline' => false
            )
        );
        $this->assertNull($js);
    }

    /**
     * Test for CakeBootstrapStarter::css method. Chossing the uncompressed
     *
     * @access public
     * @return null
     */
    public function testCssUncompressedFile()
    {
        $css = $this->CakeBootstrapStarter->css(
            array(
                'min' => false
            )
        );

        $css = str_replace(array("\n", "\t"), '', $css);

        $this->assertTextEquals('<link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />', $css);
    }

    /**
     * Test for CakeBootstrapStarter::css method. Chosing the minified file
     *
     * @access public
     * @return null
     */
    public function testCssResponsiveFile()
    {
        $css = $this->CakeBootstrapStarter->css(
            array(
                'min' => true,
                'inline' => true,
                'responsive' => true
            )
        );
        $css = str_replace(array("\n", "\t"), '', $css);
        $expected = '<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />';
        $expected .= '<link rel="stylesheet" type="text/css" href="/css/bootstrap-responsive.min.css" />';
        $this->assertEquals($expected, $css);
    }

    /**
     * Test for CakeBootstrapStarter::css method
     *
     * @access public
     * @return null
     */
    public function testCssInlineFalse()
    {
        $css = $this->CakeBootstrapStarter->css(
            array(
                'inline' => false
            )
        );
        $this->assertNull($css);
    }

    /**
     * tearDown method
     *
     * @access public
     * @return null
     */
    public function tearDown()
    {
        parent::tearDown();
        unset($this->CakeBootstrapStarter, $this->View);
    }

}
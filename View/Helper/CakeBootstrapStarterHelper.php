<?php
/**
 * CakeBootstrapStarterHelper file
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
 * @package    TwitterBootstrapCakePHP.View.Helper
 * @author     Marcelo Rocha <contato@omarcelo.com.br>
 * @copyright  2012 Marcelo Rocha.
 * @license    http://www.opensource.org/licenses/mit-license.php  MIT License
 * @version    1.0
 * @link       http://www.omarcelo.com.br
 */
App::uses('AppHelper', 'View/Helper');
/**
 * CakeBootstrapStarterHelper class
 *
 * @package TwitterBootstrapCakePHP.View.Helper
 */
class CakeBootstrapStarterHelper extends AppHelper
{
    protected $cssPath = 'twitter/';

    protected $scriptPath = 'twitter/';

    public $helpers = array('Html');


    /**
     * Return the CSSs links elements and script tag required for twitter bootstrap
     *
     * @param  array $options See CakeBootstrapStarterHelper::script and CakeBootstrapStarterHelper::css
     *
     * @return mixed
     */
    public function start(array $options = array())
    {
        $out = $this->css($options);

        if ( isset($options['responsive']) ) {
            unset($options['responsive']);
        }
        $out .= $this->script($options);
        return $out;
    }

    /**
     * Return the script tag for twitter bootstrap
     *
     * Extra options:
     * min:      boolean, Default true
     * inline:   boolean, Default true
     *
     * @param  array $options Html::script options and min option
     *
     * @return mixed
     */
    public function script(array $options = array())
    {
        $options = $options + array('inline' => true, 'min' => true);
        $file = 'bootstrap';
        $suffix = '';
        if ( $options['min'] ) {
            $file .= '.min';
        }
        unset($options['min']);

        return $this->Html->script($this->scriptPath . $file, $options);
    }

    /**
     * Return the link element for twitter bootstraps CSSs stylesheets
     *
     * Extra options:
     * min:        boolean, Default true
     * inline:     boolean, Default true
     * responsive: boolean, Default false
     *
     * @param  array $options Html::css options, min and responsive options
     *
     * @return mixed
     */
    public function css(array $options = array())
    {
        $options = $options + array('inline' => true, 'min' => true, 'responsive' => false);
        $file = $this->scriptPath . 'bootstrap';
        $suffix = '';
        if ( $options['min'] ) {
            $suffix .= '.min';
        }
        $responsive = $options['responsive'];
        unset($options['min'], $options['responsive']);

        $css = array(
            $file . $suffix
        );

        if ( $responsive ) {
            $css[] = $file . '-responsive' . $suffix;
        }
        return $this->Html->css($css, null, $options);
    }

}
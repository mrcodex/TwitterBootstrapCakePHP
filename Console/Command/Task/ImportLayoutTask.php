<?php
/**
 * ImportLayoutTask file
 *
 * MIT License
 * ===========
 *
 * Copyright (c) 2012 Marcelo Rocha <contato@omarcelo.com.br>
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
 * @package    TwitterBootstrapCakePHP.Console.Command.Task
 * @author     Marcelo Rocha <contato@omarcelo.com.br>
 * @copyright  2012 Marcelo Rocha.
 * @license    http://www.opensource.org/licenses/mit-license.php  MIT License
 * @version    0.5
 * @link       http://www.omarcelo.com.br
 */
App::uses('TwitterBootstrapCakePHPTask', 'TwitterBootstrapCakePHP.Console/Command/Task');
/**
 * ImportLayoutTask class
 *
 * @package TwitterBootstrapCakePHP.Console.Command.Task
 */
class ImportLayoutTask extends TwitterBootstrapCakePHPTask
{
	/**
	 * The list of layouts
	 *
	 * @var string
	 */
	private $_layouts;

	private $_pluginLayousPath;

	private $_appLayoutsPath;

	/**
	 * Override initialize of the Shell
	 *
	 * @access public
	 * @return void
	 */
	public function initialize()
	{
		parent::initialize();
		$this->_pluginLayousPath = APP::pluginPath('TwitterBootstrapCakePHP') . 'View' . DS . 'Layouts' . DS;
		$this->_appLayoutsPath = APP . 'View' . DS . 'Layouts' . DS;
		$this->_layouts = array(
			'error' => __d('cake_console', 'Error layout'),
			'fixed' => __d('cake_console', 'Fixed layout'),
			'fixed_with_menu' => __d('cake_console', 'Fixed layout with top menu'),
			'fluid' => __d('cake_console', 'Fluid layout'),
		);
	}

	/**
	 * Execution method always used for tasks
	 * Handles dispatching to interactive, named, or all processes.
	 *
	 * @return void
	 */
    public function execute()
    {
    	$importMore = 'y';
    	do {
	    	$this->out(__d('cake_console', 'Import Layouts'));
			$this->hr();
			$ind = 0;
			$files = array();
			foreach ( $this->_layouts as $fileName => $text ) {
				$ind++;
				$files[$ind] = $fileName;
				$this->out(sprintf('[%d] %s', $ind, $text));
			}
			$this->out(__d('cake_console', '[Q]uit'));

			$option = strtoupper($this->in(__d('cake_console', 'Please choose a layout type:')));
			if ( is_numeric($option) && isset($files[(int)$option]) ) {
				$this->import($files[(int)$option]);
				$importMore = $this->in(__d('cake_console', 'Would you like to import another layout file?'), array('y', 'n'), 'n');
			} elseif ( $option == 'Q' ) {
				exit(0);
			} else {
				$this->out(__d('cake_console', 'You have made an invalid selection. Please choose an valid option by entering the number.'));
			}
		} while( $importMore === 'y');

		$this->hr();
    }

	/**
     * Import an layout file to the app
     *
     * @param string $layout Layout file name
     *
     * @return boolean
     */
    protected function import($layout)
    {
    	if ( !is_dir($this->_appLayoutsPath) && !mkdir($this->_appLayoutsPath, 0775, true) ) {
    		$this->out(__d('cake_console', '<warning>Not able to create the directory `%s`, please check permissions</warning>', $this->_appLayoutsPath));
    		return false;
    	}
    	do {
    		$fileName = trim($this->in(__d('cake_console', 'Please enter the new layout file name:'), null, $layout));
    	} while($fileName == '');

    	$fileName .= '.ctp';
    	$layout .= '.ctp';
    	return $this->copyFile($this->_pluginLayousPath . $layout, $this->_appLayoutsPath . $fileName);
    }
}
<?php
/**
 * ImportWebFilesShell file
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
 * @package    TwitterBootstrapCakePHP.Console.Command
 * @author     Marcelo Rocha <contato@omarcelo.com.br>
 * @copyright  2012 Marcelo Rocha.
 * @license    http://www.opensource.org/licenses/mit-license.php  MIT License
 * @version    0.3
 * @link       http://www.omarcelo.com.br
 */
/**
 * ImportWebFilesShell class
 *
 * @package TwitterBootstrapCakePHP.Console.Command
 */
class ImportWebFilesShell extends AppShell
{
	/**
	 * The directory where we put the downloaded file
	 *
	 * @var string
	 */
	private $_downloadDir;

	/**
	 * The url to download the "twitter bootstrap"
	 *
	 * @var string
	 */
	private $_downloadUrl;

	/**
	 * The dir where put the local "twitter bootstrap" files
	 *
	 * @var string
	 */
	private $_sourceDir;

	/**
	 * Override startup of the Shell
	 *
	 * @access public
	 * @return void
	 */
	public function startup()
	{
		parent::startup();
		$pluginPath = APP::pluginPath('TwitterBootstrapCakePHP');
		$this->_downloadDir = $pluginPath . 'tmp' . DS . 'twitter' . DS;
		$this->_downloadUrl = 'http://twitter.github.io/bootstrap/assets/bootstrap.zip';
		$this->_sourceDir = $pluginPath . 'webroot' . DS;
	}
	/**
	 * Override main() to handle action
	 *
	 * @access public
	 * @return mixed
	 */
    public function main()
    {
        $this->import($this->_sourceDir);
        //
        //2- show menu
        //
        //3- download files and unzip
        //
        //4- copy files to webroot dir
    }

    /**
     * Import the "twitter bootstrap" files to the app
     *
     * @param string $source Directory source where have the "twitter bootstrap" files
     *
     * @return null
     */
    public function import($source)
    {
    	$dest = WEBROOT_DIR;
    	$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator(
				$source,
				RecursiveDirectoryIterator::SKIP_DOTS
			),
		  	RecursiveIteratorIterator::SELF_FIRST
		);

		foreach ( $iterator as $item ) {
		  if ($item->isDir()) {
		  	$newDir = $dest . DS . $iterator->getSubPathName();
		  	if ( !is_dir($newDir) && !mkdir($newDir, 0775, true) ) {
		    	$this->out(__d('cake_console', '<warning>Not able to create the directory `%s`, please check permissions</warning>', $newDir));
		    }
		  } else {
		    $this->copyFile($item, $dest . DS . $iterator->getSubPathName());
		  }
		}
		return true;
    }

    /**
	 * Copies a file at given path, based on Shell::createFile
	 *
	 * @param string $source Path to the source file.
	 * @param string $dest   The destination path.
	 *
	 * @return boolean Success
	 */
	public function copyFile($source, $dest) {
		$source = str_replace(DS . DS, DS, $source);
		$dest = str_replace(DS . DS, DS, $dest);

		$this->out();

		if (is_file($dest) ) {
			$this->out(__d('cake_console', '<warning>File `%s` exists</warning>', $dest));
			$key = $this->in(__d('cake_console', 'Do you want to overwrite?'), array('y', 'n', 'q'), 'n');

			if (strtolower($key) === 'q') {
				$this->out(__d('cake_console', '<error>Quitting</error>.'), 2);
				$this->_stop();
			} elseif (strtolower($key) !== 'y') {
				$this->out(__d('cake_console', 'Skip `%s`', $dest), 2);
				return false;
			}
		} else {
			$this->out(__d('cake_console', 'Creating file %s', $dest));
		}

		if ( copy($source, $dest) ) {
			$this->out(__d('cake_console', '<success>Wrote</success> `%s`', $dest));
			return true;
		}

		$this->err(__d('cake_console', '<error>Could not write to `%s`</error>.', $dest), 2);
		return false;
	}
}
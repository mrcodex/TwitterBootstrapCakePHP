<?php
/**
 * TwitterBootstrapCakePHPTask file
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
 * @version    0.8
 * @link       http://www.omarcelo.com.br
 */
/**
 * TwitterBootstrapCakePHPTask class
 *
 * @package TwitterBootstrapCakePHP.Console.Command.Task
 */
class TwitterBootstrapCakePHPTask extends Shell
{
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

	/**
	 * Clear a directory
	 *
	 * @param string $path The directory path
	 *
	 * @return booolean
	 */
	protected function clearDir($path)
	{
		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator(
				$path,
				RecursiveDirectoryIterator::SKIP_DOTS
			),
		  	RecursiveIteratorIterator::CHILD_FIRST
		);

		foreach ( $iterator as $item ) {
			if ($item->isDir()) {
			  	if ( !rmdir($item->getRealPath())) {
			    	$this->out(__d('cake_console', '<warning>Not able to remove the directory `%s`, please check permissions</warning>', $item));
			    	return false;
			    }
		  	} elseif ( !unlink($item->getRealPath()) ) {
			     $this->out(__d('cake_console', '<warning>Not able to remove the file `%s`, please check permissions</warning>', $item));
			     return false;
		  	}
		}
		return true;
	}
}
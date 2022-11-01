<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2003 - 2010 mehrwert (typo3@mehrwert.de)
*  All rights reserved
*
*  This script is part of the Typo3 project. The Typo3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * Module 'Shell' for the 'mw_shell' extension.
 *
 * @author	Andreas Beutel <beutel@mehrwert.de>
 * @author	Martin Geisler <gimpster@gimpster.com>
 */

unset($MCONF);
require_once 'conf.php';
require_once $BACK_PATH . 'init.php';
require_once $BACK_PATH . 'template.php';
include_once 'locallang.php';
require_once PATH_t3lib . 'class.t3lib_scbase.php';
$BE_USER->modAccess($MCONF, 1);	// This checks permissions and exits if the users has no permission for entry.

class tx_mwshell_module1 extends t3lib_SCbase {

	/**
	 * The page info array
	 * @var Array
	 */
	public $pageinfo;

	/**
	 * Initialize Module
	 *
	 * @return	nothing
	 */
	function init()	{
		global $AB, $BE_USER, $LANG, $BACK_PATH, $TCA_DESCR, $TCA, $HTTP_GET_VARS, $HTTP_POST_VARS, $CLIENT, $TYPO3_CONF_VARS;
		parent::init();
	}

	/**
	 * Main function of the module. Write the content to $this->content
	 *
	 * @return	nothing
	 */
	function main()	{
		global $AB, $BE_USER, $LANG, $BACK_PATH, $TCA_DESCR, $TCA, $HTTP_GET_VARS, $HTTP_POST_VARS, $CLIENT, $TYPO3_CONF_VARS;

		// Access check!
		// The page will show only if there is a valid page and if this page may be viewed by the user
		$this->pageinfo = t3lib_BEfunc::readPageAccess($this->id, $this->perms_clause);
		$access = is_array($this->pageinfo) ? 1 : 0;

		if (($this->id && $access) || ($BE_USER->user['admin'] && !$this->id))	{

			// Draw the header.
			$this->doc = t3lib_div::makeInstance('bigDoc');
			$this->doc->backPath = $BACK_PATH;
			$headerSection = $this->doc->getHeader('pages',$this->pageinfo,$this->pageinfo['_thePath']).'<br>'.$LANG->php3Lang['labels']['path'].': '.t3lib_div::fixed_lgd_pre($this->pageinfo['_thePath'],50);
			$this->content.=$this->doc->startPage($LANG->getLL('title'));
			$this->content.=$this->doc->header($LANG->getLL('title'));
			$this->content.=$this->doc->spacer(5);

			// Render content:
			$this->moduleContent($LANG);

			// ShortCut
			if ($BE_USER->mayMakeShortcut())	{
				$this->content.=$this->doc->spacer(20).$this->doc->section('',$this->doc->makeShortcutIcon('id',implode(',',array_keys($this->MOD_MENU)),$this->MCONF['name']));
			}

			$this->content.=$this->doc->spacer(10);
		} else {

			// If no access or if ID == zero
			$this->doc = t3lib_div::makeInstance('bigDoc');
			$this->doc->backPath = $BACK_PATH;

			$this->content.=$this->doc->startPage($LANG->getLL('title'));
			$this->content.=$this->doc->header($LANG->getLL('title'));
			$this->content.=$this->doc->spacer(5);
			$this->content.=$this->doc->spacer(10);
		}
	}

	/**
	 * Prints out the module HTML
	 *
	 * @return	string		Module output
	 */
	function printContent()	{

		global $SOBE;

		$this->content.=$this->doc->middle();
		$this->content.=$this->doc->endPage();

		echo $this->content;
	}

	/**
	 * Returns the PHP Shell output
	 *
	 * Since version 1.0.0 this module is based on PhpShell by Martin Geisler
	 * Copyright (C) 2000-2003 Martin Geisler <gimpster@gimpster.com>
	 * Source code has been modified to fit in the TYPO3 framework.
	 *
	 * @param	array		current backend language
	 * @return	string		Returns the PHP Shell output
	 * @access	public
	 * @author		Andreas Beutel <beutel@mehrwert.de>
	 * @package		de.mehrwert.mw_shell
	 */
	function moduleContent($LANG) {

		$this->content .= '<tr><td colspan="2"><table border="0"><tr><td>';

		$mw_shell_args	= Array();
		$mw_shell_args	= t3lib_div::GPvar('mw_shell', 1);
		$work_dir		= empty($mw_shell_args['work_dir']) ? $_SERVER['DOCUMENT_ROOT'] : $mw_shell_args['work_dir'];
		$command		= empty($mw_shell_args['command']) ? '' : $mw_shell_args['command'];
		$stderr			= empty($mw_shell_args['stderr']) ? '' : $mw_shell_args['stderr'];
		$listdir		= empty($mw_shell_args['listdir']) ? '' : $mw_shell_args['listdir'];
		$regs			= Array();

		// First we check if there has been asked for a working directory.
		if ($work_dir != '') {
			// A workdir has been asked for
			if ($command != '') {
				if (ereg('^[[:blank:]]*cd[[:blank:]]+([^;]+)$', $command, $regs)) {
					// We try and match a cd command.
					if ($regs[1][0] == '/') {
						$new_dir = $regs[1]; // 'cd /something/...'
					} else {
						$new_dir = $work_dir . '/' . $regs[1]; // 'cd somedir/...'
						$new_dir = str_replace('/./', '/', $new_dir);
						$new_dir = preg_replace('|/?[^/]*/\.\.|', '$1', $new_dir);
					}
					if (@file_exists($new_dir) && @is_dir($new_dir)) {
						$work_dir = $new_dir;
					}
					$command = '';
				}
			}
		}

		if ($work_dir != '' && @file_exists($work_dir) && @is_dir($work_dir)) {
			// We change directory to that dir:
			@chdir($work_dir);
		}

		// We now update $work_dir to avoid things like '/foo/../bar':
		if ($work_dir == '') $work_dir = getcwd();

		$this->content .= '
		<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">
			<fieldset>
				<legend style="font-weight: bold;">' . $LANG->getLL('legend_input') . '</legend>
				<table border="0" cellpadding="2" cellspacing="2">
					<tbody>
					<tr>
						<td><p>' . $LANG->getLL('current_working_dir') . ': <b>';

		$work_dir_splitted = t3lib_div::trimExplode('/', substr($work_dir, 1), true);

		$this->content .= '<a href="' . $_SERVER['PHP_SELF'] . '?mw_shell[work_dir]=/&mw_shell[listdir]=' . $listdir . '">' . $LANG->getLL('root_dir') . '</a>&nbsp;/&nbsp;';

		if (!empty($work_dir_splitted[0])) {
			$path = '';
			for ($i = 0; $i < count($work_dir_splitted); $i++) {
				$path .= '/' . $work_dir_splitted[$i];
				$this->content .= '<a style="text-decoration: underline;" href="' . $_SERVER['PHP_SELF'] . '?mw_shell[work_dir]=' . urlencode($path) . '&mw_shell[listdir]=' . $listdir . '">' . $work_dir_splitted[$i] . '</a>&nbsp;/&nbsp;';
			}
		}

		$this->content .= '</b></p></td></tr>
		<tr><td><p>' . $LANG->getLL('new_working_dir') . ':
		<select name="mw_shell[work_dir]" onchange="this.form.submit()">';

		// Now we make a list of the directories.
		$dir_handle = @opendir($work_dir);
		// We store the output so that we can sort it later:
		$options = array();
		// Run through all the files and directories to find the dirs.
		while ($dir = @readdir($dir_handle)) {
			if (is_dir($dir)) {
				if ($dir == '.') {
					$options['.'] = '<option value="' . $work_dir . '" selected="selected">. ' . $LANG->getLL('current_dir') . '</option>';
				} elseif ($dir == '..') {
					// We have found the parent dir. We must be carefull if the
					// parent directory is the root directory (/).
					if (strlen($work_dir) == 1) {
						// work_dir is only 1 charecter - it can only be / There's no parent directory then.
					} elseif (strrpos($work_dir, '/') == 0) {
						// The last / in work_dir were the first character.  This
						// means that we have a top-level directory eg. /bin or /home etc...
						$options['..'] = '<option value="/">.. ' . $LANG->getLL('parent_dir') . '</option>';
					} else {
						// We do a little bit of string-manipulation to find the parent
						// directory... Trust me - it works :-)
						$options['..'] = '<option value="' . strrev(substr(strstr(strrev($work_dir), '/'), 1)) . '">.. ' . $LANG->getLL('parent_dir') . '</option>';
					}
				} else {
					if ($work_dir == '/') {
						$options[$dir] = '<option value="/'. $dir . '">|--' . $dir . '</option>';
					} else {
						$options[$dir] = '<option value="' . $work_dir . '/' . $dir . '">|--' . $dir . '</option>';
					}
				}
			}
		}
		@closedir($dir_handle);
		ksort($options);

		$this->content .= implode('\n', $options);
		$this->content .= '</select></p></td></tr>
		<tr><td><p><label style="cursor: pointer;" for="mw_shell_stderr">' . $LANG->getLL('enable_error_trapping') . '?</label> <input id="mw_shell_stderr" type="checkbox" name="mw_shell[stderr]"';

		// check for stderr-option
		if ($stderr) {
			$this->content .= ' checked="checked"';
		}

		// check for directory-listing option
		$this->content .= ' />&nbsp;&nbsp;&nbsp;<label style="cursor: pointer;" for="mw_shell_listdir">' . $LANG->getLL('always_list_directories') . '?</label> <input id="mw_shell_listdir" type="checkbox" name="mw_shell[listdir]"';

		if ($listdir) {
			$this->content .= ' checked="checked"';
		}

		$this->content .= ' /></p></td></tr>';
		$this->content .= '<tr><td><p>' . $LANG->getLL('command') . ': <input type="text" id="command" name="mw_shell[command]" size="60" />&nbsp;<input name="submit_btn" type="submit" value="' . $LANG->getLL('submitlabel') . '" /></p></td></tr>';
		$this->content .= '
		</table>
		</fieldset>
		<br />
		<fieldset>
			<legend style="font-weight: bold;">' . $LANG->getLL('legend_output') . '</legend>
			<p>
				<textarea wrap="hard" cols="100" rows="30" name="mw_shell[out]" readonly="readonly" style="font-family: Courier, mono-spaced; font-size: 9pt;">';

		if (!empty($command)) {
			if ($command == 'ls') {
				// ls looks much better with ' -F', IMHO.
				$command .= ' -F';
			}
			if ($stderr) {
				$tmpfile = t3lib_div::tempnam('mw_shell');
				$command .= ' 1> ' . $tmpfile . ' 2>&1; cat ' . $tmpfile . '; rm ' . $tmpfile;
			}
			$this->content .= htmlspecialchars(shell_exec($command), ENT_COMPAT, 'UTF-8');
		} elseif ($listdir) {
			$this->content .= htmlspecialchars(shell_exec('ls -la'), ENT_COMPAT, 'UTF-8');
		} else {
			$this->content .= $_SERVER['SERVER_NAME'] . " #\n";
			if (@file_exists('/etc/motd')) {
				$this->content .= shell_exec('cat /etc/motd');
			} else {
				$this->content .= $LANG->getLL('welcome_msg');
			}
		}

		$this->content .= '</textarea></p>
		</fieldset>
		</form>
		<script type="text/javascript">
			document.forms[0].command.focus();
		</script>';

		$this->content .= '</td></tr></tbody></table></td></tr>';
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mw_shell/mod1/index.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mw_shell/mod1/index.php']);
}

// Make instance
$SOBE = t3lib_div::makeInstance('tx_mwshell_module1');
$SOBE->init();

// Include files
reset($SOBE->include_once);
while(list(,$INC_FILE) = each($SOBE->include_once)) {
	include_once($INC_FILE);
}

$SOBE->main();
$SOBE->printContent();

?>
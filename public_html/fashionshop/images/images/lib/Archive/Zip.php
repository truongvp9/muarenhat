<?php
/**
 * 
 * This software is distributed under the GNU GPL v3.0 license.
 * @author Gemorroj
 * @copyright 2008-2011 http://wapinet.ru
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @link http://wapinet.ru/gmanager/
 * @version 0.8 beta
 * 
 * PHP version >= 5.2.1
 * 
 */


class Archive_Zip implements Archive_Interface
{
    /**
     * _pclZip
     * 
     * @param string $file
     * @return object
     */
    private function _pclZip($file)
    {
        return new PclZip(Config::get('Gmanager', 'mode') == 'FTP' ? Registry::getGmanager()->ftpArchiveStart($file) : IOWrapper::set($file));
    }


    /**
     * createArchive
     * 
     * @param string $name
     * @param mixed  $chmod
     * @param array  $ext
     * @param string $comment
     * @param bool   $overwrite
     * @return string
     */
    public function createArchive ($name = '', $chmod = 0644, $ext = array(), $comment = '', $overwrite = false)
    {
        if (!$overwrite && Registry::getGmanager()->file_exists($name)) {
            return Errors::message(Language::get('overwrite_false') . ' (' . htmlspecialchars($name, ENT_NOQUOTES) . ')', Errors::MESSAGE_FAIL);
        }

        Registry::getGmanager()->createDir(iconv_substr($name, 0, strrpos($name, '/')));

        if (Config::get('Gmanager', 'mode') == 'FTP') {
            $temp = Config::getTemp() . '/GmanagerFtpZip' . $_SERVER['REQUEST_TIME'];
            $ftp = array();
            mkdir($temp, 0755, true);
            foreach ($ext as $f) {
                $ftp[] = $tmp = $temp . '/' . IOWrapper::get(basename($f));
                if (Registry::getGmanager()->is_dir($f)) {
                    mkdir($tmp, 0755, true);
                    Registry::getGmanager()->ftpCopyFiles($f, $tmp);
                } else {
                    file_put_contents($tmp, Registry::getGmanager()->file_get_contents($f));
                }
            }
            $ext = $ftp;
            unset($ftp);
        } else {
            $temp = Registry::get('current');
            $ext = array_map(array('IOWrapper', 'set'), $ext);
        }

        //TODO:empty directories
        $zip = $this->_pclZip($name);
        if ($comment != '') {
            $result = ($zip->create($ext, PCLZIP_OPT_REMOVE_PATH, IOWrapper::set($temp), PCLZIP_OPT_COMMENT, $comment) != 0);
        } else {
            $result = ($zip->create($ext, PCLZIP_OPT_REMOVE_PATH, IOWrapper::set($temp)) != 0);
        }

        if (Config::get('Gmanager', 'mode') == 'FTP') {
            if (!Registry::getGmanager()->ftpArchiveEnd($name)) {
                $result = false;
                $zip->error_string = Errors::get();
            }
            Registry::getGmanager()->clean($temp);
        }

        if ($result) {
            if ($chmod) {
                Registry::getGmanager()->rechmod($name, $chmod);
            }
            return Errors::message(Language::get('create_archive_true'), Errors::MESSAGE_OK);
        } else {
            return Errors::message(Language::get('create_archive_false') . '<br/>' . htmlspecialchars($zip->errorInfo(true), ENT_NOQUOTES), Errors::MESSAGE_EMAIL);
        }
    }


    /**
     * addFile
     * 
     * @param string $current
     * @param mixed  $ext
     * @param string $dir
     * @return string
     */
    public function addFile ($current = '', $ext = array(), $dir = '')
    {
        $tmpFolder = Config::getTemp() . '/GmanagerFtpZip' . $_SERVER['REQUEST_TIME'];
        mkdir($tmpFolder, 0777);

        $tmp = array();
        foreach ($ext as $v) {
            $b = IOWrapper::set(basename($v));
            $tmp[] = $tmpFolder . '/' . $b;
            if (Registry::getGmanager()->is_dir($v)) {
                mkdir($tmpFolder . '/' . $b, 0777, true);
            } else {
                file_put_contents($tmpFolder . '/' . $b, Registry::getGmanager()->file_get_contents($v));
            }
        }


        $zip = $this->_pclZip($current);
        $add = $zip->add($tmp, PCLZIP_OPT_ADD_PATH, IOWrapper::set($dir), PCLZIP_OPT_REMOVE_PATH, $tmpFolder);

        if (Config::get('Gmanager', 'mode') == 'FTP') {
            if (!Registry::getGmanager()->ftpArchiveEnd($current)) {
                $add = false;
                $zip->error_string = Errors::get();
            }
        }
        Registry::getGmanager()->clean($tmpFolder);

        if ($add) {
            return Errors::message(Language::get('add_archive_true'), Errors::MESSAGE_OK);
        } else {
            return Errors::message(Language::get('add_archive_false') . '<br/>' . $zip->errorInfo(true), Errors::MESSAGE_EMAIL);
        }
    }


    /**
     * delFile
     * 
     * @param string $current
     * @param string $f
     * @return string
     */
    public function delFile ($current = '', $f = '')
    {
        $zip = $this->_pclZip($current);
        //    $comment = $zip->properties();
        //    $comment = $comment['comment'];
        //  TODO: сохранение комментариев

        // fix del directory
        foreach ($zip->listContent() as $index) {
            if ($index['stored_filename'] == $f) {
                break;
            }
        }

        $list = $zip->delete(PCLZIP_OPT_BY_INDEX, $index['index']);


        if (Config::get('Gmanager', 'mode') == 'FTP') {
            Registry::getGmanager()->ftpArchiveEnd($current);
        }

        if ($list != 0) {
            return Errors::message(Language::get('del_file_true') . ' (' . htmlspecialchars($f, ENT_NOQUOTES) . ')', Errors::MESSAGE_OK);
        } else {
            return Errors::message(Language::get('del_file_false') . '<br/>' . $zip->errorInfo(true), Errors::MESSAGE_EMAIL);
        }
    }


    /**
     * extractFile
     * 
     * @param string $current
     * @param string $name
     * @param mixed  $chmod
     * @param string $fl
     * @param bool   $overwrite
     * @return string
     */
    public function extractFile ($current = '', $name = '', $chmod = '', $fl = '', $overwrite = false)
    {
        $err = '';
        if ($overwrite) {
            $ext = & $fl;
        } else {
            $ext = array();
            foreach ($fl as $f) {
                if (Registry::getGmanager()->file_exists($name . '/' . $f)) {
                    $err .= Language::get('overwrite_false') . ' (' . htmlspecialchars($f, ENT_NOQUOTES) . ')<br/>';
                } else {
                    $ext[] = $f;
                }
            }
            unset($fl);
        }

        if (!$ext) {
            return Errors::message(Language::get('extract_false'), Errors::MESSAGE_FAIL) . ($err ? Errors::message(rtrim($err, '<br/>'), Errors::MESSAGE_FAIL) : '');
        }

        $sysName = IOWrapper::set($name);

        if (Config::get('Gmanager', 'mode') == 'FTP') {
            $sysName = ($sysName[0] == '/' ? $sysName : dirname(IOWrapper::set($current) . '/') . '/' . $sysName);
            $ftp_name = Config::getTemp() . '/GmanagerFtpZipFile' . $_SERVER['REQUEST_TIME'] . '.tmp';
        }

        $zip = $this->_pclZip($current);
        $res = $zip->extract(PCLZIP_OPT_PATH, Config::get('Gmanager', 'mode') == 'FTP' ? $ftp_name : $sysName, PCLZIP_OPT_BY_NAME, $ext, PCLZIP_OPT_REPLACE_NEWER);

        foreach ($res as $status) {
            if ($status['status'] != 'ok') {
                $err .= str_replace('%file%', htmlspecialchars($status['stored_filename'], ENT_NOQUOTES), Language::get('extract_file_false_ext')) . ' (' . $status['status'] . ')<br/>';
            }
        }

        if (!$res) {
            if (Config::get('Gmanager', 'mode') == 'FTP') {
                Registry::getGmanager()->ftpArchiveEnd();
            }
            return Errors::message(Language::get('extract_file_false') . '<br/>' . $zip->errorInfo(true), Errors::MESSAGE_EMAIL);
        }

        if (Config::get('Gmanager', 'mode') == 'FTP') {
            Registry::getGmanager()->createDir($sysName);
            Registry::getGmanager()->ftpMoveFiles($ftp_name, $sysName, $overwrite);
            Registry::getGmanager()->ftpArchiveEnd();
        }

        if (Config::get('Gmanager', 'mode') == 'FTP' || Registry::getGmanager()->is_dir($name)) {
            if ($chmod) {
                Registry::getGmanager()->rechmod($name, $chmod);
            }
            return Errors::message(Language::get('extract_file_true'), Errors::MESSAGE_OK) . ($err ? Errors::message(rtrim($err, '<br/>'), Errors::MESSAGE_FAIL) : '');
        } else {
            return Errors::message(Language::get('extract_file_false'), Errors::MESSAGE_EMAIL);
        }
    }


    /**
     * extractArchive
     * 
     * @param string $current
     * @param string $name
     * @param array  $chmod
     * @param bool   $overwrite
     * @return string
     */
    public function extractArchive ($current = '', $name = '', $chmod = array(), $overwrite = false)
    {
        $sysName = IOWrapper::set($name);
        Registry::set('extractArchiveDirectoryChmod', $chmod[1]);
        Registry::set('extractArchiveFileChmod', $chmod[0]);

        function pclzip_cb_post_extract ($p_event, &$p_header)
        {
            if (Registry::getGmanager()->is_dir(IOWrapper::get($p_header['filename']))) {
                Registry::getGmanager()->rechmod(IOWrapper::get($p_header['filename']), Registry::get('extractArchiveDirectoryChmod'));
            } else if (Config::get('Gmanager', 'mode') != 'FTP') {
                Registry::getGmanager()->rechmod(IOWrapper::get($p_header['filename']), Registry::get('extractArchiveFileChmod'));
            }
            return 1;
        }

        if (Config::get('Gmanager', 'mode') == 'FTP') {
            $sysName = ($sysName[0] == '/' ? $sysName : dirname(IOWrapper::set($current) . '/') . '/' . $sysName);
            $ftp_name = Config::getTemp() . '/GmanagerFtpZip' . $_SERVER['REQUEST_TIME'];
            mkdir($ftp_name, 0777);
        }


        $zip = $this->_pclZip($current);


        if ($overwrite) {
            $res = $zip->extract(PCLZIP_OPT_PATH, Config::get('Gmanager', 'mode') == 'FTP' ? $ftp_name : $sysName, PCLZIP_CB_POST_EXTRACT, 'pclzip_cb_post_extract', PCLZIP_OPT_REPLACE_NEWER);
        } else {
            $res = $zip->extract(PCLZIP_OPT_PATH, Config::get('Gmanager', 'mode') == 'FTP' ? $ftp_name : $sysName, PCLZIP_CB_POST_EXTRACT, 'pclzip_cb_post_extract');
        }


        if (!$res) {
            if (Config::get('Gmanager', 'mode') == 'FTP') {
                Registry::getGmanager()->ftpArchiveEnd();
                rmdir($ftp_name);
            }
            return Errors::message(Language::get('extract_false') . '<br/>' . $zip->errorInfo(true), Errors::MESSAGE_EMAIL);
        }

        $err = '';
        foreach ($res as $status) {
            if ($status['status'] != 'ok') {
                $err .= str_replace('%file%', htmlspecialchars($status['stored_filename'], ENT_NOQUOTES), Language::get('extract_file_false_ext')) . ' (' . $status['status'] . ')<br/>';
            }
        }

        if (Config::get('Gmanager', 'mode') == 'FTP') {
            Registry::getGmanager()->createDir($sysName, Registry::get('extractArchiveDirectoryChmod'));
            Registry::getGmanager()->ftpMoveFiles($ftp_name, $sysName, Registry::get('extractArchiveFileChmod'), Registry::get('extractArchiveDirectoryChmod'), $overwrite);
            Registry::getGmanager()->ftpArchiveEnd();
        }

        if (Config::get('Gmanager', 'mode') == 'FTP' || Registry::getGmanager()->is_dir($sysName)) {
            if ($chmod) {
                Registry::getGmanager()->rechmod($sysName, $chmod[1]);
            }
            return Errors::message(Language::get('extract_true'), Errors::MESSAGE_OK) . ($err ? Errors::message(rtrim($err, '<br/>'), Errors::MESSAGE_FAIL) : '');
        } else {
            return Errors::message(Language::get('extract_false'), Errors::MESSAGE_EMAIL);
        }
    }


    /**
     * lookFile
     * 
     * @param string $current
     * @param string $f
     * @param string $str
     * @return string
     */
    public function lookFile ($current = '', $f = '', $str = false)
    {
        $r_current = str_replace('%2F', '/', rawurlencode($current));
        $r_f = str_replace('%2F', '/', rawurlencode($f));

        $zip = $this->_pclZip($current);
        $ext = $zip->extract(PCLZIP_OPT_BY_NAME, $f, PCLZIP_OPT_EXTRACT_AS_STRING);

        if (Config::get('Gmanager', 'mode') == 'FTP') {
            Registry::getGmanager()->ftpArchiveEnd();
        }

        if (!$ext) {
            return Errors::message(Language::get('archive_error'), Errors::MESSAGE_EMAIL);
        } else if ($ext[0]['status'] == 'unsupported_encryption') {
            return Errors::message(Language::get('archive_error_encrypt'), Errors::MESSAGE_EMAIL);
        } else {
            if ($str) {
                return $ext[0]['content'];
            } else {
                return Errors::message(Language::get('archive_size') . ': ' . Registry::getGmanager()->formatSize($ext[0]['compressed_size']) . '<br/>' . Language::get('real_size') . ': ' . Registry::getGmanager()->formatSize($ext[0]['size']) . '<br/>' . Language::get('archive_date') . ': ' . strftime(Config::get('Gmanager', 'dateFormat'), $ext[0]['mtime']) . '<br/>&#187;<a href="edit.php?c=' . $r_current . '&amp;f=' . $r_f . '">' . Language::get('edit') . '</a>', Errors::MESSAGE_OK) . Registry::getGmanager()->code(trim($ext[0]['content']));
            }
        }
    }


    /**
     * getEditFile
     * 
     * @param string $current
     * @param string $f
     * @return array
     */
    public function getEditFile ($current = '', $f = '')
    {
        $zip = $this->_pclZip($current);
        $ext = $zip->extract(PCLZIP_OPT_BY_NAME, $f, PCLZIP_OPT_EXTRACT_AS_STRING);

        if (Config::get('Gmanager', 'mode') == 'FTP') {
            Registry::getGmanager()->ftpArchiveEnd();
        }

        if (!$ext) {
            return array('text' => Language::get('archive_error'), 'size' => 0, 'lines' => 0);
        } else {
            return array('text' => trim($ext[0]['content']), 'size' => Registry::getGmanager()->formatSize($ext[0]['size']), 'lines' => sizeof(explode("\n", $ext[0]['content'])));
        }
    }


    /**
     * setEditFile
     * 
     * @param string $current
     * @param string $f
     * @param string $text
     * @return string
     */
    public function setEditFile ($current = '', $f = '', $text = '')
    {
        Registry::set('setEditFile', $f);

        $tmp = Config::getTemp() . '/GmanagerArchivers' . $_SERVER['REQUEST_TIME'] . '.tmp';

        $fp = fopen($tmp, 'w');

        if (!$fp) {
            return Errors::message(Language::get('fputs_file_false') . '<br/>' . Errors::get(), Errors::MESSAGE_EMAIL);
        }

        fputs($fp, $text);
        fclose($fp);

        $zip = $this->_pclZip($current);
        $comment = $zip->properties();
        $comment = $comment['comment'];

        if ($zip->delete(PCLZIP_OPT_BY_NAME, $f) == 0) {
            if (Config::get('Gmanager', 'mode') == 'FTP') {
                Registry::getGmanager()->ftpArchiveEnd();
            }
            unlink($tmp);
            return Errors::message(Language::get('fputs_file_false') . '<br/>' . $zip->errorInfo(true), Errors::MESSAGE_EMAIL);
        }


        function pclzip_pre_add ($p_event, &$p_header)
        {
            $p_header['stored_filename'] = Registry::get('setEditFile');
            return 1;
        }

        $fl = $zip->add($tmp, PCLZIP_CB_PRE_ADD, 'pclzip_pre_add', PCLZIP_OPT_COMMENT, $comment);

        unlink($tmp);
        if (Config::get('Gmanager', 'mode') == 'FTP') {
            Registry::getGmanager()->ftpArchiveEnd($current);
        }

        if ($fl) {
            return Errors::message(Language::get('fputs_file_true'), Errors::MESSAGE_OK);
        } else {
            return Errors::message(Language::get('fputs_file_false'), Errors::MESSAGE_EMAIL);
        }
    }


    /**
     * listArchive
     * 
     * @param string $current
     * @param string $down
     * @return string
     */
    public function listArchive ($current = '', $down = '')
    {
        //TODO: refactoring to ListData
        $r_current = str_replace('%2F', '/', rawurlencode($current));

        $zip = $this->_pclZip($current);
        $list = $zip->listContent();

        if (!$list) {
            if (Config::get('Gmanager', 'mode') == 'FTP') {
                Registry::getGmanager()->ftpArchiveEnd();
            }
            return '<tr class="border"><td colspan="' . (array_sum(Config::getSection('Display')) + 1) . '">' . Errors::message(Language::get('archive_error') . '<br/>' . $zip->errorInfo(true), Errors::MESSAGE_EMAIL) . '</td></tr>';
        } else {
            $l = '';

            if ($down) {
                $list = array_reverse($list);
            }

            $s = sizeof($list);
            for ($i = 0; $i < $s; ++$i) {
                $r_name = str_replace('%2F', '/', rawurlencode($list[$i]['filename']));

                if ($list[$i]['folder']) {
                    $type = 'DIR';
                    $name = htmlspecialchars($list[$i]['filename'], ENT_NOQUOTES);
                    $size = ' ';
                    $down = ' ';
                } else {
                    $type = htmlspecialchars(Registry::getGmanager()->getType($list[$i]['filename']), ENT_NOQUOTES);
                    $name = '<a href="?c=' . $r_current . '&amp;f=' . $r_name . '">' . htmlspecialchars(Registry::getGmanager()->strLink($list[$i]['filename'], true), ENT_NOQUOTES) . '</a>';
                    $size = Registry::getGmanager()->formatSize($list[$i]['size']);
                    $down = '<a href="change.php?get=' . $r_current . '&amp;f=' . $r_name . '">' . Language::get('get') . '</a>';
                }

                $l .= '<tr class="border"><td class="check"><input name="check[]" type="checkbox" value="' . $r_name . '"/></td>';
                if (Config::get('Display', 'name')) {
                    $l .= '<td>' . $name . '</td>';
                }
                if (Config::get('Display', 'down')) {
                    $l .= '<td>' . $down . '</td>';
                }
                if (Config::get('Display', 'type')) {
                    $l .= '<td>' . $type . '</td>';
                }
                if (Config::get('Display', 'size')) {
                    $l .= '<td>' . $size . '</td>';
                }
                if (Config::get('Display', 'change')) {
                    $l .= '<td><a href="change.php?c=' . $r_current . '&amp;f=' . $r_name . '">' . Language::get('ch') . '</a></td>';
                }
                if (Config::get('Display', 'del')) {
                    $l .= '<td><a onclick="return Gmanager.delNotify();" href="change.php?go=del_zip_archive&amp;c=' . $r_current . '&amp;f=' . $r_name . '">' . Language::get('dl') . '</a></td>';
                }
                if (Config::get('Display', 'chmod')) {
                    $l .= '<td> </td>';
                }
                if (Config::get('Display', 'date')) {
                    $l .= '<td>' . strftime(Config::get('Gmanager', 'dateFormat'), $list[$i]['mtime']) . '</td>';
                }
                if (Config::get('Display', 'uid')) {
                    $l .= '<td> </td>';
                }
                if (Config::get('Display', 'gid')) {
                    $l .= '<td> </td>';
                }
                if (Config::get('Display', 'n')) {
                    $l .= '<td>' . ($i + 1) . '</td>';
                }

                $l .= '</tr>';
            }

            if (Config::get('Gmanager', 'mode') == 'FTP') {
                Registry::getGmanager()->ftpArchiveEnd();
            }

            $prop = $zip->properties();
            if (isset($prop['comment']) && $prop['comment'] != '') {
                if (iconv('UTF-8', 'UTF-8', $prop['comment']) != $prop['comment']) {
                    $prop['comment'] = iconv(Config::get('Gmanager', 'altEncoding'), 'UTF-8//TRANSLIT', $prop['comment']);
                }
                $l .= '<tr class="border"><td>' . Language::get('comment_archive') . '</td><td colspan="' . (array_sum(Config::getSection('Display')) + 1) . '"><pre>' . htmlspecialchars($prop['comment'], ENT_NOQUOTES) . '</pre></td></tr>';
            }

            return $l;
        }
    }


    /**
     * renameFile
     *
     * @param string $current
     * @param string $name
     * @param string $arch_name
     * @param bool   $del
     * @param bool   $overwrite
     * @return string
     */
    public function renameFile ($current, $name, $arch_name, $del = false, $overwrite = false)
    {
        $tmp        = Config::getTemp() . '/GmanagerZip' . $_SERVER['REQUEST_TIME'];
        $zip        = $this->_pclZip($current);
        $folder     = '';
        $sysName    = IOWrapper::set($name);

        foreach ($zip->extract(PCLZIP_OPT_PATH, $tmp) as $f) {
            if ($f['status'] != 'ok') {
                Registry::getGmanager()->clean($tmp);
                if (Config::get('Gmanager', 'mode') == 'FTP') {
                    Registry::getGmanager()->ftpArchiveEnd();
                }
                return Errors::message(Language::get('extract_false'), Errors::MESSAGE_FAIL);
                break;
            }
            if ($arch_name == $f['stored_filename']) {
                $folder = $f['folder'];
            }
        }

        if (file_exists($tmp . '/' . $sysName)) {
            if ($overwrite) {
                if ($folder) {
                    Registry::getGmanager()->clean($tmp . '/' . $sysName);
                } else {
                    unlink($tmp . '/' . $sysName);
                }
            } else {
                Registry::getGmanager()->clean($tmp);
                if (Config::get('Gmanager', 'mode') == 'FTP') {
                    Registry::getGmanager()->ftpArchiveEnd();
                }
                return Errors::message(Language::get('overwrite_false'), Errors::MESSAGE_FAIL);
            }
        }

        if ($folder) {
            @mkdir($tmp . '/' . $sysName, 0755, true);
        } else if (!is_dir($tmp . '/' . dirname($sysName))) {
            @mkdir($tmp . '/' . dirname($sysName), 0755, true);
        }


        if ($folder) {
            // переделать на ftp
            if ($del) {
                $result = Registry::getGmanager()->moveFiles($tmp . '/' . $arch_name, $tmp . '/' . $name);
            } else {
                $result = Registry::getGmanager()->copyFiles($tmp . '/' . $arch_name, $tmp . '/' . $name);
            }
        } else {
            if ($del) {
                $result = rename($tmp . '/' . $arch_name, $tmp . '/' . $sysName);
            } else {
                $result = copy($tmp . '/' . $arch_name, $tmp . '/' . $sysName);
            }
        }

        if (!$result) {
            Registry::getGmanager()->clean($tmp);
            if (Config::get('Gmanager', 'mode') == 'FTP') {
                Registry::getGmanager()->ftpArchiveEnd();
            }
            if ($folder) {
                if ($del) {
                    return Errors::message(str_replace('%title%', htmlspecialchars($arch_name, ENT_NOQUOTES), Language::get('move_files_false')), Errors::MESSAGE_FAIL);
                } else {
                    return Errors::message(str_replace('%title%', htmlspecialchars($arch_name, ENT_NOQUOTES), Language::get('copy_files_false')), Errors::MESSAGE_FAIL);
                }
            } else {
                if ($del) {
                    return Errors::message(str_replace('%file%', htmlspecialchars($arch_name, ENT_NOQUOTES), Language::get('move_file_false')), Errors::MESSAGE_FAIL);
                } else {
                    return Errors::message(str_replace('%file%', htmlspecialchars($arch_name, ENT_NOQUOTES), Language::get('copy_file_false')), Errors::MESSAGE_FAIL);
                }
            }
        }

        $result = ($zip->create($tmp, PCLZIP_OPT_REMOVE_PATH, iconv_substr($tmp, iconv_strlen(dirname(dirname($tmp))))) != 0);

        Registry::getGmanager()->clean($tmp);
        if (Config::get('Gmanager', 'mode') == 'FTP') {
            Registry::getGmanager()->ftpArchiveEnd($current);
        }

        if ($result) {
            if ($folder) {
                if ($del) {
                    return Errors::message(str_replace('%title%', htmlspecialchars($arch_name, ENT_NOQUOTES), Language::get('move_files_true')), Errors::MESSAGE_OK);
                } else {
                    return Errors::message(str_replace('%title%', htmlspecialchars($arch_name, ENT_NOQUOTES), Language::get('copy_files_true')), Errors::MESSAGE_OK);
                }
            } else {
                if ($del) {
                    return Errors::message(str_replace('%file%', htmlspecialchars($arch_name, ENT_NOQUOTES), Language::get('move_file_true')), Errors::MESSAGE_OK);
                } else {
                    return Errors::message(str_replace('%file%', htmlspecialchars($arch_name, ENT_NOQUOTES), Language::get('copy_file_true')), Errors::MESSAGE_OK);
                }
            }
        } else {
            if ($folder) {
                if ($del) {
                    return Errors::message(str_replace('%title%', htmlspecialchars($arch_name, ENT_NOQUOTES), Language::get('move_files_false')), Errors::MESSAGE_FAIL);
                } else {
                    return Errors::message(str_replace('%title%', htmlspecialchars($arch_name, ENT_NOQUOTES), Language::get('copy_files_false')), Errors::MESSAGE_FAIL);
                }
            } else {
                if ($del) {
                    return Errors::message(str_replace('%file%', htmlspecialchars($arch_name, ENT_NOQUOTES), Language::get('move_file_false')), Errors::MESSAGE_FAIL);
                } else {
                    return Errors::message(str_replace('%file%', htmlspecialchars($arch_name, ENT_NOQUOTES), Language::get('copy_file_false')), Errors::MESSAGE_FAIL);
                }
            }
        }
    }
}

?>

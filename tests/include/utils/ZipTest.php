<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2012 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/


require_once('include/utils/zip_utils.php');
/**
 * @ticket 40957
 */
class ZipTest extends Sugar_PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if(!class_exists('ZipArchive'))
        {
            $this->markTestSkipped('ZipArchive class not loaded');
        }
        $this->testdir = sugar_cached("tests/include/utils/ziptest");
        sugar_mkdir($this->testdir.'/testarchive',null,true);
        sugar_touch($this->testdir.'/testarchive/testfile1.txt');
        sugar_touch($this->testdir.'/testarchive/testfile2.txt');
        sugar_touch($this->testdir.'/testarchive/testfile3.txt');
        sugar_mkdir($this->testdir.'/testarchiveoutput',null,true);
    }

    public function tearDown()
    {
        if ( is_dir($this->testdir) )
            rmdir_recursive($this->testdir);
    }

    public function testZipADirectory()
	{
		zip_dir($this->testdir.'/testarchive',$this->testdir.'/testarchive.zip');

		$this->assertTrue(file_exists($this->testdir.'/testarchive.zip'));
	}

	public function testZipADirectoryFailsWhenDirectorySpecifedDoesNotExists()
	{
	    $this->assertFalse(zip_dir($this->testdir.'/notatestarchive',$this->testdir.'/testarchive.zip'));
	}

	/**
     * @depends testZipADirectory
     */
    public function testExtractEntireArchive()
	{
	    zip_dir($this->testdir.'/testarchive',$this->testdir.'/testarchive.zip');
		unzip($this->testdir.'/testarchive.zip',$this->testdir.'/testarchiveoutput');

	    $this->assertTrue(file_exists($this->testdir.'/testarchiveoutput/testfile1.txt'));
	    $this->assertTrue(file_exists($this->testdir.'/testarchiveoutput/testfile2.txt'));
	    $this->assertTrue(file_exists($this->testdir.'/testarchiveoutput/testfile3.txt'));
	}

	/**
     * @depends testZipADirectory
     */
    public function testExtractSingleFileFromAnArchive()
	{
	    zip_dir($this->testdir.'/testarchive',$this->testdir.'/testarchive.zip');
		unzip_file($this->testdir.'/testarchive.zip','testfile1.txt',$this->testdir.'/testarchiveoutput');

	    $this->assertTrue(file_exists($this->testdir.'/testarchiveoutput/testfile1.txt'));
	    $this->assertFalse(file_exists($this->testdir.'/testarchiveoutput/testfile2.txt'));
	    $this->assertFalse(file_exists($this->testdir.'/testarchiveoutput/testfile3.txt'));
	}

	/**
     * @depends testZipADirectory
     */
    public function testExtractTwoIndividualFilesFromAnArchive()
	{
	    zip_dir($this->testdir.'/testarchive',$this->testdir.'/testarchive.zip');
		unzip_file($this->testdir.'/testarchive.zip',array('testfile2.txt','testfile3.txt'),$this->testdir.'/testarchiveoutput');

	    $this->assertFalse(file_exists($this->testdir.'/testarchiveoutput/testfile1.txt'));
	    $this->assertTrue(file_exists($this->testdir.'/testarchiveoutput/testfile2.txt'));
	    $this->assertTrue(file_exists($this->testdir.'/testarchiveoutput/testfile3.txt'));
	}

	public function testExtractFailsWhenArchiveDoesNotExist()
	{
	    $this->assertFalse(unzip($this->testdir.'/testarchivenothere.zip',$this->testdir.'/testarchiveoutput'));
	}

	public function testExtractFailsWhenExtractDirectoryDoesNotExist()
	{
	    $this->assertFalse(unzip($this->testdir.'/testarchive.zip',$this->testdir.'/testarchiveoutputnothere'));
	}

	public function testExtractFailsWhenFilesDoNotExistInArchive()
	{
	    $this->assertFalse(unzip_file($this->testdir.'/testarchive.zip','testfile4.txt',$this->testdir.'/testarchiveoutput'));
	}
}

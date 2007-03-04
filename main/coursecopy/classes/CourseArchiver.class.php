<?php
// $Id: CourseArchiver.class.php 11378 2007-03-04 01:34:09Z yannoo $
/*
==============================================================================
	Dokeos - elearning and course management software

	Copyright (c) 2004 Dokeos S.A.
	Copyright (c) 2003 Ghent University (UGent)
	Copyright (c) 2001 Universite catholique de Louvain (UCL)
	Copyright (c) Bart Mollet (bart.mollet@hogent.be)

	For a full list of contributors, see "credits.txt".
	The full license can be read in "license.txt".

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	See the GNU General Public License for more details.

	Contact address: Dokeos, 44 rue des palais, B-1030 Brussels, Belgium
	Mail: info@dokeos.com
==============================================================================
*/
require_once ('Course.class.php');
require_once ('mkdirr.php');
require_once ('rmdirr.php');
require_once (api_get_path(LIBRARY_PATH).'pclzip/pclzip.lib.php');
/**
 * Some functions to write a course-object to a zip-file and to read a course-
 * object from such a zip-file.
 * @author Bart Mollet <bart.mollet@hogent.be>
 * @package dokeos.backup
 *
 * @todo Use archive-folder of Dokeos?
 */
class CourseArchiver
{
	/**
	 * Delete old temp-dirs
	 */
	function clean_backup_dir()
	{
		$dir = api_get_path(SYS_ARCHIVE_PATH);
		if ($handle = @ opendir($dir))
		{
			while (($file = readdir($handle)) !== false)
			{
				if ($file != "." && $file != ".." && strpos($file,'CourseArchiver_') == 0 && is_dir($dir.'/'.$file))
				{
					rmdirr($dir.'/'.$file);
				}
			}
			closedir($handle);
		}
	}
	/**
	 * Write a course and all its resources to a zip-file.
	 * @return string A pointer to the zip-file
	 */
	function write_course($course)
	{
		CourseArchiver::clean_backup_dir();
		// Create a temp directory
		$tmp_dir_name = 'CourseArchiver_'.uniqid('');
		$backup_dir = api_get_path(SYS_ARCHIVE_PATH).''.$tmp_dir_name.'/';
		// All course-information will be stored in course_info.dat
		$course_info_file = $backup_dir.'course_info.dat';
		$zip_dir = api_get_path(SYS_ARCHIVE_PATH).'';
		$user = api_get_user_info();
		$zip_file = $user['user_id'].'_'.$course->code.'_'.date("YmdHis").'.zip';
		mkdir($backup_dir, 0755);
		// Write the course-object to the file
		$fp = fopen($course_info_file, 'w');
		fwrite($fp, base64_encode(serialize($course)));
		fclose($fp);

		// Copy all documents to the temp-dir
		if( is_array($course->resources[RESOURCE_DOCUMENT]))
		{
			foreach ($course->resources[RESOURCE_DOCUMENT] as $id => $document)
			{
				if ($document->file_type == DOCUMENT)
				{
					$doc_dir = $backup_dir.$document->path;
					mkdirr(dirname($doc_dir), 0755);
					copy($course->path.$document->path, $doc_dir);
				}
				else
				{
					mkdirr($backup_dir.$document->path, 0755);
				}
			}
		}

		// Copy all scorm documents to the temp-dir
		if( is_array($course->resources[RESOURCE_SCORM]))
		{
			foreach ($course->resources[RESOURCE_SCORM] as $id => $document)
			{
				$doc_dir=dirname($backup_dir.$document->path);

				mkdirr($doc_dir,0755);

				copyDirTo($course->path.$document->path, $doc_dir, false);
			}
		}

		// Zip the course-contents
		$zip = new PclZip($zip_dir.$zip_file);
		$zip->create($zip_dir.$tmp_dir_name, PCLZIP_OPT_REMOVE_PATH, $zip_dir.$tmp_dir_name.'/');
		//$zip->deleteByIndex(0);
		// Remove the temp-dir.
		rmdirr($backup_dir);
		return ''.$zip_file;
	}
	/**
	 *
	 */
	function get_available_backups($user_id = null)
	{
		global $dateTimeFormatLong;
		$backup_files = array();
		$dirname = api_get_path(SYS_ARCHIVE_PATH).'';
		if ($dir = opendir($dirname)) {
  			while (($file = readdir($dir)) !== false) {
  				 $file_parts = explode('_',$file);
  				 if(count($file_parts) == 3)
  				 {
  				 	$owner_id = $file_parts[0];
  				 	$course_code = $file_parts[1];
  				 	$file_parts = explode('.',$file_parts[2]);
  				 	$date = $file_parts[0];
  				 	$ext = $file_parts[1];
  				 	if($ext == 'zip' && ($user_id != null && $owner_id == $user_id || $user_id == null) )
  				 	{
  				 		$date = substr($date,0,4).'-'.substr($date,4,2).'-'.substr($date,6,2).' '.substr($date,8,2).':'.substr($date,10,2).':'.substr($date,12,2);
  				 		$backup_files[] = array('file' => $file, 'date' => $date, 'course_code' => $course_code);
  				 	}
  				 }
  			}
  			closedir($dir);
		}
		return $backup_files;
	}
	/**
	 *
	 */
	function import_uploaded_file($file)
	{
		$new_filename = uniqid('').'.zip';
		move_uploaded_file($file,api_get_path(SYS_ARCHIVE_PATH).''.$new_filename);
		return $new_filename;
	}
	/**
	 * Read a course-object from a zip-file
	 * @return course The course
	 * @param boolean $delete Delete the file after reading the course?
	 * @todo Check if the archive is a correct Dokeos-export
	 */
	function read_course($filename,$delete = false)
	{
		CourseArchiver::clean_backup_dir();
		// Create a temp directory
		$tmp_dir_name = 'CourseArchiver_'.uniqid('');
		$unzip_dir = api_get_path(SYS_ARCHIVE_PATH).''.$tmp_dir_name;
		mkdirr($unzip_dir,0755);
		copy(api_get_path(SYS_ARCHIVE_PATH).''.$filename,$unzip_dir.'/backup.zip');
		// unzip the archive
		$zip = new PclZip($unzip_dir.'/backup.zip');
		chdir($unzip_dir);
		$zip->extract();
		// remove the archive-file
		if($delete)
		{
			unlink(api_get_path(SYS_ARCHIVE_PATH).''.$filename);
		}
		// read the course
		if(!is_file('course_info.dat'))
		{
			return new Course();
		}
		$fp = fopen('course_info.dat', "r");
		$contents = fread($fp, filesize('course_info.dat'));
		fclose($fp);
		$course = unserialize(base64_decode($contents));
		if( get_class($course) != 'Course')
		{
			return new Course();
		}
		$course->backup_path = $unzip_dir;
		return $course;
	}
}
?>
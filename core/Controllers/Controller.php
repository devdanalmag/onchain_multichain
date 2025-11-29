<?php

class Controller
{


	public function createNotification1($type, $msg)
	{
		$alert = '
			<div class="alert ' . $type . ' alert-dismissible fade show" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			  <strong>Message: </strong> ' . $msg . '
			</div>
			';
		return $alert;
	}

	//Add Dash To String
	public function addDash($title)
	{
		$title = str_replace(" ", "-", $title);
		$title = addslashes($title);
		return $title;
	}

	//Remove Dash From Sting
	public function removeDash($title)
	{
		$title = str_replace("-", " ", $title);
		$title = addslashes($title);
		return $title;
	}

	//Format Date
	public function formatDate($date)
	{
		$date = date("d M Y h:iA", strtotime($date));
		return $date;
	}

	//Format Date
	public function formatDate2($date)
	{
		$date = date("d/m/Y", strtotime($date));
		return $date;
	}

	//Format Text
	public function formatText($text)
	{
		return str_replace("\n", "<br/>", $text);
	}

	//Reduce Text Length
	public function shortTitle($title)
	{
		$title = substr($title, 0, 50);
		$title .= '...';
		$title = strip_tags($title);
		echo $title;
	}

	//Format User Type
	public function formatUserType($value)
	{
		$value = (float) $value;
		$output = "";
		if ($value == 1) {
			$output = "<b>User Lv. 1</b>";
		} elseif ($value == 2) {
			$output = "<b>User Lv. 2</b>";
		} else {
			$output = "<b>Merchant</b>";
		}
		return $output;
	}

	public function formatstatuses($value)
	{
		$value = (float) $value;
		$output = "";
		if ($value == 0) {
			$output = '<b style="color:green;">Active</b>';
		} elseif ($value == 1) {
			$output = '<b style="color:red;">Not Active</b>';
		} else {
			$output = "<b>N/A</b>";
		}
		return $output;
	}

	//Format Email
	public function formatUserEmail($value)
	{
		$output = str_replace("@gmail.com", "", $value);
		$output = str_replace("@yahoo.com", "", $output);
		$output = str_replace("@outlook.com", "", $output);
		return $output;
	}

	//Upload Image
	public function uploadImage($name, $uniquesavename, $destinationDir)
	{
		$uniquesavename = $this->addDash($uniquesavename) . "-" . time();
		$filename = $_FILES[$name]['name'];
		$location = $destinationDir . $filename;

		// Valid extension
		$valid_ext = array('png', 'jpeg', 'jpg');

		// file extension
		$file_extension = pathinfo($location, PATHINFO_EXTENSION);
		$file_extension = strtolower($file_extension);

		// Check extension
		if (in_array($file_extension, $valid_ext)) {
			$destFile = $uniquesavename . "." . $file_extension;
			$destFile2 = $uniquesavename . "-2." . $file_extension;
			$filename = $_FILES[$name]["tmp_name"];

			$sourceDir = pathinfo($filename, PATHINFO_DIRNAME);
			$sourceFile = pathinfo($filename, PATHINFO_BASENAME);

			$resizer = new \Grommet\ImageResizer\Resizer($sourceDir, $destinationDir);
			$newPath1 = $resizer->resize($sourceFile, $destFile, ['strategy' => 'fit', 'width' => 200]);
			$newPath2 = $resizer->resize($sourceFile, $destFile2, ['strategy' => 'fit', 'width' => 800]);
			$newPath1 = str_replace("\\", "/", $newPath1);
			$newPath2 = str_replace("\\", "/", $newPath2);
			$file = [$newPath1, $newPath2];
			return $file;
		} else {
			return 1;
		}
	}

	public function getConfigValue($list, $name)
	{
		foreach ($list as $item) {
			if ($item->name == $name) {
				return $item->value;
			}
		}
	}
}

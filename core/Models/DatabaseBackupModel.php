<?php

	class DatabaseBackupModel extends Model{

		public function dbconnect(){
			$connection=mysqli_connect(self::$host,self::$username,self::$password,self::$dbName);
			return $connection;
		}

		public function backupDatabase(){
	
		//Connect To MySQL Database 
		$connection=self::dbconnect();
		if(!$connection){ return "Could Not Start Backup, Unable To Connect To Database.";}
	    
		//Collect Database Tables
		$tables=array();
		
		$result=mysqli_query($connection,"SHOW TABLES");
		while($row=mysqli_fetch_row($result)){
			$tables[]=$row[0];
		}
		$dbname=self::$dbName;
		$return=self::getFileHead($tables,$dbname);
		
		foreach($tables as $table){
			$result=mysqli_query($connection,"SELECT * FROM ".$table);
			$num_fields=mysqli_num_fields($result);
			
			$return.="# --------------------------------------------------------\n";
			$return.="# Table Structure For {$table}\n";
			$return.="# --------------------------------------------------------\n\n";
			$return.="DROP TABLE IF EXISTS ".$table.';';
			$row2=mysqli_fetch_row(mysqli_query($connection,"SHOW CREATE TABLE ".$table));
			$return .="\n\n".$row2[1].";\n\n";
			
			$return.="# --------------------------------------------------------\n";
			$return.="# Dumping Data For {$table}\n";
			$return.="# --------------------------------------------------------\n\n";
				
			for($i=0;$i<$num_fields; $i++){
				
				while($row=mysqli_fetch_row($result)){
					
					$return.="INSERT INTO ".$table." VALUES(";
					
					for($j=0;$j<$num_fields;$j++){
						$row[$j]=addslashes($row[$j]);
						if(isset($row[$j])){$return .='"'.$row[$j].'"'; }
						else{$return .='""';}
						if($j<$num_fields-1){$return .=','; }
					}
					$return .=");\n";
				}
			}
			
			$return .= "\n\n\n";
		}
		
		//Save File To Directory After Creating SQL
		$filePath="../backup/";
		$fileName=date("d-M-Y")."_".$dbname.".sql";
		
		$handle=fopen($filePath.$fileName,"w+");
		fwrite($handle,$return);
		fclose($handle);
		
		$data = file_get_contents('../backup/dbbackup.json');
		$data = json_decode($data);

		//Store File Details In DB For Restoring
		$inputData = array();
		$inputData["fileName"]=$fileName;
		$inputData["filePath"]=$filePath.$fileName;
		
		if(!empty($data) && $data != NULL){
			//append the input to our array
			$data[] = $inputData;
			//encode back to json
			$data = json_encode($data);
			file_put_contents('../backup/dbbackup.json', $data);
		}
		else{
			//encode back to json
			$inputData = json_encode($inputData);
			$inputData='['.$inputData.']';
			file_put_contents('../backup/dbbackup.json', $inputData);
		}
		
		return "Database Backup Successfull";
		mysqli_close($connection);	

	}		



	public function restoreDatabase($fileName ){
		
		//Connect To MySQL Database 
		$connection=self::dbconnect();
		if(!$connection){ return "Could Not Start Backup, Unable To Connect To Database.";}
	   	
		//Retrive File
		$handle=fopen($fileName,"r+");
		$contents=fread($handle,filesize($fileName));
		$sql=explode(';',$contents);
		$dbname=self::$dbName;
		
		foreach($sql AS $query){
			$result=mysqli_query($connection,$query);
			if($result){
			//echo '<tr><td><br></td></tr>';
			//echo '<tr><td>'.$query.' <b>SUCCESS</b></td></tr>';
			//echo '<tr><td><br></td></tr>';
			}
		}
		fclose($handle);
		return $dbname . ' Database Successfully Restored';	
		mysqli_close($connection);	

	}


	public function uploadBackup(){
		$target_dir = "../backup/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
		
		//Check If File Already Exists
		if (file_exists($target_file)) {return "Sorry, Backup File Already Exists, Please Click On The Restore Button And Select The Backup File To Restore It."; }
		//Check File Extension
		if($fileType != "SQL" && $fileType != "sql") {return "Sorry, Unsupported File Format, You Can Only Upload An SQL Backup File.";}
		//Upload Backup File
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
		{
			$data = file_get_contents('../backup/dbbackup.json');
			$data = json_decode($data);
			$fileName=basename( $_FILES["fileToUpload"]["name"]);
			$filePath=$target_dir;
			
			//Store File Details In DB For Restoring
			$inputData = array();
			$inputData["fileName"]=$fileName;
			$inputData["filePath"]=$filePath.$fileName;
			
			if(!empty($data) && $data != NULL){
				//append the input to our array
				$data[] = $inputData;
				//encode back to json
				$data = json_encode($data);
				file_put_contents('../backup/dbbackup.json', $data);
			}
			else{
				//encode back to json
				$inputData = json_encode($inputData);
				$inputData='['.$inputData.']';
				file_put_contents('../backup/dbbackup.json', $inputData);
			}
			
			return "The Backup: ". basename( $_FILES["fileToUpload"]["name"]). " Has Been Uploaded. Click On The Restore Button To Restore The Backup."; 
		}
	    else {return "Sorry, there was an error uploading your file."; }
	}


	public function getFileHead($tables,$db){
		$sql_file = "# --------------------------------------------------------\n";
		$sql_file .= "# Database Backup \n";
		$sql_file .= "#\n";
		$sql_file .= "# Generated: " . date( 'l j. F Y H:i T' ) . "\n";
		$sql_file .= "# Database: " .$db. "\n";
		$sql_file .= "# --------------------------------------------------------\n";
		$sql_file .= "# Database Tables ----------------------------------------\n";
		$sql_file .= "# --------------------------------------------------------\n";
		    

		foreach($tables AS $table) {
			// Create the SQL statements
		    $sql_file .= "# Table: " . $table . "\n";
		}
		
		$sql_file .= "# --------------------------------------------------------\n\n";
		
		return $sql_file;
	}

	}

?>
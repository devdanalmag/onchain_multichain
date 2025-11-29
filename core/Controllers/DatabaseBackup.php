<?php

	class DatabaseBackup extends Controller{

		protected $model;

		public function __construct(){
			$this->model=new DatabaseBackupModel;
		}

		public function backupDatabase(){
			$data=$this->model->backupDatabase();
			$msg=self::createNotification1("alert-info","Database Backup In Progress, Please Wait.");
			$msg.=self::createNotification1("alert-info","$data");
			return $msg;
		}

		public function restoreDatabase($file){
			$data=$this->model->restoreDatabase($file);
			$msg=self::createNotification1("alert-info","Database Restore In Progress, Please Wait.");
			$msg.=self::createNotification1("alert-info","$data");
			return $msg;
		}

		public function uploadBackup(){
			$data=$this->model->uploadBackup();
			$msg=self::createNotification1("alert-info","Database Upload In Progress, Please Wait.");
			$msg.=self::createNotification1("alert-info","$data");
			return $msg;
		}

	}

?>
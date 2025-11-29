<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;


	class Model{

		public static $host="localhost";
		public static $dbName="onchainc_db"; //Database Name
		public static $username="onchainc_admin"; // Database Username
		public static $password="onchainc_admin"; //Database Password

        public static $dbh;
        
		public $emailUsername="support@onchain.com.ng"; //Support Email Address
		public $emailPassword="*OnchainMail2025#"; //Support Email Password

        public $sitename;

        public function __construct(){
            self::$dbh = self::connectDb();
            global $sitename;
			$this->sitename = $sitename;
        }
       
        public function connectDb(){
            $pdo = new PDO("mysql:host=".self::$host.";dbname=".self::$dbName,self::$username,self::$password);
	    	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    	return $pdo;
        }

		public static function connect(){
			return self::$dbh;
		}

		//Send Secure Email With SMTP
		public function sendMail($email,$subject,$message){
		    global $sitename;
	        //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

	        try {
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                    //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = $_SERVER['SERVER_NAME'];                //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = $this->emailUsername;                   //SMTP username
                $mail->Password   = $this->emailPassword;                   //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                //Recipients
                $mail->setFrom($this->emailUsername, $sitename);
                $mail->addAddress($email);     //Add a recipient
                
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = $message;
                $mail->AltBody = strip_tags($message);
            
                $mail->send();
                return 0;
                return 'Message has been sent';
            } catch (Exception $e) {
                return 1;
                return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
	    }

        //Get Api Config Values
        public function getConfigValue($list,$name){
			foreach($list AS $item){
				if($item->name == $name){return $item->value;}
			}
		}

        //Get API Setting
		public function getApiConfiguration(){
			$dbh=self::connect();
			$sql = "SELECT * FROM apiconfigs";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            return $results;
		}

        //Get Site Setting
		public function getSiteConfiguration(){
			$dbh=self::connect();
			$sql = "SELECT * FROM sitesettings WHERE sId=1";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results=$query->fetch(PDO::FETCH_OBJ);
            return $results;
		}

	    


	}

?>
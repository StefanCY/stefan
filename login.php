<?php
 		header("Content-type: text/html; charset=utf-8");
		$mail_or_phone=$_GET["user_phone"];
		$user_password = $_GET["user_password"];
		// $mail_or_phone='13983894160';
		// $user_password ='Aa123456789';
		$dsn = "mysql:host=localhost;dbname=zhihu";
		$del = new PDO($dsn, 'root', '');
		if(preg_match( "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i", $mail_or_phone ))//判断是否是邮箱
		{
			$sql = $del->prepare("select user_mail from user where user_mail = '$mail_or_phone'");	//SQL语句
			$sql->execute();	//执行SQL语句
			$num =$sql->rowCount();	//返回上一个由对应的 PDOStatement 
			// if(!$num)
			// 	{
			// 		echo "\nPDO::errorInfo():\n";
			// 		print_r($del->errorInfo());
			// 	}
			if($num)//如果存在用户
			{
				// $password="";
				// $sql_check=$del->prepare("select user_password from user where user_mail='$mail_or_phone'");
				// $sql_check->execute();
				// $sql_check->setFetchMode(PDO::FETCH_NUM);
				// while ($row = $sql_check->fetch()) 
				// {
   	// 				$password=$row[0];
  		// 		}
				$password="";
				$sql="select user_password from user where user_mail='$mail_or_phone";  
				foreach($del->query($sql) as $val)
				{  
    				$password=$val;
				}  
  				if($user_password==$password)
  				{
  					$data=array('state' =>0);
			 		echo json_encode($data);
  				}
  				else
  				{
  					$data=array('state' =>1);
			 		echo json_encode($data);
  				}

			}
			else//不存在用户
			{
				
				$data=array('state' =>2);
			 	echo json_encode($data);
			}
		}
		 else if(preg_match("/1[3458]{1}\d{9}$/",$mail_or_phone)) 
		{
			$sql = $del->prepare("select user_phone from user where user_mail = '$mail_or_phone'");	//SQL语句
			$sql->execute();	//执行SQL语句
			$num =$sql->rowCount();	//返回上一个由对应的 PDOStatement 
			if($num)//如果存在用户
			{
				// 
				$password="";
				$sql="select user_password from user where user_mail='$mail_or_phone";  
				foreach($del->query($sql) as $val)
				{  
    				$password=$val;
				}  
  				if($user_password==$password)
  				{
  					$data=array('state' =>0);
			 		echo json_encode($data);
  				}
  				else
  				{
  					$data=array('state' =>1);
			 		echo json_encode($data);
  				}

			}
			else//不存在用户
			{
				$data=array('state' =>2);
			 	echo json_encode($data);
			}
		}
		else
		{
			$data=array('state' =>3);
			echo json_encode($data);
		}
?>
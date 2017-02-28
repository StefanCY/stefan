<?php
		header("Content-type: text/html; charset=utf-8");
		$name = $_GET["user_name"];
		$password = $_GET["user_password"];
		$phone=$_GET["user_phone"];
		$dsn = "mysql:host=localhost;dbname=zhihu";
		$del = new PDO($dsn, 'root', '');
		$sql = $del->prepare("select user_name from user where user_name = '$name'");	//SQL语句
		$sql->execute();	//执行SQL语句
		$num =$sql->rowCount();	//返回上一个由对应的 PDOStatement 对象执行DELETE、 INSERT、或 UPDATE 语句受影响的行数
		if($num)	//如果已经存在该用户
		{
			 $data=array('result' =>2);
			 echo json_encode($data);
		}
		else	//不存在当前注册用户名称
		{
			$sql_check=$del->prepare("select user_phone from user where user_phone='$phone'");//查询是否有相同的PhoneNum
			$sql_check->execute();//执行SQL语句
			$num_check=$sql_check->rowCount();//返回上一个由对应的 PDOStatement 对象执行DELETE、 INSERT、或 UPDATE 语句受影响的行数
			if($num_check)//如果存在当前注册电话号码
			{
			 	$data=array('result' =>1);
			 	echo json_encode($data);
			}
			else//不存在当前注册电话号码
			{
				$sql_insert =$del->prepare("insert into user (user_phone,user_name,user_mail,user_password) values(:phone,:name,NULL,:password)") ;	
				$sql_insert->bindParam(':phone',$phone,PDO::PARAM_STR);
				$sql_insert->bindParam(':name',$name,PDO::PARAM_STR);
				$sql_insert->bindParam(':password',$password,PDO::PARAM_STR);
				$sql_insert->execute();
				// echo "\nPDOStatement::errorCode(): ";
				// print $sql_insert->errorCode();
				$num_insert = $sql_insert->rowCount();
				// if(!$num_insert)
				// {
				// 	echo "\nPDO::errorInfo():\n";
				// 	print_r($del->errorInfo());
				// }
			
			
				if($num_insert)
				{
					 $data= array('result' =>0);
					 echo json_encode($data);
				}
				else
				{
					$data=array('result' =>3);
					echo json_encode($data);
				}
			}
			
		}
?>
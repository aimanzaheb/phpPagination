<html>
<head>
</head>
<style>
	.active{
		background:yellow;
	}	
</style>
<body>
<?php
	$server="localhost";
	$un="root";
	$pass="";
	$dbname="pagination";
	$connection=@new mysqli($server,$un,$pass,$dbname);
	if($connection->connect_error)          // if any error occur, connect_error is a string variable otherwise NULL
			die("Connection failed: ".$connection->connect_error);
	
	
    //pagination
	$perpage=2;
	$page=isset($_GET['page']) ? $_GET['page'] : 1;
	$start=($page=='' || $page==1) ? 0 : ( ($page*$perpage)-$perpage );
	
	
	$sql="SELECT * FROM data ORDER BY id ASC LIMIT ".$start.",".$perpage;
	$data=$connection->query($sql);
	  //print_r($data->fetch_all());
	while($row=$data->fetch_assoc()){
		echo $row['alphabet'].'<br/>';
	}
    $sql="SELECT * FROM data"; //now selecting all records
    $data=$connection->query($sql);	
    $recordsNo=$data->num_rows;
    $records_pages=ceil($recordsNo/$perpage);
	
	//method 1
	/*
    if($records_pages>1 && $page<=$records_pages){
	   	if($page>1){
			$prev=$page-1;
			echo '<a href="?page='.$prev.'">Prev</a> ';
		}

		for($r=1; $r<=$records_pages;$r++){
			$active=$r==$page?'class="active"' : '';
			echo '<a href="?page='.$r.'"'.$active.'>'.$r.'</a> ';
		}
		
		if($page< $records_pages){
			$next=$page+1;
			echo '<a href="?page='.$next.'">Next</a> ';
		}
	} 
	*/

	//method 2 google like
	if($records_pages>1 && $page<=$records_pages) {
		//previous
		if($page>1){
			$prev=$page-1;
			echo '<a href="?page='.$prev.'">Prev</a> ';
		}	

		//backward printing
		if($page<3){
			for($r=1; $r<=$page;$r++){
				$active=$r==$page?'class="active"' : '';
				echo '<a href="?page='.$r.'"'.$active.'>'.$r.'</a> ';
			}	
		}
		else if($page == $records_pages && $page>3){   //for last page to show exactly 4 links if possible
			for($r = $page-3; $r<=$page;$r++){
				$active=$r==$page?'class="active"' : '';
				echo '<a href="?page='.$r.'"'.$active.'>'.$r.'</a> ';
			}	
		}
		else{
			for($r = $page-2; $r<=$page;$r++){
				$active=$r==$page?'class="active"' : '';
				echo '<a href="?page='.$r.'"'.$active.'>'.$r.'</a> ';
			}		
		}
		
		//forward printing
		if($page==1)
			$endOption = $page+3;
		else if($page==2)
			$endOption = $page+2;
		else 
			$endOption = $page+1;	
		$end= min($records_pages, $endOption);
		for($r =$page+1; $r<=$end;$r++){
			echo '<a href="?page='.$r.'">'.$r.'</a> ';
		}	
		if($page < ($records_pages-1) && $records_pages>4)
			echo '...<a href="?page='.$records_pages.'">'.$records_pages.'</a> ';

		//next	
		if($page< $records_pages){
			$next=$page+1;
			echo '<a href="?page='.$next.'">Next</a> ';
		}	
	}

	
?>	
</body>	
</html>	

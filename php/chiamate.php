<?php
header('Access-Control-Allow-Origin: *');
$con = mysqli_connect('localhost','projectalunnicalcaterra','','my_projectalunnicalcaterra');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
switch($_POST['type']){
		case 'telefoni':{
			$multi=1;
			}
			break;
		case 'tablet':{
			$multi=10;
			}
			break;
		case 'modem':{
			$multi=100;
			}
			break;
		case 'tv':{
			$multi=1000;
			}
			break;
		
	}
$quest = $_POST['quest'];
switch ($quest) {
//---------------------------------------DEVICES---------------------------------------------//
    case 'devices':
		$first_id=($_POST['page']-1)*4;
		$sql="SELECT * FROM ".$_POST['req']." WHERE id > '".($first_id)."' && id < '".($first_id+5)."'";
		$result = mysqli_query($con,$sql);
		while($row = mysqli_fetch_array($result)){
			echo '<div class="grid_3 device center">'.
				'<img class="device" src="images_devices/'.$row['immagine_front'].'"><br>'.
				'<h5>'.$row['nome'].'</h5>'
				.$row['prezzo'].'€<br>'
				.'<button data-type="'.$_POST['req'].'" data-id="'.$row['id'].'">Dettagli</button></div>';
		}
		$sql="SELECT COUNT(*) as numero FROM ".$_POST['req'];
		$result = mysqli_query($con,$sql);
		$row = mysqli_fetch_array($result);
		$tmp=$row['numero'];
		$inc=1;
		$stmp="";
		while($tmp>0){
			$tmp-=4;
			$stmp='<input type="button" value="'.$inc.'" class="page rightfloat">'.$stmp;
			$inc+=1;;
		}
		echo '<div class="grid_12">'.$stmp.'</div>';
		break;
//---------------------------------------DEVICE DETAILS--------------------------------------//		
	case 'devices_details':
		$sql="SELECT * FROM ".$_POST['type']." WHERE id = '".$_POST['devID']."'";
		$result = mysqli_query($con,$sql);
		$row = mysqli_fetch_array($result);
		echo 
		'<div class="grid_4 full">
		<div class="grid_12"><img class="device" src="images_devices/'.$row['immagine_front'].'"></div>';
		if($row['immagine_back']!=null)
			 echo'<div class="grid_4 full"><img class="device" src="images_devices/'.$row['immagine_back'].'"></div>';
		echo '<div class="grid_4 full"><img class="device mobile_hide" src="images_devices/'.$row['immagine_front'].'"></div>';
		if($row['immagine_side']!=null)
			echo '<div class="grid_4 full"><img class="device" src="images_devices/'.$row['immagine_side'].'"></div>';

		echo '</div>'
		.'<div class="grid_8">'
		.'<a class="rightfloat hand" id="back" data-goto="back">torna indietro</a>'
		.'<h2>'.$row['nome'].'</h2>'
		.'<div id="contenuto">'
		.'Caratteristiche:<br>'
		.$row['caratteristiche']
		.'<br><br>'
		.'<div class="grid_8">'
		.'<a class="hand" value="devices_features"><u>Maggiori caratteristiche</u></a><br>'
		.'<a class="hand" href="AvailableSLService.html">Smart Life Service disponibili</a><br>'
		.'<a class="hand" href="AvailableAssistanceService.html">Servizi di assistenza disponibili</a><br>'
		.'</div>'
		.'<div class="grid_4">'
		.'<h2>'.$row['prezzo'].'€</h2>'
		.'</div>'
		.'<img src="images/vantaggi_shopping_online.jpg">'
		.'</div>'
		.'</div>';
		break;
		

		
//---------------------------------------DEVICE_FEATURES-------------------------------------//		
	case 'devices_features':
		$sql="SELECT * FROM ".$_POST['type']." WHERE id = '".$_POST['devID']."'";
		$result = mysqli_query($con,$sql);
		$row = mysqli_fetch_array($result);
		echo $row['specifiche']."<br><br>"
		.'<a href="AvaiableAssisstanceService.html">Servizi di assistenza disponibili</a>
		<br><a href="AvaiableSLService.html">Smart Life Service Disponibili</a>
		<a class="hand rightfloat" value="device_details">Torna alla presentazione del Device</a>'
		;
		break;
    
//---------------------------------------ASSISTENZA-----------------------------------------//
	case 'assistenza':
        
		$sql="SELECT * FROM assistenza WHERE id_categoria='".$_POST['req']."'";
		$result = mysqli_query($con,$sql);
		$sotto_categoria="";
		echo "<div class='grid_3'>";
		while($row = mysqli_fetch_array($result)){
			if($sotto_categoria!=$row['sotto_categoria']||$sotto_categoria==""){
				if($sotto_categoria==""){
					$sotto_categoria=$row['sotto_categoria'];
					echo "<h2>".$sotto_categoria."</h2>";
				}else{
					$sotto_categoria=$row['sotto_categoria'];
					echo "</div><div class='grid_3'><h2>".$sotto_categoria."</h2>";
				}
			}
			if($gruppo!=$row['gruppo']&&($gruppo=$row['gruppo'])!="")
				echo "<br>".$gruppo."<br>";
			echo "&nbsp;&nbsp;&nbsp;<a href='#' class='assistance' value='".$row['id']."'>".$row['titolo']."</a><br>";
		}
		echo "</div>";
        break;
//---------------------------------------ASSISTANCE_DETAILS-------------------------------------//
		case 'assistance_details':
		$sql="SELECT * FROM assistenza WHERE id = '".$_POST['assID']."'";
		$result = mysqli_query($con,$sql);
		$row = mysqli_fetch_array($result);
			echo "<h2>".$row['titolo']."</h2><br>".$row['descrizione'];
			echo '<div class = "grid_12 center">
			<div class ="grid_6 center"><a class="hand" onclick="alert(\'Link Non Implementato\')">F.A.Q.</a></div>
			<div class ="grid_6 center"><a href="For_Devices_2.html">Device Compatibili</a></div>
			</div>';
		
		break;
    
//---------------------------------------SL_SERVICE--------------------------------------------//	
	case 'service':
		switch($_POST['req']){
			case 'tv':
				echo_tv();
				break;
			case 's_personali':
				echo_s_personali();
				break;
			case 'famiglia':
				echo_famiglia();
				break;
			case 'salute':
				echo_salute();
				break;
		}
        break;
		
//---------------------------------------SERVICE_DETAILS-------------------------------------//		
	case 'services_details':
		$sql="SELECT * FROM servizi WHERE id = '".$_POST['servID']."'";
		$result = mysqli_query($con,$sql);
		while($row = mysqli_fetch_array($result)){
			echo 
			'<div class="grid_12"><a class="rightfloat hand" id="back" data-goto="back">torna indietro</a></div>'.
			'<div class="grid_12 center"><img src="images_services/'.$row["immagine_head"].'"></div>
			<div class="grid_8" id="contenuto"><h1>Attivazione:</h1><br>
			'.$row["attivazione"].'
			</div>
			<div class="grid_2">&nbsp;</div>
			<div class="grid_2">
			<a class="hand" value="sl_features"><u>Maggiori caratteristiche</u></a><br>
			<a class="hand" href="For_Devices_1.html">Device compatibili</a><br>
			<div class="center"><h1>Disponibile per '.$row["prezzo"].'&nbsp;€</h1></div>
			</div>';	 
		}
		break;
//---------------------------------------SERVICE_DETAILS-------------------------------------//	
	case 'sl_features':
		$sql="SELECT * FROM servizi WHERE id = '".$_POST['servID']."'";
		$result = mysqli_query($con,$sql);
		$row = mysqli_fetch_array($result);
		echo "<h1>Caratteristiche</h1>".$row['caratteristiche'];
		break;
	
//------------------------------------HIGHLIGHTS------------------------------------------//
	case 'highlights':
		$sql="SELECT * FROM assistenza WHERE highlights=true";
		$result = mysqli_query($con,$sql);
		$sotto_categoria="";
		echo "<div class='grid_3'>";
		while($row = mysqli_fetch_array($result)){
			if($sotto_categoria!=$row['sotto_categoria']||$sotto_categoria==""){
				if($sotto_categoria==""){
					$sotto_categoria=$row['sotto_categoria'];
					echo "<h2>".$sotto_categoria."</h2>";
				}else{
					$sotto_categoria=$row['sotto_categoria'];
					echo "</div><div class='grid_3'><h2>".$sotto_categoria."</h2>";
				}
			}
			if($gruppo!=$row['gruppo']&&($gruppo=$row['gruppo'])!="")
				echo "<br>".$gruppo."<br>";
			echo "&nbsp;&nbsp;&nbsp;<a href='#' class='assistance' value='".$row['id']."'>".$row['titolo']."</a><br>";
		}
		echo "</div>";
        break;
		
//------------------------------------PROMOTIONS------------------------------------//
	case 'promozione':
		$sql="SELECT * FROM telefoni WHERE promozione=true";
		$result = mysqli_query($con,$sql);
		while($row = mysqli_fetch_array($result)){
			echo '<div class="grid_3 device center">'.
				'<img class="device" src="images_devices/'.$row['immagine_front'].'"><br>'.
				'<h5>'.$row['nome'].'</h5>'
				.$row['prezzo'].'€<br>'
				.'<button data-type="telefoni" data-id="'.$row['id'].'">Dettagli</button></div>';
		}
		$sql="SELECT * FROM tablet WHERE promozione=true";
		$result = mysqli_query($con,$sql);
		while($row = mysqli_fetch_array($result)){
			echo '<div class="grid_3 device center">'.
				'<img class="device" src="images_devices/'.$row['immagine_front'].'"><br>'.
				'<h5>'.$row['nome'].'</h5>'
				.$row['prezzo'].'€<br>'
				.'<button data-type="tablet" data-id="'.$row['id'].'">Dettagli</button></div>';
		}
		break;
	
//------------------------------------AVAILABLE SL_SERVICE------------------------------------//
	case 'available_SL':
		$sql="SELECT * FROM sl_for_devices join servizi on id_serv=id WHERE id_dev = ".($_POST['devID']*$multi);
		$result = mysqli_query($con,$sql);	
		if ($result->num_rows == 0){
				echo 'Non ci sono Servizi Smart Life per questo dispositivo';
		}else{
			while($row = mysqli_fetch_array($result)){
				echo '<div class="grid_3 center">'.
				'<img src="images/'.$row['copertina'].'"><br>'.
				'<h5>'.$row['nome'].'</h5>'
				.'<button data-type="'.$_POST['type'].'" data-id="'.$row['id_serv'].'">Dettagli</button></div>';
			}
		}
	break;

//------------------------------------AVAILABLE ASSISTANCE SERVICE------------------------------------//
	case 'available_AS':
		$sql="SELECT * FROM ass_for_devices join assistenza on id_ass=id WHERE id_dev = ".($_POST['devID']*$multi);
		$result = mysqli_query($con,$sql);
		if ($result->num_rows == 0){
				echo 'Non ci sono assistenze per questo dispositivo';
		}else{
		$sotto_categoria="";
		echo "<div class='grid_3'>";
		while($row = mysqli_fetch_array($result)){
			if($sotto_categoria!=$row['sotto_categoria']||$sotto_categoria==""){
				if($sotto_categoria==""){
					$sotto_categoria=$row['sotto_categoria'];
					echo "<h2>".$sotto_categoria."</h2>";
				}else{
					$sotto_categoria=$row['sotto_categoria'];
					echo "</div><div class='grid_3'><h2>".$sotto_categoria."</h2>";
				}
			}
			if($gruppo!=$row['gruppo']&&($gruppo=$row['gruppo'])!="")
				echo "<br>".$gruppo."<br>";
			echo "&nbsp;&nbsp;&nbsp;<a href='#' class='assistance' value='".$row['id_ass']."'>".$row['titolo']."</a><br>";
		}
		echo "</div>";
		}
        break;
//------------------------------------FOR DEVICES 1------------------------------------//
	case 'for_devices_1':
		$sql="SELECT * FROM sl_for_devices WHERE id_serv = '".$_POST['servID']."'";
		$result = mysqli_query($con,$sql);
		if ($result->num_rows == 0){
				echo 'Non ci sono dispositivi compatibili';
		}
		while($row = mysqli_fetch_array($result)){
		
			if($row['id_dev']<10){
				$type="telefoni";
				$sql2="SELECT * FROM ".$type." WHERE id = '".$row['id_dev']."'";
			}else if($row['id_dev']<100){
				$type="tablet";
				$sql2="SELECT * FROM ".$type." WHERE id = '".($row['id_dev']/10)."'";
			}else if($row['id_dev']<1000){
				$type="modem";
				$sql2="SELECT * FROM ".$type." WHERE id = '".($row['id_dev']/100)."'";
			}else if($row['id_dev']<10000){
				$type="tv";
				$sql2="SELECT * FROM ".$type." WHERE id = '".($row['id_dev']/1000)."'";
			}
			$result2=mysqli_query($con,$sql2);
			$row2=mysqli_fetch_array($result2);
			
			echo '<div class="grid_3 device center">'.
				'<img class="device" src="images_devices/'.$row2['immagine_front'].'"><br>'.
				'<h5>'.$row2['nome'].'</h5>'
				.$row2['prezzo'].'€<br>'
				.'<button data-type="'.$type.'" data-id="'.$row2['id'].'">Dettagli</button></div>';
		}
		break;
		
//------------------------------------FOR DEVICES 2------------------------------------//
	case 'for_devices_2':
		$sql="SELECT * FROM ass_for_devices WHERE id_ass = '".$_POST['assID']."'";
		$result = mysqli_query($con,$sql);
		if ($result->num_rows == 0){
				echo 'Non ci sono dispositivi compatibili';
		}
		while($row = mysqli_fetch_array($result)){
		
			if($row['id_dev']<10){
				$type="telefoni";
				$sql2="SELECT * FROM ".$type." WHERE id = '".$row['id_dev']."'";
			}else if($row['id_dev']<100){
				$type="tablet";
				$sql2="SELECT * FROM ".$type." WHERE id = '".($row['id_dev']/10)."'";
			}else if($row['id_dev']<1000){
				$type="modem";
				$sql2="SELECT * FROM ".$type." WHERE id = '".($row['id_dev']/100)."'";
			}else if($row['id_dev']<10000){
				$type="tv";
				$sql2="SELECT * FROM ".$type." WHERE id = '".($row['id_dev']/1000)."'";
			}
			$result2=mysqli_query($con,$sql2);
			$row2=mysqli_fetch_array($result2);
			
			echo '<div class="grid_3 device center">'.
				'<img class="device" src="images_devices/'.$row2['immagine_front'].'"><br>'.
				'<h5>'.$row2['nome'].'</h5>'
				.$row2['prezzo'].'€<br>'
				.'<button data-type="'.$type.'" data-id="'.$row2['id'].'">Dettagli</button></div>';
		}
		break;
}
//---------------------------------------ALTRO-------------------------------------//
mysqli_close($con);

function echo_tv(){
	echo '
	<div class="grid_1">&nbsp;</div>
      <div class="grid_10 center">
      	<div class="grid_6"><a href="#"><img class="middle" src="images/SL_1_1.png"></a><br><input data-id="0" type="button" value="Details"></div>
        <div class="grid_6"><a href="#"><img class="middle" src="images/SL_1_2.png"></a><br><input data-id="1" type="button" value="Details"></div>
        <div class="grid_4"><a href="#"><img class="middle" src="images/SL_1_3.png"></a><br><input data-id="2" type="button" value="Details"></div>
        <div class="grid_4"><a href="#"><img class="middle" src="images/SL_1_4.png"></a><br><input data-id="3" type="button" value="Details"></div>
        <div class="grid_4"><a href="#"><img class="middle" src="images/SL_1_5.png"></a><br><input data-id="4" type="button" value="Details"></div>
      </div>
     </div>';
}


function echo_s_personali(){
	echo '
	 <div class="grid_1">&nbsp;</div>
      <div class="grid_10 center">
 
        <div class="grid_6">
        	<a href="#"><img class="middle" src="images/SL_4_1.png"></a><br>Pagamenti<br><input data-id="-1" type="button" value="Details">
        </div>
        
		<div class="grid_6">
        	<a href="#"><img class="middle" src="images/SL_4_2.png"></a><br>Trasporti<br><input data-id="-1" type="button" value="Details">
        </div>';
}

function echo_famiglia(){
	echo '
	<div class="grid_1">&nbsp;</div>

      <div class="grid_10">
       
        <div class="grid_6 center">
        	<a href="#"><img class="middle" src="images/SL_3_1.png"></a><br>D-Link SmartHome<br><input data-id="-1"  type="button" value="Details">
        </div>
        
      	<div class="grid_6 center">
        	 <a href="#"><img class="middle" src="images/SL_3_2.png"></a><br>Philips Livingcolours Bloom<br><input data-id="-1" type="button" value="Details">
     		
        </div>';
}

function echo_salute(){
	echo '
	<div class="grid_1">&nbsp;</div>

      <div class="grid_10 center">
      	<div class="grid_6"><a href="#"><img class="middle" src="images/SL_2_1.png"><br></a>SAMSUNG Galaxy Gear S with sim<br><input data-id="-1" type="button" value="Details"></div>
      	<div class="grid_6"><a href="#"><img class="middle" src="images/SL_2_2.png"><br></a>Polar LOOP H7 HR<br> <input data-id="-1"  type="button" value="Details"></div>
      </div>
      <div class="grid_12 center">
      	<div class="grid_4"><a href="#"><img class="middle" src="images/SL_2_3.png"><br></a>POLAR HR<br> <input data-id="-1"  type="button" value="Details"></div>
      	<div class="grid_4"><a href="#"><img class="middle" src="images/SL_2_4.png"><br></a>IHealth HS5<br> <input data-id="-1"  type="button" value="Details"></div>
        <div class="grid_4"><a href="#"><img class="middle" src="images/SL_2_5.png"><br></a>SAMSUNG Galaxy Gear Fit<br> <input data-id="-1"  type="button" value="Details"></div>
      </div>';
}

?>
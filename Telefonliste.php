<?php

//-------------------------------MYSQL_CONNECT-------------------------------------------------------------------------------------------------------------------------------------------------         


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "website";

$conn = new mysqli ($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("Connection failed! Please check MYSQL OR XAMPP");
}
/*-------------------------------connection test---------------------------------------------------------------------------------------------------------------------------------------------
    echo "Connection successfully".'<br>'.'<br>';
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
$sql = "SELECT id, name, number FROM ".$dbname.".data ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        for($r=0; $r<$result->num_rows;$r++){
        $row = $result->fetch_assoc();
        $data_test[$r]['id']=$row['id'];
        $data_test[$r]['name']=$row['name'];
        $data_test[$r]['number']=$row['number'];
         }
    }else{
        echo "results 0"; 
    };
//-------------------------top table-------------------------------------------------------------------------------------------------------------------------------------------------         

define('FPDF_FONTPATH','C:/xampp/htdocs/Telefonliste/PDF/font'); 
require('fpdf.php');   

class PDF extends FPDF
{

  // Load data
  function LoadData()
  {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "website";
    
    $conn = new mysqli($servername,$username,$password);
        if ($conn->connect_error){
            die ("Connection failed".$conn->connect_error);
        }   
        $sql = "SELECT * FROM ".$dbname.".data ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            for($r=0; $r<$result->num_rows;$r++){
             $row = $result->fetch_assoc();
             $data_test[$r]['name']=$row['name'];
             $data_test[$r]['number']=$row['number'];


            }
        }
       $conn->close();
    return $data_test;
  }

//-------------------------Colored table------------------------------------------------------------------------------------------------------------------------------------------------ 
function FancyTable($header, $data)
{
    // Colors, line width and bold font
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0,0,0);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('Arial');
    // Header
    $w = array(60, 30, 120, 45);
   
    $this->Cell($w[0],15,"Vorwahl: +49 1234 5789-0",'TL',0,'L');
    $this->Cell($w[2],15,"Notfallarzt: Dr. Mustermann: +49 123456",'TR',0,'R'); 
    $this->Ln();
    $this->Cell($w[0],10,'Name',1,0,'C');
    $this->Cell($w[1],10,'Nummer',1,0,'C');
    $this->Cell($w[0],10,'Name',1,0,'C');
    $this->Cell($w[1],10,'Nummer',1,0,'C');
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(222,222,222);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $n=1;
    $grey=1;
    $amount=0;
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row["name"],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row["number"],'LR',0,'L',$fill);

        if($n>=2){
            $this->Ln();
            $n=1;
        }
        else{
          $n++;
        }

        if($grey>=2){
          $fill=!$fill;
          $grey=1;
        }else{
          $grey++;
        }
        $amount++;
        

    }
    // Closing line
    $Even= $amount % 2;
    if ($Even>=1){
    $this->Cell($w[0],6,"",'B',0,'RL',$fill);
    $this->Cell($w[1],6,"",'BRL',0,'RL',$fill);
    $this->Ln();
    $this->Cell($w[0],6,"",'T',0);
    $this->Cell($w[1],6,"",'T',0);
      if($grey=2){
          $fill=!$fill;
          $grey=1;
      }else{
          $g++;}
    } else {
    $this->Cell($w[0],6,"",'T',0,'RL');
    $this->Cell($w[1],6,"",'T',0,'RL');
    $this->Cell($w[0],6,"",'T',0,'RL');
    $this->Cell($w[1],6,"",'T',0,'RL');
      if($grey>=2){
        $fill=!$fill;
        $grey=1;
    }else{
        $grey++;}
    }

}
}


$pdf=new PDF();
$header=array('');
$data=$pdf->LoadData();
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->FancyTable($header,$data);
$pdf->Output();




function Head(){
  for($i=0;$i<count($header);$i++)
  $this->Ln();
  $this->Cell($w[0],15,"Vorwahl: +49 1234 5789-0",'TL',0,'L');
  $this->Cell($w[2],15,"Notfallarzt: Dr. Mustermann: +49 123456",'TR',0,'R'); 
  $this->Ln();
  $this->Cell($w[0],10,'Name',1,0,'C');
  $this->Cell($w[1],10,'Nummer',1,0,'C');
  $this->Cell($w[0],10,'Name',1,0,'C');
  $this->Cell($w[1],10,'Nummer',1,0,'C');
  $this->Ln();
}
?>

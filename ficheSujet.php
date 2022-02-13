
<?php
if(isset($_GET["id"]) && $_GET["id"]!=""){
    $id = $_GET["id"];



include("libs/fpdf.php");

include("config/db.php");
session_start();


if(isset($_SESSION['role']) && $_SESSION['role']!=""){





 $departement = $_SESSION['departement'];

    
   
 
class PDF extends FPDF
{
    

    function Header()
{
    
    // Arial bold 15
    
       
      

       $this->Image('static/images/logo.png',-10,0,230);
    // Line break
    $this->Ln(50);
}
     function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    
 $departement = $_SESSION['departement'];
    $this->Cell(0,10,utf8_decode("Département de ".$departement." Université 8 Mai 1945"),0,0,'C');
    $this->Ln(3);
    $this->Cell(0,10,utf8_decode('Avenue du 19 Mai 56, BP 401, Guelma, 24000, Algérie. Tél : 037200260,  Fax : (037) 20 72 68, Site Web: http://www.univ-guelma.dz  '),0,0,'C');
    
}

}
    $query = "SELECT * FROM `sujet` WHERE `id`=?";
    $sql = $pdo->prepare($query);
    $sql->execute([$id]);
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    $encadreurU = $result["encadreur"];
    $query2 = "SELECT * FROM `encadreur` WHERE `username`=?";
    $sql2 = $pdo->prepare($query2);
    $sql2->execute([$encadreurU]);
    $result2 = $sql2->fetch(PDO::FETCH_ASSOC);

        $pdf = new PDF();
    
        $pdf->AddPage();
       
        $pdf->SetFont('Arial','B',10);
  
        $pdf->Cell(80,0,"Encadreur : ".$result2["nom"]." ".$result2["prenom"],0,0,'l');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(150,0,"Sujet de : ".$result["niveau"],0,0,'C');
        $pdf->Ln(8);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(80,0,utf8_decode("Titre : ".$result["titre"]),0,0,'l');
        $pdf->Ln(8);
        $pdf->SetFont('Arial','B',10);
        $pdf->Write(10,"Description : ");
        $pdf->Ln(8);
        $pdf->SetFont('Arial','',10);
        $pdf->Write(10,utf8_decode($result["contenu"]));
        $pdf->Ln(8);
        $pdf->SetFont('Arial','B',10);
        $pdf->Write(10,utf8_decode("Mots Clés : ".utf8_decode($result["keywords"])));
        $pdf->Ln(8);
        $pdf->SetFont('Arial','B',10);
        $pdf->Write(10,utf8_decode("Environement : ".utf8_decode($result["environement"])));
        $pdf->Ln(8);
        $pdf->SetFont('Arial','B',10);
        $pdf->Write(10,utf8_decode("Bibliographie : ".utf8_decode($result["bibliographie"])));
     
       
    
        
    
    


//foter page
$pdf->AliasNbPages();

$pdf->Output("Fiche de sujet.pdf",'I');


}


 


}else{
    ?>
    <script>
        window.alert("Something Wrong .. ? ");
        document.location.href = "index.php";
    </script>
            <?php 
}


  


       



?>

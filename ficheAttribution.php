
<?php

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
    $this->SetFont('Arial','I',13);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(30,10,'REPUBLIC ALGERIENNE DEMOCRATIQUE ET POPULAIRE',0,0,'C');
      $this->Ln(16);
       $this->SetFont('Arial','I',10);
       $this->Cell(20);
     $this->Cell(30,10,"MINISTERE DE L'ENSEIGNEMENT",0,0,'C');
     $this->Ln(5);
      $this->Cell(20);
      $this->Cell(30,10,"SUPERIEURE ET DE LA RECHERCHE",0,0,'C');
       $this->Ln(5);
      $this->Cell(20);
      $this->Cell(30,10,"SCIENTIFIQUE",0,0,'C');
       $this->Ln(5);
      $this->Cell(20);
      $this->Cell(30,10,"UNIVERSITE 08 MAI 1945",0,0,'C');
        $this->Ln(5);
      $this->Cell(20);
      $this->Cell(30,10,"GUELMA",0,0,'C');
      
     $this->SetFont('Arial','B',10);
       $this->Ln(5);
      $this->Cell(20);
      
 $departement = $_SESSION['departement'];
       $this->Cell(150,15,utf8_decode("Département de ".$departement),0,0,'C');
       
      

       $this->Image('static/images/logo.png',-10,0,230);
    // Line break
    $this->Ln(20);
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
        $pdf = new PDF();
    
        $pdf->AddPage();
       
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(0,0,utf8_decode("Attribution de sujet de fin d'étude"),0,0,'C');
        $pdf->SetFont('Arial','B',14);
        $pdf->Ln(25);
        $pdf->Cell(60,0,"Niveau :",0,0,'C');
        $pdf->SetFont('Arial','',14);
        $pdf->Cell(80,0,$_SESSION["niveau"],0,0,'C');
        $pdf->Ln(15);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(80,0,utf8_decode("Nom et Prénom de(s) étudiant(s) :"),0,0,'l');
        
        
        $pdf->SetFont('Arial','',14);
        $query = "SELECT * FROM etudiant WHERE id_compte = ?";
        $sql = $pdo->prepare($query);
        if($sql->execute([$_SESSION["id"]])){
            while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $pdf->Ln(10);
                $nom = $row["nom"]." ".$row["prenom"];
                $pdf->Cell(80,0,utf8_decode($nom),0,0,'l');
            }
        }
        $encadreur = "";
        $theme = $_SESSION["theme"];
        $query = "SELECT * FROM `sujet` WHERE `titre`=?";
        $sql = $pdo->prepare($query);
        if($sql->execute([$theme])){
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $encadreur = $row["encadreur"];
        }
        $query = "SELECT * FROM `encadreur` WHERE `username`= ?";
        $sql = $pdo->prepare($query);
        if($sql->execute([$encadreur])){
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $encadreur = $row["nom"] ." ".$row["prenom"];
        }
        $pdf->Ln(10);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(80,0,utf8_decode("Nom et Prénom de l'encadreur :"),0,0,'l');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','',14);
        $pdf->Cell(80,0,utf8_decode($encadreur),0,0,'l');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','BU',14);
        $pdf->Cell(80,0,utf8_decode("Intitulé :"),0,0,'l');
        
        $pdf->SetFont('Arial','',14);
        $pdf->Cell(20,0,utf8_decode($theme),0,0,'C');
        $pdf->Ln(30);
        
        $pdf->Cell(80,0,utf8_decode("Date et signature de l'encadreur"),0,0,'l');
        $pdf->Cell(140,0,utf8_decode("Signature de l'étudiant"),0,0,'C');
        
    


//foter page
$pdf->AliasNbPages();

$pdf->Output("Fiche d'attribution.pdf",'I');




 
}else{
    ?>
    <script>
        window.alert("Something Wrong .. ? ");
        document.location.href = "index.php";
    </script>
            <?php 
}




  


       



?>

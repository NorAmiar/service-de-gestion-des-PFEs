
<?php

include("libs/fpdf.php");

include("config/db.php");
session_start();
if(isset($_SESSION['role']) && $_SESSION['role']=="admin"){
$id = $_GET["id"];
$query = "SELECT * FROM fiche_suivi WHERE id = ?";
$sql = $pdo->prepare($query);
$sql->execute([$id]);
$result = $sql->fetch(PDO::FETCH_ASSOC);
$date = $result["date"];
$idSujet = $result["id_sujet"];
$query2 = "SELECT * FROM sujet WHERE id = ?";
$sql2 = $pdo->prepare($query2);
$sql2->execute([$idSujet]);
$result2 = $sql2->fetch(PDO::FETCH_ASSOC);
$encadreur = $result2["encadreur"];
$titre = $result2["titre"];

$query3 = "SELECT * FROM encadreur WHERE username = ?";
$sql3 = $pdo->prepare($query3);
$sql3->execute([$encadreur]);
$result3 = $sql3->fetch(PDO::FETCH_ASSOC);
$encadreur = $result3["nom"]." ".$result3["prenom"];


$query4 = "SELECT * FROM compte_etudiants WHERE sujet = ?";
$sql4 = $pdo->prepare($query4);
$sql4->execute([$titre]);
$result4 = $sql4->fetch(PDO::FETCH_ASSOC);

$idCompte = $result4["idCompte"];

 $departement = $_SESSION['departement'];

    
   
 
class PDF extends FPDF
{
    

    function Header()
{
    
    // Arial bold 15
   
     $this->SetFont('Arial','B',10);
      $this->Cell(20);
      
 $departement = $_SESSION['departement'];
       $this->Cell(150,15,utf8_decode("Département de ".$departement),0,0,'C');
       
      

    // Line break
    $this->Ln(20);
}
function FancyTable($header, $data)
{
    // Colors, line width and bold font
    $this->SetFillColor(0,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Header
    $w = array(95, 95, 0, 0);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
     foreach($data as $row)
     {
         if($row[0]=="Autre remarques"){
            $this->Cell(50,40,$row[0],'LRB',0,'L');
            $this->Cell(140,40,$row[1],'LRB',0,'L');
            $this->Ln();
         }else{
            $this->Cell($w[0],6,$row[0],'LRB',0,'L');
            $this->Cell($w[1],6,$row[1],'LRB',0,'C');
            $this->Ln();
         }
        
        $fill = !$fill;
     }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
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
        $pdf->Cell(0,0,utf8_decode("Fiche de suivi du PFE établie par l'encadreur"),0,0,'C');
        $pdf->SetFont('Arial','B',14);
        $pdf->Ln(15);
        $pdf->Cell(40,0,"Encadreur : ".$encadreur,0,0,'l');
        $pdf->Cell(170,0,"Signature : ",0,0,'C');
        $pdf->Ln(10);
        $pdf->Cell(40,0,"Date : ".$date,0,0,'l');
        $pdf->Ln(10);
        $pdf->Cell(40,0,utf8_decode("Intitulé du PFE : ".$titre),0,0,'l');
        $pdf->Ln(10);
        $pdf->Cell(40,0,"Etudiant()s :",0,0,'l');
        
        $pdf->SetFont('Arial','',14);
        $query = "SELECT * FROM etudiant WHERE id_compte = ?";
        $sql = $pdo->prepare($query);
        if($sql->execute([$idCompte])){
            while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $pdf->Ln(10);
                $nom = $row["nom"]." ".$row["prenom"];
                $pdf->Cell(80,0,utf8_decode($nom),0,0,'l');
            }
        }
        $pdf->Ln(10);
        $header = array(utf8_decode("Modalités d'évaluation"), 'Avancement en pourcentage (%)');
        $data = null;
        $pdf->SetFont('Arial','',14);
        $data = [];
        $row = [utf8_decode("Compréhension du sujet"),$result["comp_sujet"]];
        array_push($data,$row);
        $row = [utf8_decode("Accomplissement de la partie état de l'art"),$result["etatArt"]];
        array_push($data,$row);
        
        $row = [utf8_decode("Qualités des solutions envisagées"),$result["solutions"]];
        array_push($data,$row);
        
        $row = [utf8_decode("Avancement dans la rédaction du mémoire"),$result["memoire"]];
        array_push($data,$row);
        
        $row = [utf8_decode("Réalisation de l'application"),$result["application"]];
        array_push($data,$row);
        
        $row = [utf8_decode("Présence"),$result["presence"]];
        array_push($data,$row);
        
        $row = [utf8_decode("Autre remarques"),$result["autre"]];
        array_push($data,$row);
        $pdf->FancyTable($header,$data);








    


//foter page
$pdf->AliasNbPages();

$pdf->Output("Fiche de suivi.pdf",'I');




 
    }else{
        ?>
        <script>
            window.alert("Something Wrong .. ? ");
            document.location.href = "index.php";
        </script>
                <?php 
    }


  


       



?>

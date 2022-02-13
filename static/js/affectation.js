var affected = new Array();
function affect_click() {

 // window.alert("in");
$.post( "../process/recuperer.php", function( data ) {
   //data est le resultat de sql de la table choix "tout les choix" les donnée vont etre ordonné par moyenne de bdd 
    affectation(data);
  });
  
   
}
function recivedata(data){
    var obj = JSON.parse(data); //parse le resultat de json a un objet (array)
 
    return obj; //return data in object
   
}
function affectation(data){
  var obj = recivedata(data);  //recevoir data

  
  var n = Object.keys(obj).length; //longeur de resultat
  //window.alert(JSON.stringify(obj));
  var i =0; //compteur
  var toDelete = new Array();
  affected.push([obj[0]['idCompte'],obj[0]['sujet']]); //push le premier choix vers un array que je vais l'utiliser pour confirmer les choix
  //window.alert(affected);
  for(i=0;i<n;i++){  //supprimer tt les choix qui ont choisi le meme sujet de 1 er choix qui est deja validé   
    if(obj[i]['sujet']==obj[0]['sujet'] || obj[i]['idCompte']==obj[0]["idCompte"]){  //tester si le meme etudiant
      toDelete.push(i);
    }
  }

  var n2 = toDelete.length;
  //window.alert(JSON.stringify(obj));

  for(var j =n2-1;j>=0;j--){
    obj.splice(toDelete[j],1); 
   // window.alert(JSON.stringify(obj));
  }

  //obj.splice(0,1); // supprmier le 1 er choix de array of data (obj)



  var x = affected.length; //longeur des choix validés
  var j = 0; // compteur
  

  if(Object.keys(obj).length>0){
    //si l'objet de data n'es pas vide : 
    data = JSON.stringify(obj); //converter le nouveau objet apres l'affectation du 1 er choix vers json
    affectation(data); // apeller la methode encore une fois pour affecter le next choix
  }else{
    //si le json de data est vide alorse on va faire une request POST pour affecter les sujets de l array affected et supprimer tout les choix de table choix  
    //push the affected array to db
    //window.alert(affected);
    $.post( "../process/updateChoix.php",{affected:affected}, function( da ) {
      //data est le resultat de sql de la table choix "tout les choix" les donnée vont etre ordonné par moyenne de bdd 
      window.alert("L'affectation est terminé");
     });
            


    
  }
  

}
<?php
use App\Models\justification;
use App\Models\nature_sanction;
use App\Models\absence;
use App\Models\filiere;
use App\Models\section;
use App\Models\role;
use App\Models\stagaire;
use App\Models\formateur;
use App\Models\module;
use App\Models\archive_stagaire;
use App\Models\abs_jstf_sanc;
use App\Models\retard;


 // insertion dan la table filiere

// $fil1=new filiere();
// $fil1->codeFiliere='dev';
// $fil1->nomFiliere='developement digital';
// $fil1->option='full stack';
// $fil1->typeFormation='initial';
// $fil1->niveau='2A';
// $fil1->duree=' 2ans';
// $fil1->save();

// $fil2=new filiere();
// $fil2->codeFiliere='dev';
// $fil2->nomFiliere='developement digital';
// $fil2->option='mobile';
// $fil2->typeFormation='initial';
// $fil2->niveau='2A';
// $fil2->duree=' 2ans';
// $fil2->save();

// $fil3=new filiere();
// $fil3->codeFiliere='R';
// $fil3->nomFiliere='reseau informatique';
// $fil3->option='CyberSecurite';
// $fil3->typeFormation='initial';
// $fil3->niveau='2A';
// $fil3->duree=' 2ans';
// $fil3->save();

//  //insertion dan la table section

// $sec1=new section();
// $sec1->codeSection='devFs201';
// $sec1->nomSection='developement full stack 201';
// $sec1->niveau='2A';
// $sec1->Annee=' 2023';

// $sec1=new section();
// $sec1->codeSection='devFs202';
// $sec1->nomSection='developement full stack 202';
// $sec1->Annee=' 2023';

// $sec2=new section();
// $sec2->codeSection='devFs203';
// $sec2->nomSection='developement full stack 203';
// $sec2->Annee=' 2023';

// $sec3=new section();
// $sec3->codeSection='devFs204';
// $sec3->nomSection='developement full stack 204';
// $sec3->Annee=' 2023';

// $fil1->Sections()->saveMany([$sec1,$sec2,$sec3]);



// // insetyion dans la table jjustification


//  $jstf1=new justification();
//  $jstf1->libelleJsf='C';
//  $jstf1->Save();

//  $jstf2=new justification();
//  $jstf2->libelleJsf='A';
//  $jstf2->Save();

//  $jstf3=new justification();
//  $jstf3->libelleJsf='M';
//  $jstf3->Save();


// // insetyion dans la table NATURE SANCTION

//  $mtf1=new nature_sanction();
//  $mtf1->libelleSanc='1er indecipline';
//  $mtf1->points_Reduits='1';
//  $mtf1->sanction='mise en garde';
//  $mtf1->autorite_decision='SG';
//  $mtf1->Save();

//  $mtf2=new nature_sanction();
//  $mtf2->libelleSanc='2eme indecipline';
//  $mtf2->points_Reduits='2';
//  $mtf2->sanction='avertisement';
//  $mtf2->autorite_decision='D';
//  $mtf2->Save();

//  $mtf3=new nature_sanction();
//  $mtf3->libelleSanc='3eme indecipline';
//  $mtf3->points_Reduits='3';
//  $mtf3->sanction='Blame';
//  $mtf3->autorite_decision='CD';
//  $mtf3->Save();

//  $mtf4=new nature_sanction();
//  $mtf4->libelleSanc='4eme indecipline';
//  $mtf4->points_Reduits='4';
//  $mtf4->sanction='exclusion 2 jours';
//  $mtf4->autorite_decision='CD';
//  $mtf4->Save();

//  $mtf5=new nature_sanction();
//  $mtf5->libelleSanc='5eme indecipline';
//  $mtf5->points_Reduits='5';
//  $mtf5->sanction='exclusion infinitive';
//  $mtf5->autorite_decision='CD';
//  $mtf5->Save();

// // insetyion dans la table role

// $role1=new role();
// $role1->libelle='Admin';
// $role1->save();

// $role2=new role();
// $role2->libelle='Assistance';
// $role2->save();

//   //insetyion dans la table stagaire

// $stg1=new stagaire();
// $stg1->nom='elkazdir';
// $stg1->prenom='kawtar';
// $stg1->genre='F';
// $stg1->email='kawtarelka@gmail.com';
// $stg1->tele='0909090909';
// $stg1->cin='bj9090';
// $stg1->adresse='roches noires';
// $stg1->dateNaissance='2003-02-25';
// $stg1->dateInscription=2021;
// $stg1->photo='stagaires/kawtar.jpg';
// $stg1->noteComportement = 5.0;    
// $stg1->noteAssiduite = '10.00';  
// // nullable  fields
// $stg1->anneeBac=2021;
// $stg1->moyenBac=14.92;
// $stg1->mentionBac='bien';

// $sec1=section::find(3);
// $sec1->Stagaires()->save($stg1);


// $stg2=new stagaire();
// $stg2->nom='harda';
// $stg2->prenom='salma';
// $stg2->genre='F';
// $stg2->email='harda@gmail.com';
// $stg2->tele='0909090908';
// $stg2->cin='bj9080';
// $stg2->adresse='hey mohhamadi';
// $stg2->dateNaissance='1994-03-01';
// $stg2->dateInscription=2021;
// $stg2->photo='stagaires/harda.jpg';
// $stg2->noteComportement = 5.0;    
// $stg2->noteAssiduite = '10.00';  
// // nullable  fields
// $stg2->anneeBac=2015;
// $stg2->moyenBac=14.00;
// $stg2->mentionBac='bien';

// $sec2=section::find(1);
// $sec2->Stagaires()->save($stg2);

// $stg3=new stagaire();
// $stg3->nom='hilali';
// $stg3->prenom='morad';
// $stg3->genre='H';
// $stg3->email='hilali@gmail.com';
// $stg3->tele='090909090';
// $stg3->cin='bj90970';
// $stg3->adresse='anassi';
// $stg3->dateNaissance='2004-11-17';
// $stg3->dateInscription=2021;
// $stg3->photo='stagaires/hilali.jpg';
// $stg3->noteComportement = 5.0;    
// $stg3->noteAssiduite = '10.00';  
// // nullable  fields
// $stg3->anneeBac=2021;
// $stg3->moyenBac=13.50;
// $stg3->mentionBac='bien';

// $sec3=section::find(2);
// $sec3->Stagaires()->save($stg3);


// //   //insetyion dans la table formateur

// $form1=new formateur();
// $form1->cin='bj2020';
// $form1->nom='Benkirane';
// $form1->prenom='Mohcine';
// $form1->photo='formateur/benkiran.jpg';
// $form1->email='benkiran.@gmail.com';
// $form1->tele='0660606060';
// $form1->adresse='adresse1';
// $form1->save();

// $form2=new formateur();
// $form2->cin='bj3030';
// $form2->nom='Essadik';
// $form2->prenom='monia';
// $form2->photo='formateur/essadik.jpg';
// $form2->email='essadik.@gmail.com';
// $form2->tele='0660606080';
// $form2->adresse='adresse2';
// $form2->save();


// $form3=new formateur();
// $form3->cin='bj1010';
// $form3->nom='el idrissi sabour';
// $form3->prenom='rabiaa';
// $form3->photo='formateur/sabour.jpg';
// $form3->email='sabour.@gmail.com';
// $form3->tele='0660608090';
// $form3->adresse='adresse3';
// $form3->save();


// $form4=new formateur();
// $form4->cin='bj4040';
// $form4->nom='el harrak hajri';
// $form4->prenom='hashem';
// $form4->photo='formateur/lherrak.jpg';
// $form4->email='lherrak.@gmail.com';
// $form4->tele='0660606030';
// $form4->adresse='adresse4';
// $form4->save();


// //   //insetyion dans la table module

// $mod1=new module();
// $mod1->libelleModule='react.js';
// $mod1->semestre='s3';
// $mod1->MH_total=120;
// $mod1->save();

// $mod2=new module();
// $mod2->libelleModule='cloud native';
// $mod2->semestre='s4';
// $mod2->MH_total=120;
// $mod2->save();

// $mod3=new module();
// $mod3->libelleModule='approche agile';
// $mod3->semestre='s3';
// $mod3->MH_total=90;
// $mod3->save();

// $mod4=new module();
// $mod4->libelleModule='NoSQL';
// $mod4->semestre='s1';
// $mod4->MH_total=90;
// $mod4->save();


// //   //insetyion dans la table archive stagaire

// $stgA1=new archive_stagaire();
// $stgA1->nom='hilali';
// $stgA1->prenom='morad';
// $stgA1->genre='H';
// $stgA1->email='hilali@gmail.com';
// $stgA1->tele='090909090';
// $stgA1->cin='bj90970';
// $stgA1->adresse='anassi';
// $stgA1->dateNaissance='2004-11-17';
// $stgA1->dateInscription=2021;
// $stgA1->photo='stagaires/hilali.jpg';
// $stgA1->noteComportement = 5.0;    
// $stgA1->noteAssiduite = '10.00';  
// // nullable  fields
// $stgA1->anneeBac=2021;
// $stgA1->moyenBac=13.50;
// $stgA1->mentionBac='bien';

// $sec3=section::find(2);
// $sec3->ArchiveStagaires()->save($stgA1);


// //   //insetyion dans la table archive filiere_module
// $fil=filiere::find(1);
// $fil->modules()->attach($mod1);

// //   //insetyion dans la table archive absence

// $abs1 = new Absence();
// $abs1->seance = 1;
// $abs1->type ='A';
// $abs1->typeSeance = 'P';
// $abs1->dateAbs = date('Y-m-d');
// $abs1->nbJoursJsf = 2;

// $abs1->stagaire_id = $stgA1->id;       // Assign the foreign key directly
// $abs1->formateur_id = $form1->id;  // Replace $stgA1 with the actual formateur instance
// $abs1->module_id = $mod1->id;        // Replace $stgA1 with the actual module instance

// $abs1->save();




// //   //insetyion dans la table archive abs_jstf_sancs

// $absenceJustificationNature = new abs_jstf_sanc();

// // // Set the foreign key values
// $absenceJustificationNature->absence_id = $abs1->id;
// $absenceJustificationNature->justification_id = $jstf1->id;
// $absenceJustificationNature->sanction_id = $mtf4->id;

// // Save the new instance
// $absenceJustificationNature->save();

// //   //insetyion dans la table archive retard

// $rtd1=new retard();
// $rtd1->seance = 1;
// $rtd1->typeSeance = 'P';
// $rtd1->dateRtd = date('Y-m-d');
// $rtd1->stagaire_id = $stgA1->id;       
// $rtd1->formateur_id = $form1->id; 
// $rtd1->module_id = $mod1->id;
// $rtd1->save();

// $rtd2=new retard();
// $rtd2->seance = 2;
// $rtd2->typeSeance = 'P';
// $rtd2->dateRtd = date('Y-m-d');
// $rtd2->stagaire_id = $stgA1->id;       
// $rtd2->formateur_id = $form1->id; 
// $rtd2->module_id = $mod1->id;
// $rtd2->save();

// $rtd3=new retard();
// $rtd3->seance = 3;
// $rtd3->typeSeance = 'P';
// $rtd3->dateRtd = date('Y-m-d');
// $rtd3->stagaire_id = $stgA1->id;       
// $rtd3->formateur_id = $form1->id; 
// $rtd3->module_id = $mod1->id;
// $rtd3->save();

// $rtd4=new retard();
// $rtd4->seance = 4;
// $rtd4->typeSeance = 'P';
// $rtd4->dateRtd = date('Y-m-d');
// $rtd4->stagaire_id = $stgA1->id;       
// $rtd4->formateur_id = $form1->id; 
// $rtd4->module_id = $mod1->id;
// $rtd4->save();




































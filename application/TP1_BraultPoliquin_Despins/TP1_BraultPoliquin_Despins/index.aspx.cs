using System;
using System.IO;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Web.Configuration;

namespace TP1_BraultPoliquin_Despins {

    public partial class index : System.Web.UI.Page
    {
       private string strRepertoire = null; //Variable locale pour l'affichage
     
       protected void Page_Load(object sender, EventArgs e)
       {

           strRepertoire = (string)Session["RepertoireActuel"];   //Récupération du répertoire de base préalablement défini dans la class.  
           lblMessage.Text = ""; //Vidange du label
          
       } //Fini

       protected void ouvrir(object sender, EventArgs e)
       {
       ///////////////////////////////////////////////////////////////////////////////
       //Lors d'un clic sur le nom d'un dossier ou fichier dans le listview         //
       //on affiche le nouveau répertoire ou on lance le téléchargement du fichier  //
       ///////////////////////////////////////////////////////////////////////////////
           lsFichier.EditIndex = -1;
           LinkButton TempLinkButton = (LinkButton)sender; //On récupère le lien LinkButton cliqué
           //Le CommandArgument est le chemin physique
           if (Directory.Exists(TempLinkButton.CommandArgument)) //On regarde si c'est un répertoire
               {
                   IconeVisible(true);
                   lsFichier.SelectedIndex = -1;
                   Session["RepertoireActuel"] = TempLinkButton.CommandArgument; //Mise a jour de la session
                   Session["Selection"] = null; //Vidage de la selection
                   lsArianne.DataBind(); //Mise a jour de la liste de fichier
                   lsFichier.DataBind(); //Mise a jour du fil d'Ariane
               } //Fin si dossier
           else if (File.Exists(TempLinkButton.CommandArgument)) //Si c'est un fichier
                {
                    //Copier coller de ton code Marc...
                    Response.Clear(); 
                    Response.ContentType = "application/octet-stream";
                    Response.AppendHeader("Content-Disposition", "attachment; filename=" + Server.UrlEncode(TempLinkButton.CommandArgument.Substring(TempLinkButton.CommandArgument.LastIndexOf("\\") + 1)));
                    Response.WriteFile(TempLinkButton.CommandArgument);
                    Response.End();
                }  //Fin si Dossier
       } //Fini

       protected void imgSupprimer_Click(object sender, ImageClickEventArgs e)
       {
        /////////////////////////////////////////////////////////////////
        //Au clic de l'icon Supprimer, pour te montrer une diversité,  //
        //nous déclanchons la methode Delete à l'exterieur du listview.//
        /////////////////////////////////////////////////////////////////
           if (Session["Selection"] != null && "".Equals(Session["Selection"]) == false)
           {    
               lsFichier.DeleteItem(lsFichier.SelectedIndex); //Déclanchement de la méthode
               System.Threading.Thread.Sleep(1000); //Sleep de 1 seconde pour laisser le temps de supprimer les fichiers et repertoires
               lsFichier.SelectedIndex = -1; //Déselection dans le listview
               lsFichier.DataBind(); //Mise a jour du listview
           }
           else
           {
               lblMessage.Text = "Vous devez faire une sélection...";
           }
       }  //Fini

       protected void lsFichier_SelectedIndexChanged(object sender, EventArgs e)
       {
        //////////////////////////////////////////////////////
        //Lorsqu'un clic est fait sur sélectionner on garde //
        //en mémoire la selection soit le chemin physique   //
        //////////////////////////////////////////////////////

           lblMessage.Text = ""; //Vidage label
           Session["Selection"] = lsFichier.SelectedValue.ToString(); //Mise a jour de la session
          }  //Fini

       protected void imgCouper_Click(object sender, ImageClickEventArgs e)
       {
        ////////////////////////////////////////////////////////////////////
        //Clic de l'icone Couper, on regarde si ya il y a une sélection,  //
        //ensuite si oui on la met en mémoire pour l'utiliser dans paste. //
        ////////////////////////////////////////////////////////////////////

           if (Session["Selection"] != null && "".Equals(Session["Selection"]) == false)
           {
               Session["Memoire"] = "Couper||" + (string)Session["Selection"]; //Création ou mise a jour de la session
               lblMessage.Text = "Memoire Couper"; //Confirmation visuel
           }  
           else
           {
               lblMessage.Text = "Vous devez faire une sélection...";
           }
       } //Fini

       protected void imgCopier_Click(object sender, ImageClickEventArgs e)
       {
        ////////////////////////////////////////////////////////////////////
        //Clic de l'icone Couper, on regarde si ya il y a une sélection,  //
        //ensuite si oui on la met en mémoire pour l'utiliser dans paste. //
        ////////////////////////////////////////////////////////////////////

           if (Session["Selection"] != null && "".Equals(Session["Selection"]) == false)
           {
               Session["Memoire"] = "Copier||" + (string)Session["Selection"]; //Création ou mise a jour de la session
               lblMessage.Text = "Memoire Copier"; //Confirmation visuel
           }
           else
           {
               lblMessage.Text = "Vous devez faire une sélection...";
           }
       } //Fini

       protected void imgColler_Click(object sender, ImageClickEventArgs e)
       {
        //////////////////////////////////////////////////////////////////////////////
        //Au clic de l'icone coller, on recupere la mémoire qui est une combine de  //
        //l'action, on vérifie si c'est couper ou copier, par la suite soit qu'on   //
        //déplace l'item ou qu'on le copy.                                          //
        //////////////////////////////////////////////////////////////////////////////
           if (Session["Memoire"] != null && "".Equals(Session["Memoire"]) == false) //On s'assure qu'une mémoire soit présente en premier
           { 
               string TempMemoire = (string)Session["Memoire"].ToString(); //Recupération de la mémoire, qui est l'url du repertorie ou fichier et l'action à faire
               string[] TempArrayMemoire = TempMemoire.Split(new string[] {"||"}, StringSplitOptions.None); //On split la mémoire, 0=Action(Couper/Coller), 1=url
               string TempRepertoireActuel = (string)Session["RepertoireActuel"]; //Repertoire a effectué l'action
               if (TempArrayMemoire[1] != TempRepertoireActuel + "\\" + TempArrayMemoire[1].Substring(TempArrayMemoire[1].LastIndexOf("\\"))) //Combinaison de l'url, comme path.combine...
               {
                   switch (TempArrayMemoire[0]) //Select case en fonction de l'action 
                   {
                       case "Couper": //Dans le cas de couper
                           if (Directory.Exists(TempArrayMemoire[1])) //Si c'est un repertoire
                           {
                               Directory.Move(TempArrayMemoire[1], TempRepertoireActuel + "\\" + TempArrayMemoire[1].Substring(TempArrayMemoire[1].LastIndexOf("\\"))); //Déplacement du repertorie
                               Session["Memoire"] = ""; //On vide la mémoire apres avoir effectué l'action
                           }
                           else if (File.Exists(TempArrayMemoire[1])) //Si c'est un fichier
                           {
                               File.Move(TempArrayMemoire[1], TempRepertoireActuel + "\\" + TempArrayMemoire[1].Substring(TempArrayMemoire[1].LastIndexOf("\\"))); //Déplacement du fichier
                               Session["Memoire"] = ""; //Vidage mémoire
                           }
                           break;
                       case "Copier": //Dans le cas de copier
                           if (Directory.Exists(TempArrayMemoire[1])) //Si repertoire
                           {
                               CopierDossierRecursif(TempArrayMemoire[1], TempRepertoireActuel + "\\" + TempArrayMemoire[1].Substring(TempArrayMemoire[1].LastIndexOf("\\"))); //Fonction récursive qui crée les répertoires et copies les fichiers un par un...
                               Session["Memoire"] = ""; //Vidage mémoire

                           }
                           else if (File.Exists(TempArrayMemoire[1])) //Si fichier
                           {
                               File.Copy(TempArrayMemoire[1], TempRepertoireActuel + "\\" + TempArrayMemoire[1].Substring(TempArrayMemoire[1].LastIndexOf("\\")), true); //Copie du fichier, overwrite dans le cas de doublons
                               Session["Memoire"] = ""; //Vidage mémoire
                           }
                           break; //Fin Select
                   }
                   lsFichier.DataBind(); //Mis a jour de listview
               }   
           }
           else
           {
               lblMessage.Text = "Vous devez couper ou copier en premier...";
           }
       }  //Fini

       private void CopierDossierRecursif(string _de, string _vers) 
        {
        ///////////////////////////////////////////////////////////////////////////
        //Fonction résursive qui explore chaque dossier, copie le nom du dossier //
        //vers le dossier de destination, par la suite, copie de chaque fichier  //
        //                                                                       //
        //Parametres :                                                           //
        //_de: Répertoire source                                                 //
        //_vers: Répertorie destination                                          //
        ///////////////////////////////////////////////////////////////////////////

            DirectoryInfo de = new DirectoryInfo(_de); //Dossier à copier
            DirectoryInfo vers = new DirectoryInfo(_vers); //Dossier destination
            
        if (Directory.Exists(vers.FullName) == false) //Si le répertoire n'existe pas il faut le créé manuellement
        {
            Directory.CreateDirectory(vers.FullName); //création du dossier
        }

        foreach (FileInfo TempFichier in de.GetFiles()) //Pour chaque fichier dans le dossier source
        {
             TempFichier.CopyTo(vers.ToString() + "\\" + TempFichier.Name, true); //On copie le fichier traité, overwrite les doublons
        }
 
        foreach (DirectoryInfo TempRep in de.GetDirectories()) //Pour chaque répertoire dans le dossier source
        {
            CopierDossierRecursif(TempRep.FullName, vers.CreateSubdirectory(TempRep.Name).ToString()); //Récursivé, pour chaque répertoire on fait appele a la fonction
        }
    } //Fini

       protected void imgTelecharger_Click(object sender, ImageClickEventArgs e)
       {
       ///////////////////////////////////////////////////////////////////////////
       //Au clic du bouton Télécharger, on s'assure qu'une sélection de fichier //
       //est faite ensuite on force le téléchargement du fichier                //
       ///////////////////////////////////////////////////////////////////////////

           if (Session["Selection"] != null && "".Equals(Session["Selection"]) == false) //Si une sélection est faite
           {
               string TempSelection = (string)Session["Selection"]; //Récupération  de la sélection
               if (File.Exists(TempSelection)) //Si c'est bien un fichier
               {
                   //Copier collé de ton code
                   Response.Clear();
                   Response.ContentType = "application/octet-stream";
                   Response.AppendHeader("Content-Disposition", "attachment; filename=" + Server.UrlEncode(TempSelection.Substring(TempSelection.LastIndexOf("\\")+1)));
                   Response.WriteFile(TempSelection);
                   Response.End();
                   Session["Selection"] = ""; //Viage sélection
               }
               else
               {
                   lblMessage.Text = "Vous ne pouvez que télécharger des fichiers...";
               }
           }
           else
           {
               lblMessage.Text = "Vous devez faire une sélection...";
           }
           
       }  //Fini

       protected void imgTeleverser_Click(object sender, ImageClickEventArgs e)
         {
        //////////////////////////////////////////////////////////////////////////
        //Au clic du bouton de télversement, il faut s'assurer premierement que //
        //le controle FileUpload ait été completé,  ensuite on upload le        //
        //vers le répertoire actuel                                             //
        //////////////////////////////////////////////////////////////////////////
             if (!string.IsNullOrEmpty(fuFichier.PostedFile.FileName))
             {
                 string repDest = (string)Session["RepertoireActuel"]; //Récupération répertoire actuel
                 string nomFichier = Path.GetFileName(fuFichier.PostedFile.FileName);  //Nom du fichier sélectionné localemement
                 string dest = repDest + "\\" + nomFichier; //Répertoire de destination en combinaison avec le nom du fichier
                 fuFichier.PostedFile.SaveAs(dest); //Sauvegarde du fichier dans le répertorie actuel
                 lsFichier.DataBind(); //Mise a jour du listview
                 
             }
             else
             {
                 lblMessage.Text = "Vous devez d'abord selectionner un fichier à téléverser";
             }
       } //Fini

       private void IconeVisible(bool Cacher)
       {
        //////////////////////////////////////////////////////////
        //En mode édition, on cache les icones, après l'édition //
        //nous devons les remettres visibles... pour se faire   //
        //on passe en parametre un bool qu'on affection a       //
        //la propriété visible                                  //
        //                                                      //
        //Parametre : Bool Cacher, etat de la propriété visible //
        //////////////////////////////////////////////////////////
           
           imgSupprimer.Visible = Cacher; //Les icones voulu...
           imgTelecharger.Visible = Cacher;
           imgCouper.Visible = Cacher;
           imgColler.Visible = Cacher;
           imgCopier.Visible = Cacher;
       }   //Fini

       protected void lsFichier_ItemCanceling(object sender, ListViewCancelEventArgs e)
       {
       //Event: si on cancel l'éditage, on remet visible les icones
           IconeVisible(true);
       } //Fini

       protected void lsFichier_ItemEditing(object sender, ListViewEditEventArgs e) 
       {
        //Event: entré en mode d'édition, cacher les icones
           IconeVisible(false);
       } //Fini

       protected void lsFichier_ItemUpdated(object sender, ListViewUpdatedEventArgs e)
       {
        //Event: une fois l'item édité, on remet les icones
           IconeVisible(true);
       } //Fini

       protected void deselectionner(object sender, EventArgs e)
       {
           /////////////////////////////////////////////////////////////////////////////////////
           //Lors d'un clic sur le bouton déselection on met a jour le listview et la session //
           /////////////////////////////////////////////////////////////////////////////////////
           if (Session["Selection"] != null && "".Equals(Session["Selection"]) == false)
           {
               lsFichier.SelectedIndex = -1;
               Session["Selection"] = "";
              }
           else
           {
               lblMessage.Text = "Vous devez faire une sélection...";
           }
       } //Fini

    }

}



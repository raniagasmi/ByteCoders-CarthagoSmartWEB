using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.ComponentModel;
using System.IO;
using System.Web.Configuration;
using System.Web.UI.WebControls;

    public class classGestion
    {

        public static List<classRepertoire> SelectionComplet()
        {
        //////////////////////////////////////////////////////////////////////////
        //ceci est la fonction selectMethod du objectDateSource (odsFichier du  //
        //listView des fichiers. on regarde si une session RepertoirActuel est  //
        //déclarer. Dans le cas negatif, on récupere le repertoire de base dans //
        //le web.config                                                         //
        //////////////////////////////////////////////////////////////////////////
              
              List<classRepertoire> ListeDuRepertoire = new List<classRepertoire>();

            string strRepertoireTemp = HttpContext.Current.Server.MapPath(WebConfigurationManager.AppSettings["RepertoireDeBase"].ToString()); //recuperation du repertoire de base dans le web.config
            //La variable strRepertoireTemp est la variable du repertoire visité
            if (HttpContext.Current.Session["RepertoireActuel"] == null || "".Equals(HttpContext.Current.Session["RepertoireActuel"]))  //Vérification si la session RepertoireActuel est déclaré
            {
                HttpContext.Current.Session["RepertoireActuel"] = strRepertoireTemp.Substring(0, strRepertoireTemp.Length - 1); //Si elle n'est pas déclarer, on garde le repertoire de base, mais Server.MapPath laisse un slash(/) a la fin qu'on retire
            }
            else
            {
                strRepertoireTemp = (string)HttpContext.Current.Session["RepertoireActuel"]; //Si la session est déclaré, overwrite la variable temporaire. Pas besoin de retirer le slash, il a deja été retiré
            }
        
            
            try
            {
                DirectoryInfo ReptertoireInfo = new DirectoryInfo(strRepertoireTemp); //DirectoryInfo du repertoire actuel
                if (strRepertoireTemp != HttpContext.Current.Server.MapPath("~").ToString().Substring(0, HttpContext.Current.Server.MapPath("~").ToString().Length - 1)) 
                { //Pour interdire de remonter plus haut que le répertoire de base, on compage le repertoire actuel avec celui de base. (Utilisation de server.MapPath donc on retranche le slash a la fin pour la comparaison
                //Si remonter est autorisé
                    string UrlRetour = strRepertoireTemp.Substring(0, strRepertoireTemp.LastIndexOf("\\"));  //On coupe d'un niveau l'url du repertoire actuel 
                    classRepertoire TempObjetRemonter = new classRepertoire("DossierRemonter", "..", UrlRetour, "", "", ""); //On crée un objet classRepertoire pour l'affichage dans le listview
                    ListeDuRepertoire.Add(TempObjetRemonter); //Premier objet ajouté a la liste

                }
                foreach (DirectoryInfo tempRepertoire in ReptertoireInfo.GetDirectories()) //Liste des dossiers du repertoire actuel
                {
                    string TempType = "Dossier";
                    string TempNom = tempRepertoire.Name;
                    string TempFullUrl = tempRepertoire.FullName;
                    string TempDateCreation = tempRepertoire.CreationTime.ToString();
                    string TempDateModification = tempRepertoire.LastAccessTime.ToString();
                    //Création d'un objet classRepertoire de type Dossier avec ses détails
                    classRepertoire TempObjetRepertoire = new classRepertoire(TempType, TempNom, TempFullUrl, TempDateCreation, TempDateModification, "");
                    ListeDuRepertoire.Add(TempObjetRepertoire); //Ajout a la liste 
                }

                foreach (FileInfo tempFichier in ReptertoireInfo.GetFiles())
                {
                    string TempType = "Fichier";
                    string TempNom = tempFichier.Name;
                    string TempFullUrl = tempFichier.FullName;
                    string TempDateCreation = tempFichier.CreationTime.ToString();
                    string TempDateModification = tempFichier.LastAccessTime.ToString();
                    string TempTaille = tempFichier.Length.ToString() + " octets";
                    //Meme principe
                    classRepertoire TempObjetRepertoire = new classRepertoire(TempType, TempNom, TempFullUrl, TempDateCreation, TempDateModification, TempTaille);
                    ListeDuRepertoire.Add(TempObjetRepertoire);
                }
            }
            catch (System.Exception ex)
            {
                string FouMoiLaPaixAvecTaVariableNonUtilise = ex.Message;
            }
          return ListeDuRepertoire; //Renvoie la liste au objectdatasource
        } //Fini

        public static List<classFilAriane> FilAriane()
        {
        ///////////////////////////////////////////////////////////////////////////////
        //SelectMethod du fil d'arianne, même principe de récupération du repertoire //
        //de base ou actuel dépendant,  ensuite on retourne une list                 //
        //Pour plus de commantaire lire function SelectionComplet                    //
        ///////////////////////////////////////////////////////////////////////////////
            List<string> ListFilAriane = new List<string>();
            string strRepertoireTemp = HttpContext.Current.Server.MapPath(WebConfigurationManager.AppSettings["RepertoireDeBase"].ToString()); //recuperation du repertoire de base dans le web.config
           
            if (HttpContext.Current.Session["RepertoireActuel"] == null || "".Equals(HttpContext.Current.Session["RepertoireActuel"]))
            {
                HttpContext.Current.Session["RepertoireActuel"] = strRepertoireTemp.Substring(0, strRepertoireTemp.Length - 1);
            }
            else
            {
                strRepertoireTemp = (string)HttpContext.Current.Session["RepertoireActuel"];
            }
        
            string strBase = HttpContext.Current.Server.MapPath("~").Substring(0, HttpContext.Current.Server.MapPath("~").Length -1);
            strBase = strBase.Substring(0, strBase.LastIndexOf("\\"));
            strRepertoireTemp = strRepertoireTemp.Replace(strBase, ""); //Tronquage du répertoire de base de l'url
            string[] strArrayRepertoire = strRepertoireTemp.Split(new string[] {"\\"}, StringSplitOptions.RemoveEmptyEntries); //On sépare le reste de l'url en fonction de chaque niveau
            string UrlTemp = strBase; //Url de base
            List<classFilAriane> ListeAriane = new List<classFilAriane>();
            
            foreach (string TempString in strArrayRepertoire)
            {
                UrlTemp = UrlTemp + "\\" + TempString; //Concaténation de l'url apres chaque niveau explorer
                classFilAriane TempFilAriane = new classFilAriane(TempString + " > ", UrlTemp);
                ListeAriane.Add(TempFilAriane);
            }
            return ListeAriane;
        } //Fini

        public  static void  Renommer(Element e) 
        {
            if(!String.IsNullOrEmpty(e.NomFichier)) //Si l'element 
            {
            if (Directory.Exists(e.FullUrl)) //Si c'est un repertoire
            {
                if (e.NomFichier.IndexOfAny(System.IO.Path.GetInvalidFileNameChars()) == -1) //Controle de l'entrer de donner
                {
                    string UrlFichier = e.FullUrl.Substring(0, e.FullUrl.LastIndexOf("\\"));  //Récupération du répertoire parent du fichier
                    if (Path.Combine(UrlFichier, e.NomFichier) != e.FullUrl) 
                    {
                        Directory.Move(e.FullUrl, Path.Combine(UrlFichier, e.NomFichier)); //Renommage
                    }
                }
            }
            else if(File.Exists(e.FullUrl)) 
            {
               
                    if (e.NomFichier.IndexOfAny(System.IO.Path.GetInvalidFileNameChars()) == -1)
                    {
                        string Extension = "";
                        string NewNom = "";
                        if (e.FullUrl.Substring(e.FullUrl.LastIndexOf("\\")).Contains(".")) //si l'ancien nom a une extension
                        {
                            Extension = e.FullUrl.Substring(e.FullUrl.LastIndexOf("."));  //Extension du fichier renommmer
                            NewNom = e.NomFichier.Replace(Extension, ""); //On retire l'extension
                        }
                        else
                        {
                            Extension = "";
                            NewNom = e.NomFichier; //pas d'extension a retirer
                        }
                        string UrlFichier = e.FullUrl.Substring(0, e.FullUrl.LastIndexOf("\\")); 
                        File.Move(e.FullUrl, Path.Combine(UrlFichier, NewNom + Extension));
                    }
                }
            }
        } //Fini

        public static void Supprimer(Element e)
        {
          string TempSelection = (string)HttpContext.Current.Session["Selection"]; //Récupération de la sélection
          if (Directory.Exists(TempSelection)) //Si répertoire
          {
              Directory.Delete(TempSelection, true); //Delete récursif du dossier sélectionné
              HttpContext.Current.Session["Selection"] = ""; 
          }
          else if (File.Exists(TempSelection))
          {
              File.Delete(TempSelection); //Delete du fichier
              HttpContext.Current.Session["Selection"] = "";
          }
        } //Fini
    }  

/////////////////////////////////////////////////////////////////////////////
//je ne croix qu'il est néccessaire de commenter les trois dernieres class //
/////////////////////////////////////////////////////////////////////////////

    public class classRepertoire
    {
        public string Type { get; set; }
        public string NomFichier { get; set; }
        public string FullUrl { get; set; }
        public string DateCreation { get; set; }
        public string DateModification { get; set; }
        public string Taille { get; set; }

        public classRepertoire(string _Type, string _NomFichier, string _FullUrl, string _DateCreation, string _DateModification, string _Taille)
        {
            Type = _Type;
            NomFichier = _NomFichier;
            FullUrl = _FullUrl;
            DateCreation = _DateCreation;
            DateModification = _DateModification;
            Taille = _Taille;
        }
    }

    public class Element
    {
        public string NomFichier { get; set; }
        public string FullUrl { get; set; }
   
        public Element() { }

        public Element(string Nom, string Url)
        {
            NomFichier = Nom;
            FullUrl = Url;
          
        }
    }

    public class classFilAriane
    {
        public string Nom { get; set; }
        public string Url { get; set; }

        public classFilAriane(string _Nom, string _URL)
        {
            Nom = _Nom;
            Url = _URL;
        }
    }

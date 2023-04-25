Gestionnaire de fichier sur le serveur d'application----------------------------------------------------
Url     : http://codes-sources.commentcamarche.net/source/54785-gestionnaire-de-fichier-sur-le-serveur-d-applicationAuteur  : irclandDate    : 05/08/2013
Licence :
=========

Ce document intitulé « Gestionnaire de fichier sur le serveur d'application » issu de CommentCaMarche
(codes-sources.commentcamarche.net) est mis à disposition sous les termes de
la licence Creative Commons. Vous pouvez copier, modifier des copies de cette
source, dans les conditions fixées par la licence, tant que cette note
apparaît clairement.

Description :
=============

Le but du travail est de d&eacute;velopper une application servant &agrave; fair
e la gestion des fichiers sur le
<br />serveur d&#8217;application.
<br />
<b
r /> Fonctionnalit&eacute;s de l&#8217;application
<br />
<br />   L'applicati
on sera constitu&eacute;e de 2 ListView :
<br />     - Une liste de fichiers
<
br />     - Un fil d&#8217;Ariane
<br />
<br />   Au lancement de l&#8217;appl
ication, le dossier de base est lu dans le fichier de configuration. Le fil
<br
 />d&#8217;Ariane affiche le dossier actif (qui est le dossier de base pour le m
oment) et la liste de fichiers
<br />affiche le contenu du dossier actif.
<br 
/>
<br />Fil d&#8217;Ariane :
<br />   Cette liste affiche le chemin d&#8217;a
cc&egrave;s du dossier actif &agrave; partir du dossier de base des fichiers. Un

<br />clic sur un des dossiers affich&eacute;s actualise la liste de fichiers 
(et le fil d&#8217;Ariane).
<br />
<br />Liste de fichiers:
<br />   Cette li
ste affiche les fichiers et dossiers contenus dans le dossier actif. Pour chaque
 &eacute;l&eacute;ment
<br />   (fichier ou dossier), vous devez afficher les i
nformations suivantes :
<br />      - Une ic&ocirc;ne indiquant s&#8217;il s&#8
217;agit d&#8217;un fichier ou d&#8217;un dossier.
<br />      - Le nom de l&#8
217;&eacute;l&eacute;ment, la date de cr&eacute;ation, la date de modification e
t la taille (dans le cas d&#8217;un
<br />        fichier).
<br />      - Une 
ic&ocirc;ne de suppression. La suppression doit &ecirc;tre confirm&eacute;e par 
l&#8217;utilisateur.
<br />      - Une ic&ocirc;ne de t&eacute;l&eacute;chargem
ent, dans le cas d&#8217;un fichier.
<br />      - Une ic&ocirc;ne &laquo; coup
er &raquo;. Au clic de cette ic&ocirc;ne, le chemin d&#8217;acc&egrave;s de l&#8
217;&eacute;l&eacute;ment est conserv&eacute;.
<br />      - Une ic&ocirc;ne po
ur renommer l&#8217;&eacute;l&eacute;ment. Au clic sur cette ic&ocirc;ne, le nom
 de l&#8217;&eacute;l&eacute;ment appara&icirc;t dans
<br />        une zone de
 texte et les ic&ocirc;nes de suppression, t&eacute;l&eacute;chargement, changem
ent de dossier et
<br />        &laquo; couper &raquo; sont masqu&eacute;es. De
ux ic&ocirc;nes (accepter et annuler) permettent de compl&eacute;ter
<br />    
    l&#8217;op&eacute;ration.
<br />
<br />    La liste permet aussi le t&eacu
te;l&eacute;versement dans le dossier actif.
<br />    
<br />    En fin, la l
iste offre l&#8217;op&eacute;ration &laquo; coller &raquo; lorsque le contexte l
e permet.
<br /><a name='source-exemple'></a><h2> Source / Exemple : </h2>
<b
r /><pre class='code' data-mode='basic'>
using System;
using System.Collection
s.Generic;
using System.Linq;
using System.Web;
using System.ComponentModel;

using System.IO;
using System.Web.Configuration;
using System.Web.UI.WebContr
ols;

    public class classGestion
    {

        public static List&lt;cl
assRepertoire&gt; SelectionComplet()
        {
        ///////////////////////
///////////////////////////////////////////////////
        //ceci est la fonct
ion selectMethod du objectDateSource (odsFichier du  //
        //listView des 
fichiers. on regarde si une session RepertoirActuel est  //
        //déclarer.
 Dans le cas negatif, on récupere le repertoire de base dans //
        //le we
b.config                                                         //
        ///
///////////////////////////////////////////////////////////////////////
       
       
              List&lt;classRepertoire&gt; ListeDuRepertoire = new List&
lt;classRepertoire&gt;();

            string strRepertoireTemp = HttpContext.
Current.Server.MapPath(WebConfigurationManager.AppSettings[&quot;RepertoireDeBas
e&quot;].ToString()); //recuperation du repertoire de base dans le web.config
 
           //La variable strRepertoireTemp est la variable du repertoire visité

            if (HttpContext.Current.Session[&quot;RepertoireActuel&quot;] == nu
ll || &quot;&quot;.Equals(HttpContext.Current.Session[&quot;RepertoireActuel&quo
t;]))  //Vérification si la session RepertoireActuel est déclaré
            {

                HttpContext.Current.Session[&quot;RepertoireActuel&quot;] = str
RepertoireTemp.Substring(0, strRepertoireTemp.Length - 1); //Si elle n'est pas d
éclarer, on garde le repertoire de base, mais Server.MapPath laisse un slash(/) 
a la fin qu'on retire
            }
            else
            {
         
       strRepertoireTemp = (string)HttpContext.Current.Session[&quot;RepertoireA
ctuel&quot;]; //Si la session est déclaré, overwrite la variable temporaire. Pas
 besoin de retirer le slash, il a deja été retiré
            }
        
    
        
            try
            {
                DirectoryInfo Repterto
ireInfo = new DirectoryInfo(strRepertoireTemp); //DirectoryInfo du repertoire ac
tuel
                if (strRepertoireTemp != HttpContext.Current.Server.MapPat
h(&quot;~&quot;).ToString().Substring(0, HttpContext.Current.Server.MapPath(&quo
t;~&quot;).ToString().Length - 1)) 
                { //Pour interdire de remon
ter plus haut que le répertoire de base, on compage le repertoire actuel avec ce
lui de base. (Utilisation de server.MapPath donc on retranche le slash a la fin 
pour la comparaison
                //Si remonter est autorisé
               
     string UrlRetour = strRepertoireTemp.Substring(0, strRepertoireTemp.LastInd
exOf(&quot;\\&quot;));  //On coupe d'un niveau l'url du repertoire actuel 
    
                classRepertoire TempObjetRemonter = new classRepertoire(&quot;Do
ssierRemonter&quot;, &quot;..&quot;, UrlRetour, &quot;&quot;, &quot;&quot;, &quo
t;&quot;); //On crée un objet classRepertoire pour l'affichage dans le listview

                    ListeDuRepertoire.Add(TempObjetRemonter); //Premier objet a
jouté a la liste

                }
                foreach (DirectoryInfo te
mpRepertoire in ReptertoireInfo.GetDirectories()) //Liste des dossiers du repert
oire actuel
                {
                    string TempType = &quot;Doss
ier&quot;;
                    string TempNom = tempRepertoire.Name;
         
           string TempFullUrl = tempRepertoire.FullName;
                    st
ring TempDateCreation = tempRepertoire.CreationTime.ToString();
               
     string TempDateModification = tempRepertoire.LastAccessTime.ToString();
  
                  //Création d'un objet classRepertoire de type Dossier avec ses
 détails
                    classRepertoire TempObjetRepertoire = new classRep
ertoire(TempType, TempNom, TempFullUrl, TempDateCreation, TempDateModification, 
&quot;&quot;);
                    ListeDuRepertoire.Add(TempObjetRepertoire); 
//Ajout a la liste 
                }

                foreach (FileInfo temp
Fichier in ReptertoireInfo.GetFiles())
                {
                    s
tring TempType = &quot;Fichier&quot;;
                    string TempNom = temp
Fichier.Name;
                    string TempFullUrl = tempFichier.FullName;
 
                   string TempDateCreation = tempFichier.CreationTime.ToString()
;
                    string TempDateModification = tempFichier.LastAccessTime.
ToString();
                    string TempTaille = tempFichier.Length.ToString
() + &quot; octets&quot;;
                    //Meme principe
                
    classRepertoire TempObjetRepertoire = new classRepertoire(TempType, TempNom,
 TempFullUrl, TempDateCreation, TempDateModification, TempTaille);
            
        ListeDuRepertoire.Add(TempObjetRepertoire);
                }
        
    }
            catch (System.Exception ex)
            {
                s
tring FouMoiLaPaixAvecTaVariableNonUtilise = ex.Message;
            }
       
   return ListeDuRepertoire; //Renvoie la liste au objectdatasource
        } /
/Fini

        public static List&lt;classFilAriane&gt; FilAriane()
        {

        //////////////////////////////////////////////////////////////////////
/////////
        //SelectMethod du fil d'arianne, même principe de récupératio
n du repertoire //
        //de base ou actuel dépendant,  ensuite on retourne 
une list                 //
        //Pour plus de commantaire lire function Se
lectionComplet                    //
        //////////////////////////////////
/////////////////////////////////////////////
            List&lt;string&gt; Li
stFilAriane = new List&lt;string&gt;();
            string strRepertoireTemp = 
HttpContext.Current.Server.MapPath(WebConfigurationManager.AppSettings[&quot;Rep
ertoireDeBase&quot;].ToString()); //recuperation du repertoire de base dans le w
eb.config
           
            if (HttpContext.Current.Session[&quot;Repert
oireActuel&quot;] == null || &quot;&quot;.Equals(HttpContext.Current.Session[&qu
ot;RepertoireActuel&quot;]))
            {
                HttpContext.Current
.Session[&quot;RepertoireActuel&quot;] = strRepertoireTemp.Substring(0, strReper
toireTemp.Length - 1);
            }
            else
            {
        
        strRepertoireTemp = (string)HttpContext.Current.Session[&quot;Repertoire
Actuel&quot;];
            }
        
            string strBase = HttpContex
t.Current.Server.MapPath(&quot;~&quot;).Substring(0, HttpContext.Current.Server.
MapPath(&quot;~&quot;).Length -1);
            strBase = strBase.Substring(0, s
trBase.LastIndexOf(&quot;\\&quot;));
            strRepertoireTemp = strReperto
ireTemp.Replace(strBase, &quot;&quot;); //Tronquage du répertoire de base de l'u
rl
            string[] strArrayRepertoire = strRepertoireTemp.Split(new string
[] {&quot;\\&quot;}, StringSplitOptions.RemoveEmptyEntries); //On sépare le rest
e de l'url en fonction de chaque niveau
            string UrlTemp = strBase; /
/Url de base
            List&lt;classFilAriane&gt; ListeAriane = new List&lt;c
lassFilAriane&gt;();
            
            foreach (string TempString in st
rArrayRepertoire)
            {
                UrlTemp = UrlTemp + &quot;\\&q
uot; + TempString; //Concaténation de l'url apres chaque niveau explorer
      
          classFilAriane TempFilAriane = new classFilAriane(TempString + &quot; 
&gt; &quot;, UrlTemp);
                ListeAriane.Add(TempFilAriane);
       
     }
            return ListeAriane;
        } //Fini

        public  sta
tic void  Renommer(Element e) 
        {
            if(!String.IsNullOrEmpty(
e.NomFichier)) //Si l'element 
            {
            if (Directory.Exists(
e.FullUrl)) //Si c'est un repertoire
            {
                if (e.NomFi
chier.IndexOfAny(System.IO.Path.GetInvalidFileNameChars()) == -1) //Controle de 
l'entrer de donner
                {
                    string UrlFichier = e
.FullUrl.Substring(0, e.FullUrl.LastIndexOf(&quot;\\&quot;));  //Récupération du
 répertoire parent du fichier
                    if (Path.Combine(UrlFichier, 
e.NomFichier) != e.FullUrl) 
                    {
                        Dir
ectory.Move(e.FullUrl, Path.Combine(UrlFichier, e.NomFichier)); //Renommage
   
                 }
                }
            }
            else if(File.E
xists(e.FullUrl)) 
            {
               
                    if (e.No
mFichier.IndexOfAny(System.IO.Path.GetInvalidFileNameChars()) == -1)
          
          {
                        string Extension = &quot;&quot;;
         
               string NewNom = &quot;&quot;;
                        if (e.Full
Url.Substring(e.FullUrl.LastIndexOf(&quot;\\&quot;)).Contains(&quot;.&quot;)) //
si l'ancien nom a une extension
                        {
                    
        Extension = e.FullUrl.Substring(e.FullUrl.LastIndexOf(&quot;.&quot;));  
//Extension du fichier renommmer
                            NewNom = e.NomFich
ier.Replace(Extension, &quot;&quot;); //On retire l'extension
                 
       }
                        else
                        {
             
               Extension = &quot;&quot;;
                            NewNom = e
.NomFichier; //pas d'extension a retirer
                        }
           
             string UrlFichier = e.FullUrl.Substring(0, e.FullUrl.LastIndexOf(&q
uot;\\&quot;)); 
                        File.Move(e.FullUrl, Path.Combine(UrlF
ichier, NewNom + Extension));
                    }
                }
       
     }
        } //Fini

        public static void Supprimer(Element e)
   
     {
          string TempSelection = (string)HttpContext.Current.Session[&qu
ot;Selection&quot;]; //Récupération de la sélection
          if (Directory.Exi
sts(TempSelection)) //Si répertoire
          {
              Directory.Delete
(TempSelection, true); //Delete récursif du dossier sélectionné
              H
ttpContext.Current.Session[&quot;Selection&quot;] = &quot;&quot;; 
          }

          else if (File.Exists(TempSelection))
          {
              File
.Delete(TempSelection); //Delete du fichier
              HttpContext.Current.S
ession[&quot;Selection&quot;] = &quot;&quot;;
          }
        } //Fini
  
  }  

///////////////////////////////////////////////////////////////////////
//////
//je ne croix qu'il est néccessaire de commenter les trois dernieres cla
ss //
/////////////////////////////////////////////////////////////////////////
////

    public class classRepertoire
    {
        public string Type { ge
t; set; }
        public string NomFichier { get; set; }
        public string
 FullUrl { get; set; }
        public string DateCreation { get; set; }
      
  public string DateModification { get; set; }
        public string Taille { g
et; set; }

        public classRepertoire(string _Type, string _NomFichier, s
tring _FullUrl, string _DateCreation, string _DateModification, string _Taille)

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
        public string NomFichie
r { get; set; }
        public string FullUrl { get; set; }
   
        publi
c Element() { }

        public Element(string Nom, string Url)
        {
  
          NomFichier = Nom;
            FullUrl = Url;
          
        }

    }

    public class classFilAriane
    {
        public string Nom { get
; set; }
        public string Url { get; set; }

        public classFilAria
ne(string _Nom, string _URL)
        {
            Nom = _Nom;
            Ur
l = _URL;
        }
    }
</pre>
<br /><a name='conclusion'></a><h2> Conclus
ion : </h2>
<br />C'est un exemple de construction d'un objectdatasource &agra
ve; partir d'un classe, ca peut etre pratique pour ca...

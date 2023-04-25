<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="index.aspx.cs" Inherits="TP1_BraultPoliquin_Despins.index" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title>Exploration de repertoire</title>
    <style type="text/css">
  #rounded-corner
{
    /* Le code CSS n'est pas de nous, mais orginaire de http://coding.smashingmagazine.com/2008/08/13/top-10-css-table-designs */
    margin-left: auto;
    margin-right: auto;
    margin-top: 15px;
    margin-bottom: 25px;
	font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
	font-size: 12px;
	text-align: left;
	border-collapse: collapse;
}
#rounded-corner thead th.rounded-company
{
	background: #b9c9fe url('images/left.png') left -1px no-repeat;
}
#rounded-corner thead th.rounded-q4
{
	background: #b9c9fe url('images/right.png') right -1px no-repeat;
}
#rounded-corner th
{
	padding: 8px;
	font-weight: normal;
	font-size: 13px;
	color: #039;
	background: #b9c9fe;
}
#rounded-corner td
{
	padding: 8px;
	background: #e8edff;
	border-top: 1px solid #fff;
	color: #669;
}
#rounded-corner tfoot td.rounded-foot-left
{
	background: #e8edff url('images/botleft.png') left bottom no-repeat;
}
#rounded-corner tfoot td.rounded-foot-right
{
	background: #e8edff url('images/botright.png') right bottom no-repeat;
}
#rounded-corner tbody tr:hover td
{
	background: #d0dafd;
}</style>
</head>
<body style="background-color:#E6E6E6;" >
    <form id="form1" runat="server"  style="width:80%; margin-left: auto; margin-right: auto; background-color: White; margin-top: -20px; padding-top: 0px; padding-bottom: 15px;background-image: url(intrHeader_2.jpg); background-repeat: repeat-x;"> 
      ·<p style="float:right;padding-top: 100px; margin-right:15px;"><asp:Label ID="Label8" runat="server" Text="Televerser un fichier "></asp:Label>
         <asp:FileUpload ID="fuFichier" runat="server" />  &nbsp;
         
         <asp:ImageButton 
               ID="imgTeleverser" runat="server" 
            ImageUrl="~/images/file_upload-32.png" ToolTip="Téléverser" 
               onclick="imgTeleverser_Click"/></p>
      <h1 style="padding-top: 100px; font-family: Algerian; padding-left: 15px; float:left;">Exploration de repertoire</h1><div style="clear:both"></div>
      <p style="float: right; margin-right: 15px; padding-top: 15px;">
    <asp:ImageButton ID="imgSupprimer" runat="server" ImageUrl="~/images/Cross-32.png" 
            ToolTip="Supprimer" onclick="imgSupprimer_Click"  
            OnClientClick="return confirm('Êtes-vous sûre de vouloir supprimer la sélection ?')" 
            Width="32px" />
        <asp:ImageButton ID="imgTelecharger" runat="server" 
            ImageUrl="~/images/file_download-32.png" ToolTip="Télécharger" 
            onclick="imgTelecharger_Click" />
        
        <asp:ImageButton ID="imgCouper" runat="server" ImageUrl="~/images/Cut-32.png" 
            ToolTip="Couper" onclick="imgCouper_Click" />
        <asp:ImageButton ID="imgCopier" runat="server" ImageUrl="~/images/File Copy-32.png" 
                ValidationGroup="Copier" onclick="imgCopier_Click" />
        <asp:ImageButton ID="imgColler" runat="server" ImageUrl="~/images/editpaste-32.png" 
                ValidationGroup="Coller" onclick="imgColler_Click"   OnClientClick="return confirm('Attention, overwrite des fichiers en cas de doublons, voulez-vous poursuivre ?')" />
        
        </p>
        
    <p align="center" style="padding-top: 10px;">
        <asp:Label ID="lblMessage" runat="server" Text="Label"></asp:Label>
    </p>
   

    <asp:ObjectDataSource ID="odsFichier" runat="server" 
    SelectMethod="SelectionComplet" TypeName="classGestion" 
        UpdateMethod="Renommer" DeleteMethod="Supprimer" 
          DataObjectTypeName="Element" >
        
                   
</asp:ObjectDataSource>

    <asp:ObjectDataSource ID="odsArianne" runat="server" SelectMethod="FilAriane" 
          TypeName="classGestion"></asp:ObjectDataSource>

    <asp:ListView ID="lsArianne"  runat="server" DataSourceID="odsArianne">
        <AlternatingItemTemplate>
            <td runat="server" style="background-color: #FAFAD2;color: #284775;">
                <asp:LinkButton ID="LinkButton1"  CommandArgument='<%# Eval("Url") %>' ToolTip='<%# Eval("Url") %>' onclick="ouvrir" runat="server"><%# Eval("Nom") %></asp:LinkButton>
                <br />
            </td>
        </AlternatingItemTemplate>
        <EmptyDataTemplate>
            <table style="background-color: #FFFFFF;border-collapse: collapse;border-color: #999999;border-style:none;border-width:1px;">
                <tr>
                    <td>
                       Aucune donnée retounée</td>
                </tr>
            </table>
        </EmptyDataTemplate>
        <ItemTemplate>
            <td runat="server" style="background-color: #FFFBD6;color: #333333; ">
                <asp:LinkButton ID="LinkButton1" CommandArgument='<%# Eval("Url") %>'  ToolTip='<%# Eval("Url") %>' onclick="ouvrir" runat="server"><%# Eval("Nom") %></asp:LinkButton>

                
                <br />
            </td>
        </ItemTemplate>
        <LayoutTemplate>
            <table runat="server" border="1" cellpadding="15"
                style="background-color: #FFFFFF;border-collapse: collapse;border-color: #999999;border-style:none;border-width:1px;font-family: Verdana, Arial, Helvetica, sans-serif; margin-left: 25px;">
                <tr  ID="itemPlaceholderContainer" runat="server">
                    <td ID="itemPlaceholder" runat="server">
                    </td>
                </tr>
            </table>
            <div style="text-align: center;background-color: #FFCC66;font-family: Verdana, Arial, Helvetica, sans-serif;color: #333333;">
            </div>
        </LayoutTemplate>
        <SelectedItemTemplate>
            <td runat="server" 
                style="background-color: #FFCC66;font-weight: bold;color: #000080;">
                <asp:LinkButton ID="LinkButton1" CommandArgument='<%# Eval("Url") %>' ToolTip='<%# Eval("Url") %>' onclick="ouvrir" runat="server"><%# Eval("Nom") %></asp:LinkButton>
    
                <br />
            </td>
        </SelectedItemTemplate>
    </asp:ListView>

    <asp:ListView ID="lsFichier" runat="server" 
        DataSourceID="odsFichier" 
        onselectedindexchanged="lsFichier_SelectedIndexChanged"
        DataKeyNames="FullUrl" onitemcanceling="lsFichier_ItemCanceling" 
        onitemediting="lsFichier_ItemEditing" onitemupdated="lsFichier_ItemUpdated" >

<LayoutTemplate>   
    <table id="rounded-corner"  class="listViewTable" width="98%"
        cellpadding="5" rules="all" border="1" >
        <thead>
            <tr >
                <th scope="col" class="rounded-company" style="width: 40%;">Nom</th>
                <th scope="col">Date Creation</th>
                <th scope="col">Date Modification</th>
                <th scope="col">Taille</th>
                <th scope="col" class="rounded-q4">Actions</th>

            </tr>
        </thead>
        <tbody>
            <tr id="itemPlaceholder" runat="server"></tr>
        </tbody>
    </table>
</LayoutTemplate>
<ItemTemplate>
    <tr>
        <td scope="row" class="rowHeading">
            <asp:Image ID="Image1" runat="server" ToolTip='<%# Eval("FullUrl") %>' ImageUrl='<%# "~/images/" + Eval("Type") + ".png" %>' />
            <asp:LinkButton ID="LinkButton1"  CommandArgument='<%# Eval("FullUrl") %>' ToolTip='<%# Eval("FullUrl") %>' onclick="ouvrir" runat="server"><%# Eval("NomFichier") %></asp:LinkButton>
        </td>
        <td>
            <asp:Label ID="Label1" runat="server" 
                Text='<%# Eval("DateCreation") %>' >
            </asp:Label>
        </td>
        <td>
            <asp:Label ID="Label2" runat="server" 
                Text='<%# Eval("DateModification") %>' >
            </asp:Label>
        </td>
        <td>
            <asp:Label ID="Label3" runat="server" 
                Text='<%# Eval("Taille") %>' >
            </asp:Label>
        </td>
        <td>
              <asp:Button ID="btnSelectionner" CommandName="Select" Visible='<%# (Eval("Type") != "DossierRemonter") %>' runat="server" ToolTip='<%# Eval("FullUrl") %>' Text="Selectionner" />
                  <asp:ImageButton ID="imgRenommer" runat="server" ImageUrl="~/images/Rename-32.png" ToolTip='Renommer' Visible='<%# (Eval("Type") != "DossierRemonter") %>' CommandName="Edit" />
   
            </td>

    </tr>
</ItemTemplate>
<EditItemTemplate>
    <tr>
        <td scope="row" class="rowHeading">
            <asp:Image ID="Image1" runat="server" ToolTip='<%# Eval("FullUrl")  %>' ImageUrl='<%# "~/images" + Eval("Type") + ".png" %>' />
            <asp:TextBox ID="txtRenommer" ToolTip='<%# Eval("FullUrl") %>' Text='<%# Bind("NomFichier") %>'   runat="server"></asp:TextBox>
        </td>
        <td>
            <asp:Label ID="Label1" runat="server" 
                Text='<%# Eval("DateCreation") %>' >
            </asp:Label>
        </td>
        <td>
            <asp:Label ID="Label2" runat="server" 
                Text='<%# Eval("DateModification") %>' >
            </asp:Label>
        </td>
        <td>
            <asp:Label ID="Label3" runat="server" 
                Text='<%# Eval("Taille") %>' >
            </asp:Label>
        </td>
        <td>
            <asp:ImageButton ID="ImageButton4"  runat="server" ImageUrl="~/images/Checkmark-32.png" CommandName="Update" />
            <asp:ImageButton ID="ImageButton3" runat="server" ImageUrl="~/images/Cross-32.png" CommandName="Cancel" />
       
             </td>

    </tr>
</EditItemTemplate>
<EmptyDataTemplate>
            <asp:Label ID="NoElementsLabel" runat="server" 
                Text="Aucune donnée retournée">
            </asp:Label>
        </EmptyDataTemplate>
<SelectedItemTemplate>
          <tr>
        <td style="background:Silver" scope="row" class="rowHeading">
            <asp:Image ID="Image1" runat="server" ToolTip='<%# Eval("FullUrl") %>' ImageUrl='<%# "~/images/" + Eval("Type") + ".png" %>' />
            <asp:LinkButton ID="LinkButton1" CommandArgument='<%# Eval("FullUrl") %>'  ToolTip='<%# Eval("FullUrl") %>' onclick="ouvrir" runat="server"><%# Eval("NomFichier") %></asp:LinkButton>
        </td>
        <td style="background:Silver" >
            <asp:Label ID="Label1" runat="server" 
                Text='<%# Eval("DateCreation") %>' >
            </asp:Label>
        </td>
        <td style="background:Silver" >
            <asp:Label ID="Label2" runat="server" 
                Text='<%# Eval("DateModification") %>' >
            </asp:Label>
        </td>
        <td style="background:Silver" >
            <asp:Label ID="Label3" runat="server" 
                Text='<%# Eval("Taille") %>' >
            </asp:Label>
        </td>
        <td style="background:Silver" >
               <asp:Button ID="btnDeselectionner" OnClick="deselectionner" Visible='<%# (Eval("Type") != "DossierRemonter") %>' runat="server" ToolTip='<%# Eval("FullUrl") %>' Text="Désélectionner" />
        
                       <asp:ImageButton ID="imgRenommer" runat="server" ImageUrl="~/images/Rename-32.png" ToolTip='Renommer' Visible='<%# (Eval("Type") != "DossierRemonter") %>' CommandName="Edit" />
              </td>

    </tr>
        </SelectedItemTemplate>
    </asp:ListView>
    
      
   
 
    </form>
          <p align="center" style="float: inherit; width: 200px; margin-left:auto; margin-right: auto; ">Une création de :<br />
              Brault-Poliquin, Éric<br />
              Despins, Marc-André</p>
 
</body>
</html>

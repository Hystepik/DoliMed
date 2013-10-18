<?php
/* Copyright (C) 2010-2011 Regis Houssin       <regis@dolibarr.fr>
 * Copyright (C) 2011      Laurent Destailleur <eldy@users.sourceforge.net>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 * or see http://www.gnu.org/
 */

$soc=$GLOBALS['object'];

global $db,$conf,$mysoc,$langs,$user;

require_once(DOL_DOCUMENT_ROOT ."/core/class/html.formcompany.class.php");
require_once(DOL_DOCUMENT_ROOT ."/core/class/html.formfile.class.php");
require_once(DOL_DOCUMENT_ROOT ."/core/lib/date.lib.php");
dol_include_once("/cabinetmed/lib/cabinetmed.lib.php");

$form=new Form($GLOBALS['db']);
$formcompany=new FormCompany($GLOBALS['db']);
$formadmin=new FormAdmin($GLOBALS['db']);
$formfile=new FormFile($GLOBALS['db']);
?>

<!-- BEGIN PHP TEMPLATE CARD_VIEW.TPL.PHP PATIENT -->

<?php

$head = societe_prepare_head($soc);
$now=dol_now();

/*foreach($head as $key => $val)
{
	var_dump($val);
}*/

//dol_fiche_head($head, 'tabpatientcard', $langs->trans("Patient"),0,'company');
dol_fiche_head($head, 'card', $langs->trans("Patient"),0,'company');

dol_htmloutput_errors($error,$errors);


// Confirm delete third party
if ($action == 'delete' || ($conf->use_javascript_ajax && empty($conf->dol_use_jmobile)))
{
    $ret=$form->form_confirm($_SERVER["PHP_SELF"]."?socid=".$soc->id,$langs->trans("DeleteACompany"),$langs->trans("ConfirmDeleteCompany"),"confirm_delete",'',0,"action-delete");
    if ($ret == 'html') print '<br>';
}

dol_htmloutput_errors($GLOBALS['error'],$GLOBALS['errors']);

print '<table class="border" width="100%">';

// Name
print '<tr><td width="20%">'.$langs->trans('PatientName').'</td>';
print '<td colspan="3">';
print $form->showrefnav($soc,'socid','',($user->societe_id?0:1),'rowid','nom');
print '</td></tr>';

if (! empty($conf->global->SOCIETE_USEPREFIX))  // Old not used prefix field
{
    print '<tr><td>'.$langs->trans('Prefix').'</td><td colspan="3">'.$soc->prefix_comm.'</td></tr>';
}

if ($soc->client)
{
    print '<tr><td>';
    print $langs->trans('PatientCode').'</td><td colspan="3">';
    print $soc->code_client;
    if ($soc->check_codeclient() <> 0) print ' <font class="error">('.$langs->trans("WrongPatientCode").')</font>';
    print '</td></tr>';
}

// Barcode
if ($conf->global->MAIN_MODULE_BARCODE)
{
    print '<tr><td>'.$langs->trans('Gencod').'</td><td colspan="3">'.$soc->barcode.'</td></tr>';
}

// Address
print "<tr><td valign=\"top\">".$langs->trans('Address')."</td><td colspan=\"3\">";
dol_print_address($soc->address,'gmap','thirdparty',$soc->id);
print "</td></tr>";

print '<tr><td width="25%">'.$langs->trans('Zip').'</td><td width="25%">'.$soc->zip."</td>";
print '<td width="25%">'.$langs->trans('Town').'</td><td width="25%">'.$soc->town."</td></tr>";

// Country
print '<tr><td>'.$langs->trans("Country").'</td><td colspan="3" nowrap="nowrap">';
$img=picto_from_langcode($soc->country_code);
if ($soc->isInEEC()) print $form->textwithpicto(($img?$img.' ':'').$soc->country,$langs->trans("CountryIsInEEC"),1,0);
else print ($img?$img.' ':'').$soc->country;
print '</td></tr>';

// State
if (empty($conf->global->SOCIETE_DISABLE_STATE)) print '<tr><td>'.$langs->trans('State').'</td><td colspan="3">'.$soc->state.'</td>';

print '<tr><td>'.$langs->trans('PhonePerso').'</td><td>'.dol_print_phone($soc->phone,$soc->country_code,0,$soc->id,'AC_TEL').'</td>';
print '<td>'.$langs->trans('PhoneMobile').'</td><td>'.dol_print_phone($soc->fax,$soc->country_code,0,$soc->id,'AC_FAX').'</td></tr>';

// EMail
print '<tr><td>'.$langs->trans('EMail').'</td><td colspan="3">';
print dol_print_email($soc->email,0,$soc->id,'AC_EMAIL');
print '</td>';

// Size
$profid=$langs->trans('Size');
print '<tr><td>'.$profid.'</td><td>';
print $soc->idprof1;
print '</td>';
// Weight
$profid=$langs->trans('Weight');
print '<td>'.$profid.'</td><td>';
print $soc->idprof2;
print '</td></tr>';

// Birthday
$profid=$langs->trans('DateToBirth');
print '<tr><td>'.$profid.'</td><td colspan="3">';
print $soc->idprof3;
if ($soc->idprof3)
{
    print ' &nbsp; ';
    $birthdatearray=dol_cm_strptime($soc->idprof3,$conf->format_date_short);
    $birthdate=dol_mktime(0,0,0,$birthdatearray['tm_mon']+1,($birthdatearray['tm_mday']),($birthdatearray['tm_year']+1900),true);
    //var_dump($birthdatearray);
    $ageyear=convertSecondToTime($now-$birthdate,'year')-1970;
    $agemonth=convertSecondToTime($now-$birthdate,'month')-1;
    if ($ageyear >= 2) print '('.$ageyear.' '.$langs->trans("DurationYears").')';
    else if ($agemonth >= 2) print '('.$agemonth.' '.$langs->trans("DurationMonths").')';
    else print '('.$agemonth.' '.$langs->trans("DurationMonth").')';
}
print '</td>';
print '</tr>';

// Juridical status = Secteur activité
print '<tr><td>'.$langs->trans('ActivityBranch').'</td><td>'.$soc->forme_juridique.'</td>';
// Profession
$profid=$langs->trans('Profession');
print '<td>'.$profid.'</td><td>';
print $soc->idprof4;
print '</td></tr>';
print '</tr>';

// Type + Staff
$arr = $formcompany->typent_array(1);
$soc->typent= $arr[$soc->typent_code];
print '<tr><td>'.$langs->trans("Gender").'</td><td colspan="3">'.$soc->typent.'</td>';
//print '<td>'.$langs->trans("Staff").'</td><td>'.$soc->effectif.'</td>';
print '</tr>';

// Default language
if ($conf->global->MAIN_MULTILANGS)
{
    require_once(DOL_DOCUMENT_ROOT."/core/lib/functions2.lib.php");
    print '<tr><td>'.$langs->trans("DefaultLang").'</td><td colspan="3">';
    //$s=picto_from_langcode($soc->default_lang);
    //print ($s?$s.' ':'');
    $langs->load("languages");
    $labellang = ($soc->default_lang?$langs->trans('Language_'.$soc->default_lang):'');
    print $labellang;
    print '</td></tr>';
}

// Ban
if (empty($conf->global->SOCIETE_DISABLE_BANKACCOUNT))
{
    print '<tr><td>';
    print '<table width="100%" class="nobordernopadding"><tr><td>';
    print $langs->trans('RIB');
    print '<td><td align="right">';
    if ($user->rights->societe->creer)
    print '<a href="'.DOL_URL_ROOT.'/societe/rib.php?socid='.$soc->id.'">'.img_edit().'</a>';
    else
    print '&nbsp;';
    print '</td></tr></table>';
    print '</td>';
    print '<td colspan="3">';
    print $soc->display_rib();
    print '</td></tr>';
}

// Parent company
/*
if (empty($conf->global->SOCIETE_DISABLE_PARENTCOMPANY))
{
    print '<tr><td>';
    print '<table width="100%" class="nobordernopadding"><tr><td>';
    print $langs->trans('ParentPatient');
    print '<td><td align="right">';
    if ($user->rights->societe->creer)
    print '<a href="'.DOL_URL_ROOT.'/societe/lien.php?socid='.$soc->id.'">'.img_edit() .'</a>';
    else
    print '&nbsp;';
    print '</td></tr></table>';
    print '</td>';
    print '<td colspan="3">';
    if ($soc->parent)
    {
        $socm = new Societe($db);
        $socm->fetch($soc->parent);
        print $socm->getNomUrl(1).' '.($socm->code_client?"(".$socm->code_client.")":"");
        print $socm->town?' - '.$socm->town:'';
    }
    else {
        print $langs->trans("NoParentCompany");
    }
    print '</td></tr>';
}
*/

// Num secu
print '<tr>';
print '<td class="nowrap">'.$langs->trans('PatientVATIntra').'</td><td colspan="3">';
if ($soc->tva_intra)
{
    $s='';
    $s.=$soc->tva_intra;
    $s.='<input type="hidden" name="tva_intra" size="12" maxlength="20" value="'.$soc->tva_intra.'">';

    if (empty($conf->global->MAIN_DISABLEVATCHECK))
    {
        $s.=' &nbsp; ';

        if ($conf->use_javascript_ajax)
        {
            print "\n";
            print '<script language="JavaScript" type="text/javascript">';
            print "function CheckVAT(a) {\n";
            print "newpopup('".DOL_URL_ROOT."/societe/checkvat/checkVatPopup.php?vatNumber='+a,'".dol_escape_js($langs->trans("VATIntraCheckableOnEUSite"))."',500,285);\n";
            print "}\n";
            print '</script>';
            print "\n";
            $s.='<a href="#" onclick="javascript: CheckVAT(document.formsoc.tva_intra.value);">'.$langs->trans("VATIntraCheck").'</a>';
            $s = $form->textwithpicto($s,$langs->trans("VATIntraCheckDesc",$langs->trans("VATIntraCheck")),1);
        }
        else
        {
            $s.='<a href="'.$langs->transcountry("VATIntraCheckURL",$soc->id_pays).'" target="_blank">'.img_picto($langs->trans("VATIntraCheckableOnEUSite"),'help').'</a>';
        }
    }
    print $s;
}
else
{
    print '&nbsp;';
}
print '</td>';
print '</tr>';

// Commercial
print '<tr><td>';
print '<table width="100%" class="nobordernopadding"><tr><td>';
print $langs->trans('SalesRepresentatives');
print '<td><td align="right">';
if ($user->rights->societe->creer)
print '<a href="'.DOL_URL_ROOT.'/societe/commerciaux.php?socid='.$soc->id.'">'.img_edit().'</a>';
else
print '&nbsp;';
print '</td></tr></table>';
print '</td>';
print '<td colspan="3">';

$listsalesrepresentatives=$soc->getSalesRepresentatives($user);
$nbofsalesrepresentative=count($listsalesrepresentatives);
if ($nbofsalesrepresentative > 3)   // We print only number
{
    print '<a href="'.DOL_URL_ROOT.'/societe/commerciaux.php?socid='.$soc->id.'">';
    print $nbofsalesrepresentative;
    print '</a>';
}
else if ($nbofsalesrepresentative > 0)
{
    $userstatic=new User($db);
    $i=0;
    foreach($listsalesrepresentatives as $val)
    {
        $userstatic->id=$val['id'];
        $userstatic->lastname=$val['lastname'];
        $userstatic->firstname=$val['firstname'];
        print $userstatic->getNomUrl(1);
        $i++;
        if ($i < $nbofsalesrepresentative) print ', ';
    }
}
else print $langs->trans("NoSalesRepresentativeAffected");
print '</td></tr>';

print '</table>';

dol_fiche_end();


/*
 *  Actions
 */
print '<div class="tabsAction">'."\n";

if ($user->rights->societe->creer)
{
    print '<a class="butAction" href="'.$_SERVER["PHP_SELF"].'?socid='.$soc->id.'&amp;action=edit">'.$langs->trans("Modify").'</a>'."\n";
}

if ($user->rights->societe->supprimer)
{
    if ($conf->use_javascript_ajax && empty($conf->dol_use_jmobile))
    {
        print '<span id="action-delete" class="butActionDelete">'.$langs->trans('Delete').'</span>'."\n";
    }
    else
    {
        print '<a class="butActionDelete" href="'.$_SERVER["PHP_SELF"].'?socid='.$soc->id.'&amp;action=delete">'.$langs->trans('Delete').'</a>'."\n";
    }
}

print '</div>'."\n";
print '<br>';

/*
print '<table width="100%"><tr><td valign="top" width="50%">';
print '<a name="builddoc"></a>'; // ancre

$filedir=$conf->societe->dir_output.'/'.$soc->id;
$urlsource=$_SERVER["PHP_SELF"]."?socid=".$soc->id;
$genallowed=$user->rights->societe->creer;
$delallowed=$user->rights->societe->supprimer;

$var=true;

$somethingshown=$formfile->show_documents('company',$soc->id,$filedir,$urlsource,$genallowed,$delallowed,'',0,0,0,28,0,'',0,'',$soc->default_lang);

print '</td>';
print '<td>';
print '</td>';
print '</tr>';
print '</table>';

print '<br>';
*/

// Subsidiaries list
$result=show_subsidiaries($conf,$langs,$db,$soc);

// Contacts list
if (empty($conf->global->SOCIETE_DISABLE_CONTACTS))
{
  $result=show_contacts($conf,$langs,$db,$soc);
}

// Projects list
$result=show_projects($conf,$langs,$db,$soc);
?>

<!-- END PHP TEMPLATE -->

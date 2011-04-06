<?php
/* Copyright (C) 2010 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2010 Regis Houssin        <regis@dolibarr.fr>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * or see http://www.gnu.org/
 */

/**
 *  \file		htdocs/includes/menus/cabinetmed.lib.php
 *  \brief		Library for file cabinetmed menus
 *  \version	$Id: cabinetmed.lib.php,v 1.14 2011/04/06 17:12:30 eldy Exp $
 */


/**
 * Core function to output top menu cabinetmed
 *
 * @param $db
 * @param $atarget
 * @param $type_user     0=Internal,1=External,2=All
 */
function print_cabinetmed_menu($db,$atarget,$type_user)
{
	global $user,$conf,$langs,$dolibarr_main_db_name;

	// On sauve en session le menu principal choisi
	if (isset($_GET["mainmenu"])) $_SESSION["mainmenu"]=$_GET["mainmenu"];
	if (isset($_GET["idmenu"]))   $_SESSION["idmenu"]=$_GET["idmenu"];
	$_SESSION["leftmenuopened"]="";

	$id='mainmenu';

	print_start_menu_array();

	// Home
	$classname="";
	if ($_SESSION["mainmenu"] && $_SESSION["mainmenu"] == "home")
	{
		$classname='class="tmenusel"'; $_SESSION['idmenu']='';
	}
	else
	{
		$classname = 'class="tmenu"';
	}
	$idsel='home';
	print_start_menu_entry($idsel);
	print '<a class="tmenuimage" href="'.DOL_URL_ROOT.'/index.php?mainmenu=home&amp;leftmenu="'.($atarget?" target=$atarget":"").'>';
	print '<div class="'.$id.' '.$idsel.'"><span class="'.$id.' tmenuimage" id="mainmenuspan_'.$idsel.'"></span></div>';
	print '</a>';
	print '<a '.$classname.' id="mainmenua_'.$idsel.'" href="'.DOL_URL_ROOT.'/index.php?mainmenu=home&amp;leftmenu="'.($atarget?" target=$atarget":"").'>';
	print_text_menu_entry($langs->trans("Home"));
	print '</a>';
	print_end_menu_entry();


	// Patient
	if ($conf->societe->enabled || $conf->fournisseur->enabled)
	{
		$langs->load("companies");
		$langs->load("suppliers");
        $langs->load("cabinetmed@cabinetmed");

		$classname="";
		if ($_SESSION["mainmenu"] && $_SESSION["mainmenu"] == "companies")
		{
			$classname='class="tmenusel"'; $_SESSION['idmenu']='';
		}
		else
		{
			$classname = 'class="tmenu"';
		}

		$idsel='companies';
		if (($conf->societe->enabled && $user->rights->societe->lire)
		|| ($conf->fournisseur->enabled && $user->rights->fournisseur->lire))
		{
			print_start_menu_entry($idsel);
			print '<a class="tmenuimage" href="'.DOL_URL_ROOT.'/societe/index.php?mainmenu=companies&amp;leftmenu="'.($atarget?" target=$atarget":"").'>';
			print '<div class="'.$id.' '.$idsel.'"><span class="'.$id.' tmenuimage" id="mainmenuspan_'.$idsel.'"></span></div>';
			print '</a>';
			print '<a '.$classname.' id="mainmenua_'.$idsel.'" href="'.DOL_URL_ROOT.'/societe/index.php?mainmenu=companies&amp;leftmenu="'.($atarget?" target=$atarget":"").'>';
			print_text_menu_entry($langs->trans("Patients"));
			print '</a>';
			print_end_menu_entry();
		}
		else if (empty($conf->global->MAIN_MENU_HIDE_UNAUTHORIZED))
		{
			if (! $type_user)
			{
				print_start_menu_entry($idsel);
				print '<div class="'.$id.' '.$idsel.'"><span class="'.$id.'" id="mainmenuspan_'.$idsel.'"></span></div>';
				print '<a class="tmenudisabled" id="mainmenua_'.$idsel.'" href="#">';
				print_text_menu_entry($langs->trans("Patients"));
				print '</a>';
				print_end_menu_entry();
			}
		}
	}

	// Correspondant
	if ($conf->societe->enabled || $conf->fournisseur->enabled)
	{
		$langs->load("companies");
		$langs->load("suppliers");
        $langs->load("cabinetmed@cabinetmed");

		$classname="";
		if ($_SESSION["mainmenu"] && $_SESSION["mainmenu"] == "contacts")
		{
			$classname='class="tmenusel"'; $_SESSION['idmenu']='';
		}
		else
		{
			$classname = 'class="tmenu"';
		}

		$idsel='contacts';
		if (($conf->societe->enabled && $user->rights->societe->lire)
		|| ($conf->fournisseur->enabled && $user->rights->fournisseur->lire))
		{
			print_start_menu_entry($idsel);
			print '<a class="tmenuimage" href="'.DOL_URL_ROOT.'/contact/index.php?mainmenu=contacts&amp;leftmenu="'.($atarget?" target=$atarget":"").'>';
			print '<div class="'.$id.' '.$idsel.'"><span class="'.$id.' tmenuimage" id="mainmenuspan_'.$idsel.'"></span></div>';
			print '</a>';
			print '<a '.$classname.' id="mainmenua_'.$idsel.'" href="'.DOL_URL_ROOT.'/contact/index.php?mainmenu=contacts&amp;leftmenu="'.($atarget?" target=$atarget":"").'>';
			print_text_menu_entry($langs->trans("Correspondants"));
			print '</a>';
			print_end_menu_entry();
		}
		else if (empty($conf->global->MAIN_MENU_HIDE_UNAUTHORIZED))
		{
			if (! $type_user)
			{
				print_start_menu_entry($idsel);
				print '<div class="'.$id.' '.$idsel.'"><span class="'.$id.'" id="mainmenuspan_'.$idsel.'"></span></div>';
				print '<a class="tmenudisabled" id="mainmenua_'.$idsel.'" href="#">';
				print_text_menu_entry($langs->trans("Correspondants"));
				print '</a>';
				print_end_menu_entry();
			}
		}
	}

	// Products-Services
	if ($conf->product->enabled || $conf->service->enabled)
	{
		$langs->load("products");

		$classname="";
		if ($_SESSION["mainmenu"] && $_SESSION["mainmenu"] == "products")
		{
			$classname='class="tmenusel"'; $_SESSION['idmenu']='';
		}
		else
		{
			$classname = 'class="tmenu"';
		}
		$chaine="";
		if ($conf->product->enabled) { $chaine.=$langs->trans("Products"); }
		if ($conf->product->enabled && $conf->service->enabled) { $chaine.="/"; }
		if ($conf->service->enabled) { $chaine.=$langs->trans("Services"); }

		$idsel='products';
		if ($user->rights->produit->lire || $user->rights->service->lire)
		{
			print_start_menu_entry($idsel);
			print '<a class="tmenuimage" href="'.DOL_URL_ROOT.'/product/index.php?mainmenu=products&amp;leftmenu="'.($atarget?" target=$atarget":"").'>';
			print '<div class="'.$id.' '.$idsel.'"><span class="'.$id.' tmenuimage"  id="mainmenuspan_'.$idsel.'"></span></div>';
			print '</a>';
			print '<a '.$classname.' id="mainmenua_'.$idsel.'" href="'.DOL_URL_ROOT.'/product/index.php?mainmenu=products&amp;leftmenu="'.($atarget?" target=$atarget":"").'>';
			print_text_menu_entry($chaine);
			print '</a>';
			print_end_menu_entry();
		}
		else if (empty($conf->global->MAIN_MENU_HIDE_UNAUTHORIZED))
		{
			if (! $type_user)
			{
				print_start_menu_entry($idsel);
				print '<div class="'.$id.' '.$idsel.'"><span class="'.$id.'" id="mainmenuspan_'.$idsel.'"></span></div>';
				print '<a class="tmenudisabled" id="mainmenua_'.$idsel.'" href="#">';
				print_text_menu_entry($chaine);
				print '</a>';
				print_end_menu_entry();
			}
		}
	}

	// Financial
	/*
	if ($conf->compta->enabled || $conf->accounting->enabled
	|| $conf->facture->enabled || $conf->deplacement->enabled)
	{
		$langs->load("compta");
        $langs->load("cabinetmed@cabinetmed");

		$classname="";
		if ($_SESSION["mainmenu"] && $_SESSION["mainmenu"] == "accountancy")
		{
			$classname='class="tmenusel"'; $_SESSION['idmenu']='';
		}
		else
		{
			$classname = 'class="tmenu"';
		}

		$idsel='accountancy';
		if ($user->rights->compta->resultat->lire || $user->rights->accounting->plancompte->lire
		|| $user->rights->facture->lire || $user->rights->banque->lire)
		{
			print_start_menu_entry($idsel);
			print '<a class="tmenuimage" href="'.DOL_URL_ROOT.'/compta/index.php?mainmenu=accountancy&amp;leftmenu="'.($atarget?" target=$atarget":"").'>';
			print '<div class="'.$id.' '.$idsel.'"><span class="'.$id.' tmenuimage" id="mainmenuspan_'.$idsel.'"></span></div>';
			print '</a>';
			print '<a '.$classname.' id="mainmenua_'.$idsel.'" href="'.DOL_URL_ROOT.'/compta/index.php?mainmenu=accountancy&amp;leftmenu="'.($atarget?" target=$atarget":"").'>';
			print_text_menu_entry($langs->trans("MenuConsultation"));
			print '</a>';
			print_end_menu_entry();
		}
		else if (empty($conf->global->MAIN_MENU_HIDE_UNAUTHORIZED))
		{
			if (! $type_user)
			{
				print_start_menu_entry($idsel);
				print '<div class="'.$id.' '.$idsel.'"><span class="'.$id.'" id="mainmenuspan_'.$idsel.'"></span></div>';
				print '<a class="tmenudisabled" id="mainmenua_'.$idsel.'" href="#">';
				print_text_menu_entry($langs->trans("MenuConsultation"));
				print '</a>';
				print_end_menu_entry();
			}
		}
	}
    */

    // Bank
    if ($conf->banque->enabled || $conf->prelevement->enabled)
    {
        $langs->load("compta");
        $langs->load("banks");

        $classname="";
        if ($_SESSION["mainmenu"] && $_SESSION["mainmenu"] == "bank")
        {
            $classname='class="tmenusel"'; $_SESSION['idmenu']='';
        }
        else
        {
            $classname = 'class="tmenu"';
        }

        $idsel='bank';
        if ($user->rights->banque->lire)
        {
            print_start_menu_entry($idsel);
            print '<a class="tmenuimage" href="'.DOL_URL_ROOT.'/compta/bank/index.php?mainmenu=bank&amp;leftmenu="'.($atarget?" target=$atarget":"").'>';
            print '<div class="'.$id.' '.$idsel.'"><span class="'.$id.' tmenuimage" id="mainmenuspan_'.$idsel.'"></span></div>';
            print '</a>';
            print '<a '.$classname.' id="mainmenua_'.$idsel.'" href="'.DOL_URL_ROOT.'/compta/bank/index.php?mainmenu=bank&amp;leftmenu="'.($atarget?" target=$atarget":"").'>';
            print_text_menu_entry($langs->trans("MenuBankCash"));
            print '</a>';
            print_end_menu_entry();
        }
        else if (empty($conf->global->MAIN_MENU_HIDE_UNAUTHORIZED))
        {
            if (! $type_user)
            {
                print_start_menu_entry($idsel);
                print '<div class="'.$id.' '.$idsel.'"><span class="'.$id.'" id="mainmenuspan_'.$idsel.'"></span></div>';
                print '<a class="tmenudisabled" id="mainmenua_'.$idsel.'" href="#">';
                print_text_menu_entry($langs->trans("MenuBankCash"));
                print '</a>';
                print_end_menu_entry();
            }
        }
    }

	// Projects
	if ($conf->projet->enabled)
	{
		$langs->load("projects");

		$classname="";
		if ($_SESSION["mainmenu"] && $_SESSION["mainmenu"] == "project")
		{
			$classname='class="tmenusel"'; $_SESSION['idmenu']='';
		}
		else
		{
			$classname = 'class="tmenu"';
		}

		$idsel='project';
		if ($user->rights->projet->lire)
		{
			print_start_menu_entry($idsel);
			print '<a class="tmenuimage" href="'.DOL_URL_ROOT.'/projet/index.php?mainmenu=project&amp;leftmenu="'.($atarget?" target=$atarget":"").'>';
			print '<div class="'.$id.' '.$idsel.'"><span class="'.$id.' tmenuimage" id="mainmenuspan_'.$idsel.'"></span></div>';
			print '</a>';
			print '<a '.$classname.' id="mainmenua_'.$idsel.'" href="'.DOL_URL_ROOT.'/projet/index.php?mainmenu=project&amp;leftmenu="'.($atarget?" target=$atarget":"").'>';
			print_text_menu_entry($langs->trans("Projects"));
			print '</a>';
			print_end_menu_entry();
		}
		else if (empty($conf->global->MAIN_MENU_HIDE_UNAUTHORIZED))
		{
			if (! $type_user)
			{
				print_start_menu_entry($idsel);
				print '<div class="'.$id.' '.$idsel.'"><span class="'.$id.'" id="mainmenuspan_'.$idsel.'"></span></div>';
				print '<a class="tmenudisabled" id="mainmenua_'.$idsel.'" href="#">';
				print_text_menu_entry($langs->trans("Projects"));
				print '</a>';
				print_end_menu_entry();
			}
		}
	}

	// Tools
	if ($conf->mailing->enabled || $conf->export->enabled || $conf->import->enabled)
	{
		$langs->load("other");

		$classname="";
		if ($_SESSION["mainmenu"] && $_SESSION["mainmenu"] == "tools")
		{
			$classname='class="tmenusel"'; $_SESSION['idmenu']='';
		}
		else
		{
			$classname = 'class="tmenu"';
		}

		$idsel='tools';
		if ($user->rights->mailing->lire || $user->rights->bookmark->lire || $user->rights->export->lire || $user->rights->import->run)
		{
			print_start_menu_entry($idsel);
			print '<a class="tmenuimage" href="'.DOL_URL_ROOT.'/core/tools.php?mainmenu=tools&amp;leftmenu="'.($atarget?" target=$atarget":"").'>';
			print '<div class="'.$id.' '.$idsel.'"><span class="'.$id.' tmenuimage" id="mainmenuspan_'.$idsel.'"></span></div>';
			print '</a>';
			print '<a '.$classname.' id="mainmenua_'.$idsel.'" href="'.DOL_URL_ROOT.'/core/tools.php?mainmenu=tools&amp;leftmenu="'.($atarget?" target=$atarget":"").'>';
			print_text_menu_entry($langs->trans("Tools"));
			print '</a>';
			print_end_menu_entry();
		}
		else if (empty($conf->global->MAIN_MENU_HIDE_UNAUTHORIZED))
		{
			if (! $type_user)
			{
				print_start_menu_entry($idsel);
				print '<div class="'.$id.' '.$idsel.'"><span class="'.$id.'" id="mainmenuspan_'.$idsel.'"></span></div>';
				print '<a class="tmenudisabled"  id="mainmenua_'.$idsel.'" href="#">';
				print_text_menu_entry($langs->trans("Tools"));
				print '</a>';
				print_end_menu_entry();
			}
		}
	}

	// OSCommerce 1
	if (! empty($conf->boutique->enabled))
	{
		$langs->load("shop");

		$classname="";
		if ($_SESSION["mainmenu"] && $_SESSION["mainmenu"] == "shop")
		{
			$classname='class="tmenusel"'; $_SESSION['idmenu']='';
		}
		else
		{
			$classname = 'class="tmenu"';
		}

		$idsel='shop';
		print_start_menu_entry($idsel);
		print '<a class="tmenuimage" href="'.DOL_URL_ROOT.'/boutique/index.php?mainmenu=shop&amp;leftmenu="'.($atarget?" target=$atarget":"").'>';
		print '<div class="'.$id.' '.$idsel.'"><span class="'.$id.' tmenuimage" id="mainmenuspan_'.$idsel.'"></span></div>';
		print '</a>';
		print '<a '.$classname.' id="mainmenua_'.$idsel.'" href="'.DOL_URL_ROOT.'/boutique/index.php?mainmenu=shop&amp;leftmenu="'.($atarget?" target=$atarget":"").'>';
		print_text_menu_entry($langs->trans("OSCommerce"));
		print '</a>';
		print_end_menu_entry();
	}

	// Members
	if ($conf->adherent->enabled)
	{
		// $langs->load("members"); Added in main file

		$classname="";
		if ($_SESSION["mainmenu"] && $_SESSION["mainmenu"] == "members")
		{
			$classname='class="tmenusel"'; $_SESSION['idmenu']='';
		}
		else
		{
			$classname = 'class="tmenu"';
		}

		$idsel='members';
		if ($user->rights->adherent->lire)
		{
			print_start_menu_entry($idsel);
			print '<a class="tmenuimage" href="'.DOL_URL_ROOT.'/adherents/index.php?mainmenu=members&amp;leftmenu="'.($atarget?" target=$atarget":"").'>';
			print '<div class="'.$id.' '.$idsel.'"><span class="'.$id.' tmenuimage" id="mainmenuspan_'.$idsel.'"></span></div>';
			print '</a>';
			print '<a '.$classname.'  id="mainmenua_'.$idsel.'" href="'.DOL_URL_ROOT.'/adherents/index.php?mainmenu=members&amp;leftmenu="'.($atarget?" target=$atarget":"").'>';
			print_text_menu_entry($langs->trans("MenuMembers"));
			print '</a>';
			print_end_menu_entry();
		}
		else if (empty($conf->global->MAIN_MENU_HIDE_UNAUTHORIZED))
		{
			if (! $type_user)
			{
				print_start_menu_entry($idsel);
				print '<div class="'.$id.' '.$idsel.'"><span class="'.$id.'" id="mainmenuspan_'.$idsel.'"></span></div>';
				print '<a class="tmenudisabled" id="mainmenua_'.$idsel.'" href="#">';
				print_text_menu_entry($langs->trans("MenuMembers"));
				print '</a>';
				print_end_menu_entry();
			}
		}
	}


	// Show personalized menus
	require_once(DOL_DOCUMENT_ROOT."/core/class/menubase.class.php");

	$menuArbo = new Menubase($db,'cabinetmed','top');

	$newTabMenu = $menuArbo->menuTopCharger($_SESSION['mainmenu'],'',$type_user,'cabinetmed');

	for($i=0; $i<count($newTabMenu); $i++)
	{
		if ($newTabMenu[$i]['enabled'] == true)
		{
			//var_dump($newTabMenu[$i]);

			$idsel=(empty($newTabMenu[$i]['mainmenu'])?'none':$newTabMenu[$i]['mainmenu']);
			if ($newTabMenu[$i]['right'] == true)	// Is allowed
			{
				if (preg_match("/^(http:\/\/|https:\/\/)/i",$newTabMenu[$i]['url']))
				{
					$url = $newTabMenu[$i]['url'];
				}
				else
				{
					$url=dol_buildpath($newTabMenu[$i]['url'],1);
					if (! preg_match('/\?/',$url)) $url.='?';
					else $url.='&';
					if (! preg_match('/mainmenu/i',$url) || ! preg_match('/leftmenu/i',$url))
					{
						$url.='mainmenu='.$newTabMenu[$i]['mainmenu'].'&leftmenu=&';
					}
					$url.="idmenu=".$newTabMenu[$i]['rowid'];
				}

				// Define the class (top menu selected or not)
				if (! empty($_SESSION['idmenu']) && $newTabMenu[$i]['rowid'] == $_SESSION['idmenu']) $classname='class="tmenusel"';
				else if (! empty($_SESSION['mainmenu']) && $newTabMenu[$i]['mainmenu'] == $_SESSION['mainmenu']) $classname='class="tmenusel"';
				else $classname='class="tmenu"';

				print_start_menu_entry($idsel);
				print '<a class="tmenuimage" href="'.$url.'"'.($newTabMenu[$i]['atarget']?" target='".$newTabMenu[$i]['atarget']."'":($atarget?" target=$atarget":"")).'>';
				print '<div class="'.$id.' '.$idsel.'"><span class="'.$id.' tmenuimage" id="mainmenuspan_'.$idsel.'"></span></div>';
				print '</a>';
				print '<a '.$classname.' id="mainmenua_'.$idsel.'" href="'.$url.'"'.($newTabMenu[$i]['atarget']?" target='".$newTabMenu[$i]['atarget']."'":($atarget?" target=$atarget":"")).'>';
				print_text_menu_entry($newTabMenu[$i]['titre']);
				print '</a>';
				print_end_menu_entry();
			}
			else if (empty($conf->global->MAIN_MENU_HIDE_UNAUTHORIZED))
			{
				if (! $type_user)
				{
					print_start_menu_entry($idsel);
					print '<div class="'.$id.' '.$idsel.'"><span class="'.$id.' tmenuimage" id="mainmenuspan_'.$idsel.'"></span></div>';
					print '<a class="tmenudisabled" id="mainmenua_'.$idsel.'" href="#">';
					print_text_menu_entry($newTabMenu[$i]['titre']);
					print '</a>';
					print_end_menu_entry();
				}
			}
		}
	}

	print_end_menu_array();
}



function print_start_menu_array()
{
	global $conf;
	if (preg_match('/bluelagoon|eldy|freelug|rodolphe|yellow|dev/',$conf->css)) print '<table class="tmenu" summary="topmenu"><tr class="tmenu">';
	else print '<ul class="tmenu">';
}

function print_start_menu_entry($idsel)
{
	global $conf;
	if (preg_match('/bluelagoon|eldy|freelug|rodolphe|yellow|dev/',$conf->css)) print '<td class="tmenu" id="mainmenutd_'.$idsel.'">';
	else print '<li class="tmenu" id="mainmenutd_'.$idsel.'">';
}

function print_text_menu_entry($text)
{
	global $conf;
	print '<span class="mainmenuaspan">';
	print $text;
	print '</span>';
}

function print_end_menu_entry()
{
	global $conf;
	if (preg_match('/bluelagoon|eldy|freelug|rodolphe|yellow|dev/',$conf->css)) print '</td>';
	else print '</li>';
	print "\n";
}

function print_end_menu_array()
{
	global $conf;
	if (preg_match('/bluelagoon|eldy|freelug|rodolphe|yellow|dev/',$conf->css)) print '</tr></table>';
	else print '</ul>';
	print "\n";
}



/**
 * Core function to output left menu cabinetmed
 *
 * @param      db                  Database handler
 * @param      menu_array_before   Table of menu entries to show before entries of menu handler
 * @param      menu_array_after    Table of menu entries to show after entries of menu handler
 */
function print_left_cabinetmed_menu($db,$menu_array_before,$menu_array_after)
{
    global $user,$conf,$langs,$dolibarr_main_db_name,$mysoc;

    // Read mainmenu and leftmenu that define which menu to show
    if (isset($_GET["mainmenu"]))
    {
        // On sauve en session le menu principal choisi
        $mainmenu=$_GET["mainmenu"];
        $_SESSION["mainmenu"]=$mainmenu;
        $_SESSION["leftmenuopened"]="";
    }
    else
    {
        // On va le chercher en session si non defini par le lien
        $mainmenu=isset($_SESSION["mainmenu"])?$_SESSION["mainmenu"]:'';
    }

    if (isset($_GET["leftmenu"]))
    {
        // On sauve en session le menu principal choisi
        $leftmenu=$_GET["leftmenu"];
        $_SESSION["leftmenu"]=$leftmenu;
        if ($_SESSION["leftmenuopened"]==$leftmenu)
        {
            //$leftmenu="";
            $_SESSION["leftmenuopened"]="";
        }
        else
        {
            $_SESSION["leftmenuopened"]=$leftmenu;
        }
    } else {
        // On va le chercher en session si non defini par le lien
        $leftmenu=isset($_SESSION["leftmenu"])?$_SESSION["leftmenu"]:'';
    }

    $newmenu = new Menu();

    // Show logo company
    if (! empty($conf->global->MAIN_SHOW_LOGO))
    {
        $mysoc->logo_mini=$conf->global->MAIN_INFO_SOCIETE_LOGO_MINI;
        if (! empty($mysoc->logo_mini) && is_readable($conf->mycompany->dir_output.'/logos/thumbs/'.$mysoc->logo_mini))
        {
            $urllogo=DOL_URL_ROOT.'/viewimage.php?modulepart=companylogo&amp;file='.urlencode('thumbs/'.$mysoc->logo_mini);
            print "\n".'<!-- Show logo on menu -->'."\n";
            print '<div class="blockvmenuimpair">'."\n";
            print '<center><img title="'.$title.'" src="'.$urllogo.'"></center>'."\n";
            print '</div>'."\n";
        }
    }

    /**
     * On definit newmenu en fonction de mainmenu et leftmenu
     * ------------------------------------------------------
     */
    if ($mainmenu)
    {

        /*
         * Menu HOME
         */
        if ($mainmenu == 'home')
        {
            $langs->load("users");

            if ($user->admin)
            {
                $langs->load("admin");
                $langs->load("help");
                $langs->load("cabinetmed@cabinetmed");

                $newmenu->add("/admin/index.php?leftmenu=setup", $langs->trans("Setup"));
                if ($leftmenu=="setup") $newmenu->add("/admin/company.php", $langs->trans("MenuCabinet"),1);
                if ($leftmenu=="setup") $newmenu->add("/admin/modules.php", $langs->trans("Modules"),1);
                if ($leftmenu=="setup") $newmenu->add("/admin/menus.php", $langs->trans("Menus"),1);
                if ($leftmenu=="setup") $newmenu->add("/admin/ihm.php", $langs->trans("GUISetup"),1);
                if ($leftmenu=="setup") $newmenu->add("/admin/boxes.php", $langs->trans("Boxes"),1);
                if ($leftmenu=="setup") $newmenu->add("/admin/delais.php",$langs->trans("Alerts"),1);

                if ($leftmenu=="setup") $newmenu->add("/admin/proxy.php", $langs->trans("Security"),1);
                if ($leftmenu=="setup") $newmenu->add("/admin/limits.php", $langs->trans("MenuLimits"),1);
                if ($leftmenu=="setup") $newmenu->add("/admin/mails.php", $langs->trans("Emails"),1);
                if ($leftmenu=="setup") $newmenu->add("/admin/dict.php", $langs->trans("DictionnarySetup"),1);
                if ($leftmenu=="setup") $newmenu->add("/admin/const.php", $langs->trans("OtherSetup"),1);

                $newmenu->add("/admin/system/index.php?leftmenu=system", $langs->trans("SystemInfo"));
                if ($leftmenu=="system") $newmenu->add("/admin/system/dolibarr.php", $langs->trans("Dolibarr"),1);
                if ($leftmenu=="system") $newmenu->add("/admin/system/constall.php", $langs->trans("AllParameters"),2);
                if ($leftmenu=="system") $newmenu->add("/admin/system/modules.php", $langs->trans("Modules"),2);
                if ($leftmenu=="system") $newmenu->add("/admin/triggers.php", $langs->trans("Triggers"),2);
                if ($leftmenu=="system") $newmenu->add("/admin/system/about.php", $langs->trans("About"),2);
                if ($leftmenu=="system") $newmenu->add("/admin/system/os.php", $langs->trans("OS"),1);
                if ($leftmenu=="system") $newmenu->add("/admin/system/web.php", $langs->trans("WebServer"),1);
                if ($leftmenu=="system") $newmenu->add("/admin/system/phpinfo.php", $langs->trans("Php"),1);
                //if ($leftmenu=="system" && function_exists('xdebug_is_enabled')) $newmenu->add("/admin/system/xdebug.php", $langs->trans("XDebug"),1);
                if ($leftmenu=="system") $newmenu->add("/admin/system/database.php", $langs->trans("Database"),1);
                if ($leftmenu=="system") $newmenu->add("/admin/system/database-tables.php", $langs->trans("Tables"),2);
                if ($leftmenu=="system") $newmenu->add("/admin/system/database-tables-contraintes.php", $langs->trans("Constraints"),2);

                $newmenu->add("/admin/tools/index.php?leftmenu=admintools", $langs->trans("SystemTools"));
                if ($leftmenu=="admintools") $newmenu->add("/admin/tools/dolibarr_export.php", $langs->trans("Backup"),1);
                if ($leftmenu=="admintools") $newmenu->add("/admin/tools/dolibarr_import.php", $langs->trans("Restore"),1);
                if ($leftmenu=="admintools") $newmenu->add("/admin/tools/update.php", $langs->trans("MenuUpgrade"),1);
                if ($leftmenu=="admintools" && function_exists('eaccelerator_info')) $newmenu->add("/admin/tools/eaccelerator.php", $langs->trans("EAccelerator"),1);
                if ($leftmenu=="admintools") $newmenu->add("/admin/tools/listevents.php", $langs->trans("Audit"),1);
                if ($leftmenu=="admintools") $newmenu->add("/admin/tools/listsessions.php", $langs->trans("Sessions"),1);
                if ($leftmenu=="admintools") $newmenu->add("/admin/tools/purge.php", $langs->trans("Purge"),1);
                if ($leftmenu=="admintools") $newmenu->add("/support/index.php", $langs->trans("HelpCenter"),1,1,'targethelp');
            }

            $newmenu->add("/user/home.php?leftmenu=users", $langs->trans("MenuUsersAndGroups"));
            if ($leftmenu=="users") $newmenu->add("/user/index.php", $langs->trans("Users"), 1, $user->rights->user->user->lire || $user->admin);
            if ($leftmenu=="users") $newmenu->add("/user/fiche.php?action=create", $langs->trans("NewUser"),2, $user->rights->user->user->creer || $user->admin);
            if ($leftmenu=="users") $newmenu->add("/user/group/index.php", $langs->trans("Groups"), 1, ($conf->global->MAIN_USE_ADVANCED_PERMS?$user->rights->user->group_advance->read:$user->rights->user->user->lire) || $user->admin);
            if ($leftmenu=="users") $newmenu->add("/user/group/fiche.php?action=create", $langs->trans("NewGroup"), 2, ($conf->global->MAIN_USE_ADVANCED_PERMS?$user->rights->user->group_advance->write:$user->rights->user->user->creer) || $user->admin);
        }


        /*
         * Menu Patients
         */
        if ($mainmenu == 'companies')
        {
            // Societes
            if ($conf->societe->enabled)
            {
                $langs->load("companies");
                $langs->load("cabinetmed@cabinetmed");
                $newmenu->add("/societe/index.php?leftmenu=customers", $langs->trans("Patients"), 0, $user->rights->societe->lire);

                if ($user->rights->societe->creer)
                {
                    $newmenu->add("/societe/soc.php?action=create&leftmenu=customers",$langs->trans("MenuNewPatient"),1);
                }
            }

            // Patients
            if ($conf->societe->enabled)
            {
                $langs->load("commercial");
                $newmenu->add("/comm/clients.php?leftmenu=customers&search_sale=".$user->id, $langs->trans("ListPatient"), 1, $user->rights->societe->lire);
                $newmenu->add("/cabinetmed/listconsult.php?leftmenu=customers&search_sale=".$user->id, $langs->trans("ListConsult"), 1, $user->rights->societe->lire);
            }

            // Categories
            if ($conf->categorie->enabled)
            {
                $langs->load("categories");
                // Categories prospects/customers
                $newmenu->add("/categories/index.php?leftmenu=cat&amp;type=2", $langs->trans("CustomersProspectsCategoriesShort"), 0, $user->rights->categorie->lire);
                if ($user->societe_id == 0)
                {
                    $newmenu->add("/categories/fiche.php?action=create&amp;type=2", $langs->trans("NewCategory"), 1, $user->rights->categorie->creer);
                }
                // Categories suppliers
                if ($conf->fournisseur->enabled)
                {
                    $newmenu->add("/categories/index.php?leftmenu=cat&amp;type=1", $langs->trans("SuppliersCategoriesShort"), 0, $user->rights->categorie->lire);
                    if ($user->societe_id == 0)
                    {
                        $newmenu->add("/categories/fiche.php?action=create&amp;type=1", $langs->trans("NewCategory"), 1, $user->rights->categorie->creer);
                    }
                }
                //if ($leftmenu=="cat") $newmenu->add("/categories/liste.php", $langs->trans("List"), 1, $user->rights->categorie->lire);
            }

        }

        /*
         * Menu Correspondants
         */
        if ($mainmenu == 'contacts')
        {
            // Correspondants
            $newmenu->add("/contact/index.php?leftmenu=contacts", $langs->trans("Correspondants"), 0, $user->rights->societe->contact->lire);
            $newmenu->add("/contact/fiche.php?leftmenu=contacts&amp;action=create", $langs->trans("NewContact"), 1, $user->rights->societe->contact->creer);
            $newmenu->add("/contact/index.php?leftmenu=contacts", $langs->trans("List"), 1, $user->rights->societe->contact->lire);
        }

        /*
         * Menu COMMERCIAL
         */
        if ($mainmenu == 'commercial')
        {
            $langs->load("companies");

            // Prospects
            $newmenu->add("/comm/prospect/index.php?leftmenu=prospects", $langs->trans("Prospects"), 0, $user->rights->societe->lire);

            $newmenu->add("/societe/soc.php?leftmenu=prospects&amp;action=create&amp;type=p", $langs->trans("MenuNewProspect"), 1, $user->rights->societe->creer);
            $newmenu->add("/comm/prospect/prospects.php?leftmenu=prospects", $langs->trans("List"), 1, $user->rights->societe->contact->lire);

            if ($leftmenu=="prospects") $newmenu->add("/comm/prospect/prospects.php?sortfield=s.datec&amp;sortorder=desc&amp;begin=&amp;stcomm=-1", $langs->trans("LastProspectDoNotContact"), 2, $user->rights->societe->lire);
            if ($leftmenu=="prospects") $newmenu->add("/comm/prospect/prospects.php?sortfield=s.datec&amp;sortorder=desc&amp;begin=&amp;stcomm=0", $langs->trans("LastProspectNeverContacted"), 2, $user->rights->societe->lire);
            if ($leftmenu=="prospects") $newmenu->add("/comm/prospect/prospects.php?sortfield=s.datec&amp;sortorder=desc&amp;begin=&amp;stcomm=1", $langs->trans("LastProspectToContact"), 2, $user->rights->societe->lire);
            if ($leftmenu=="prospects") $newmenu->add("/comm/prospect/prospects.php?sortfield=s.datec&amp;sortorder=desc&amp;begin=&amp;stcomm=2", $langs->trans("LastProspectContactInProcess"), 2, $user->rights->societe->lire);
            if ($leftmenu=="prospects") $newmenu->add("/comm/prospect/prospects.php?sortfield=s.datec&amp;sortorder=desc&amp;begin=&amp;stcomm=3", $langs->trans("LastProspectContactDone"), 2, $user->rights->societe->lire);

            $newmenu->add("/contact/index.php?leftmenu=prospects&amp;type=p", $langs->trans("Contacts"), 1, $user->rights->societe->contact->lire);

            // Customers
            $newmenu->add("/comm/index.php?leftmenu=customers", $langs->trans("Customers"), 0, $user->rights->societe->lire);

            $newmenu->add("/societe/soc.php?leftmenu=customers&amp;action=create&amp;type=c", $langs->trans("MenuNewCustomer"), 1, $user->rights->societe->creer);
            $newmenu->add("/comm/clients.php?leftmenu=customers", $langs->trans("List"), 1, $user->rights->societe->lire);
            $newmenu->add("/contact/index.php?leftmenu=customers&amp;type=c", $langs->trans("Contacts"), 1, $user->rights->societe->contact->lire);

            // Suppliers
            if ($conf->fournisseur->enabled)
            {
                $newmenu->add("/fourn/index.php?leftmenu=suppliers", $langs->trans("Suppliers"), 0, $user->rights->societe->lire);

                $newmenu->add("/societe/soc.php?leftmenu=suppliers&amp;action=create&amp;type=f", $langs->trans("MenuNewSupplier"), 1, $user->rights->societe->creer);
                $newmenu->add("/fourn/liste.php?leftmenu=customers", $langs->trans("List"), 1, $user->rights->societe->lire);
                $newmenu->add("/contact/index.php?leftmenu=suppliers&amp;type=f", $langs->trans("Contacts"), 1, $user->rights->societe->contact->lire);
            }

            // Contacts
            $newmenu->add("/contact/index.php?leftmenu=contacts", $langs->trans("Contacts"), 0, $user->rights->societe->contact->lire);
            $newmenu->add("/contact/fiche.php?leftmenu=contacts&amp;action=create", $langs->trans("NewContact"), 1, $user->rights->societe->contact->creer);
            $newmenu->add("/contact/index.php?leftmenu=contacts", $langs->trans("List"), 1, $user->rights->societe->contact->lire);
            $newmenu->add("/contact/index.php?leftmenu=contacts&type=p", $langs->trans("Prospects"), 2, $user->rights->societe->contact->lire);
            $newmenu->add("/contact/index.php?leftmenu=contacts&type=c", $langs->trans("Customers"), 2, $user->rights->societe->contact->lire);
            $newmenu->add("/contact/index.php?leftmenu=contacts&type=f", $langs->trans("Suppliers"), 2, $user->rights->societe->contact->lire);
            $newmenu->add("/contact/index.php?leftmenu=contacts&type=o", $langs->trans("Others"), 2, $user->rights->societe->contact->lire);

            // Propal
            if (! empty($conf->propal->enabled))
            {
                $langs->load("propal");
                $newmenu->add("/comm/propal.php?leftmenu=propals", $langs->trans("Prop"), 0 ,$user->rights->propale->lire);
                if ($leftmenu=="propals") $newmenu->add("/societe/societe.php?leftmenu=propals", $langs->trans("NewPropal"), 1, $user->rights->propale->creer);
                if ($leftmenu=="propals") $newmenu->add("/comm/propal.php?leftmenu=propals", $langs->trans("List"), 1, $user->rights->propale->lire);
                if ($leftmenu=="propals") $newmenu->add("/comm/propal.php?leftmenu=propals&viewstatut=0", $langs->trans("PropalsDraft"), 2, $user->rights->propale->lire);
                if ($leftmenu=="propals") $newmenu->add("/comm/propal.php?leftmenu=propals&viewstatut=1", $langs->trans("PropalsOpened"), 2, $user->rights->propale->lire);
                if ($leftmenu=="propals") $newmenu->add("/comm/propal.php?leftmenu=propals&viewstatut=2", $langs->trans("PropalStatusSigned"), 2, $user->rights->propale->lire);
                if ($leftmenu=="propals") $newmenu->add("/comm/propal.php?leftmenu=propals&viewstatut=3", $langs->trans("PropalStatusNotSigned"), 2, $user->rights->propale->lire);
                if ($leftmenu=="propals") $newmenu->add("/comm/propal.php?leftmenu=propals&viewstatut=4", $langs->trans("PropalStatusBilled"), 2, $user->rights->propale->lire);
                //if ($leftmenu=="propals") $newmenu->add("/comm/propal.php?leftmenu=propals&viewstatut=2,3,4", $langs->trans("PropalStatusClosedShort"), 2, $user->rights->propale->lire);
                if ($leftmenu=="propals") $newmenu->add("/comm/propal/stats/index.php?leftmenu=propals", $langs->trans("Statistics"), 1, $user->rights->propale->lire);
            }

            // Customers orders
            if (! empty($conf->commande->enabled))
            {
                $langs->load("orders");
                $newmenu->add("/commande/index.php?leftmenu=orders", $langs->trans("CustomersOrders"), 0 ,$user->rights->commande->lire);
                if ($leftmenu=="orders") $newmenu->add("/societe/societe.php?leftmenu=orders", $langs->trans("NewOrder"), 1, $user->rights->commande->creer);
                if ($leftmenu=="orders") $newmenu->add("/commande/liste.php?leftmenu=orders", $langs->trans("List"), 1, $user->rights->commande->lire);
                if ($leftmenu=="orders") $newmenu->add("/commande/liste.php?leftmenu=orders&viewstatut=0", $langs->trans("StatusOrderDraftShort"), 2, $user->rights->commande->lire);
                if ($leftmenu=="orders") $newmenu->add("/commande/liste.php?leftmenu=orders&viewstatut=1", $langs->trans("StatusOrderValidated"), 2, $user->rights->commande->lire);
                if ($leftmenu=="orders") $newmenu->add("/commande/liste.php?leftmenu=orders&viewstatut=2", $langs->trans("StatusOrderOnProcessShort"), 2, $user->rights->commande->lire);
                if ($leftmenu=="orders") $newmenu->add("/commande/liste.php?leftmenu=orders&viewstatut=3", $langs->trans("StatusOrderToBill"), 2, $user->rights->commande->lire);
                if ($leftmenu=="orders") $newmenu->add("/commande/liste.php?leftmenu=orders&viewstatut=4", $langs->trans("StatusOrderProcessed"), 2, $user->rights->commande->lire);
                if ($leftmenu=="orders") $newmenu->add("/commande/liste.php?leftmenu=orders&viewstatut=-1", $langs->trans("StatusOrderCanceledShort"), 2, $user->rights->commande->lire);
                if ($leftmenu=="orders") $newmenu->add("/commande/stats/index.php?leftmenu=orders", $langs->trans("Statistics"), 1 ,$user->rights->commande->lire);
            }

            // Suppliers orders
            if (! empty($conf->fournisseur->enabled))
            {
                $langs->load("orders");
                $newmenu->add("/fourn/commande/index.php?leftmenu=orders_suppliers",$langs->trans("SuppliersOrders"), 0, $user->rights->fournisseur->commande->lire);
                if ($leftmenu=="orders_suppliers") $newmenu->add("/societe/societe.php?leftmenu=orders_suppliers", $langs->trans("NewOrder"), 1, $user->rights->fournisseur->commande->creer);
                if ($leftmenu=="orders_suppliers") $newmenu->add("/fourn/commande/liste.php?leftmenu=orders_suppliers", $langs->trans("List"), 1, $user->rights->fournisseur->commande->lire);
                if ($leftmenu=="orders_suppliers") $newmenu->add("/commande/stats/index.php?leftmenu=orders_suppliers&amp;mode=supplier", $langs->trans("Statistics"), 1 ,$user->rights->fournisseur->commande->lire);
            }

            // Contrat
            if (! empty($conf->contrat->enabled))
            {
                $langs->load("contracts");
                $newmenu->add("/contrat/index.php?leftmenu=contracts", $langs->trans("Contracts"), 0 ,$user->rights->contrat->lire);
                if ($leftmenu=="contracts") $newmenu->add("/societe/societe.php?leftmenu=contracts", $langs->trans("NewContract"), 1, $user->rights->contrat->creer);
                if ($leftmenu=="contracts") $newmenu->add("/contrat/liste.php?leftmenu=contracts", $langs->trans("List"), 1 ,$user->rights->contrat->lire);
                if ($leftmenu=="contracts") $newmenu->add("/contrat/services.php?leftmenu=contracts", $langs->trans("MenuServices"), 1 ,$user->rights->contrat->lire);
                if ($leftmenu=="contracts") $newmenu->add("/contrat/services.php?leftmenu=contracts&amp;mode=0", $langs->trans("MenuInactiveServices"), 2 ,$user->rights->contrat->lire);
                if ($leftmenu=="contracts") $newmenu->add("/contrat/services.php?leftmenu=contracts&amp;mode=4", $langs->trans("MenuRunningServices"), 2 ,$user->rights->contrat->lire);
                if ($leftmenu=="contracts") $newmenu->add("/contrat/services.php?leftmenu=contracts&amp;mode=4&amp;filter=expired", $langs->trans("MenuExpiredServices"), 2 ,$user->rights->contrat->lire);
                if ($leftmenu=="contracts") $newmenu->add("/contrat/services.php?leftmenu=contracts&amp;mode=5", $langs->trans("MenuClosedServices"), 2 ,$user->rights->contrat->lire);
            }

            // Interventions
            if (! empty($conf->ficheinter->enabled))
            {
                $langs->load("interventions");
                $newmenu->add("/fichinter/index.php?leftmenu=ficheinter", $langs->trans("Interventions"), 0, $user->rights->ficheinter->lire);
                if ($leftmenu=="ficheinter") $newmenu->add("/fichinter/fiche.php?action=create&leftmenu=ficheinter", $langs->trans("NewIntervention"), 1, $user->rights->ficheinter->creer);
                if ($leftmenu=="ficheinter") $newmenu->add("/fichinter/index.php?leftmenu=ficheinter", $langs->trans("List"), 1 ,$user->rights->ficheinter->lire);
            }

        }


        /*
         * Menu Consultations (Factures)
         */
        if ($mainmenu == 'accountancy')
        {
            $langs->load("companies");
            $langs->load("cabinetmed@cabinetmed");

            // Customers invoices
            if ($conf->facture->enabled)
            {
                $langs->load("bills");
                $newmenu->add("/cabinetmed/xxx.php?leftmenu=customers_bills",$langs->trans("Consultations"),0,$user->rights->facture->lire);
                if ($user->societe_id == 0)
                {
                    $newmenu->add("/cabinetmed/xxx.php?action=create&amp;leftmenu=customers_bills",$langs->trans("NewConsultation"),1,$user->rights->facture->creer);
                }

                //$newmenu->add("/compta/facture/impayees.php?leftmenu=customers_bills",$langs->trans("Unpaid"),1,$user->rights->facture->lire);

                $newmenu->add("/compta/paiement/liste.php?leftmenu=customers_bills_payments",$langs->trans("Payments"),1,$user->rights->facture->lire);

                if ($conf->global->BILL_ADD_PAYMENT_VALIDATION)
                {
                    $newmenu->add("/compta/paiement/avalider.php?leftmenu=customers_bills_payments",$langs->trans("MenuToValid"),2,$user->rights->facture->lire);
                }
                $newmenu->add("/compta/paiement/rapport.php?leftmenu=customers_bills_payments",$langs->trans("Reportings"),2,$user->rights->facture->lire);

                //$newmenu->add("/compta/facture/stats/index.php?leftmenu=customers_bills", $langs->trans("Statistics"),1,$user->rights->facture->lire);
            }

            // Suppliers
            if ($conf->societe->enabled && $conf->fournisseur->enabled)
            {
                if ($conf->facture->enabled)
                {
                    $langs->load("bills");
                    $newmenu->add("/fourn/facture/index.php?leftmenu=suppliers_bills", $langs->trans("BillsSuppliers"),0,$user->rights->fournisseur->facture->lire);
                    if ($user->societe_id == 0)
                    {
                        $newmenu->add("/fourn/facture/fiche.php?action=create",$langs->trans("NewBill"),1,$user->rights->fournisseur->facture->creer);
                    }
                    $newmenu->add("/fourn/facture/impayees.php", $langs->trans("Unpaid"),1,$user->rights->fournisseur->facture->lire);
                    $newmenu->add("/fourn/facture/paiement.php", $langs->trans("Payments"),1,$user->rights->fournisseur->facture->lire);

                    $newmenu->add("/compta/facture/stats/index.php?leftmenu=suppliers_bills&mode=supplier", $langs->trans("Statistics"),1,$user->rights->fournisseur->facture->lire);
                }
            }

            // Orders
            if ($conf->commande->enabled)
            {
                $langs->load("orders");
                if ($conf->facture->enabled) $newmenu->add("/compta/commande/liste.php?leftmenu=orders&amp;status=3&amp;afacturer=1", $langs->trans("MenuOrdersToBill"), 0, $user->rights->commande->lire);
                //                  if ($leftmenu=="orders") $newmenu->add("/commande/", $langs->trans("StatusOrderToBill"), 1 ,$user->rights->commande->lire);
            }

            // Donations
            if ($conf->don->enabled)
            {
                $langs->load("donations");
                $newmenu->add("/compta/dons/index.php?leftmenu=donations&amp;mainmenu=accountancy",$langs->trans("Donations"), 0, $user->rights->don->lire);
                if ($leftmenu=="donations") $newmenu->add("/compta/dons/fiche.php?action=create",$langs->trans("NewDonation"), 1, $user->rights->don->creer);
                if ($leftmenu=="donations") $newmenu->add("/compta/dons/liste.php",$langs->trans("List"), 1, $user->rights->don->lire);
                if ($leftmenu=="donations") $newmenu->add("/compta/dons/stats.php",$langs->trans("Statistics"), 1, $user->rights->don->lire);
            }

            // Deplacements
            if ($conf->deplacement->enabled)
            {
                $langs->load("trips");
                $newmenu->add("/compta/deplacement/index.php?leftmenu=tripsandexpenses&amp;mainmenu=accountancy", $langs->trans("TripsAndExpenses"), 0, $user->rights->deplacement->lire);
                if ($leftmenu=="tripsandexpenses") $newmenu->add("/compta/deplacement/fiche.php?action=create&amp;leftmenu=tripsandexpenses&amp;mainmenu=accountancy", $langs->trans("New"), 1, $user->rights->deplacement->creer);
                if ($leftmenu=="tripsandexpenses") $newmenu->add("/compta/deplacement/index.php?leftmenu=tripsandexpenses&amp;mainmenu=accountancy", $langs->trans("List"), 1, $user->rights->deplacement->lire);
                if ($leftmenu=="tripsandexpenses") $newmenu->add("/compta/deplacement/stats/index.php?leftmenu=tripsandexpenses&amp;mainmenu=accountancy", $langs->trans("Statistics"), 1, $user->rights->deplacement->lire);
            }

            // Taxes and social contributions
            if ($conf->tax->enabled)
            {
                $newmenu->add("/compta/charges/index.php?leftmenu=tax&amp;mainmenu=accountancy",$langs->trans("MenuTaxAndDividends"), 0, $user->rights->tax->charges->lire);
                if (preg_match('/^tax/i',$leftmenu)) $newmenu->add("/compta/sociales/index.php?leftmenu=tax_social",$langs->trans("MenuSocialContributions"),1,$user->rights->tax->charges->lire);
                if (preg_match('/^tax/i',$leftmenu)) $newmenu->add("/compta/sociales/charges.php?leftmenu=tax_social&action=create",$langs->trans("MenuNewSocialContribution"), 2, $user->rights->tax->charges->creer);
                if (preg_match('/^tax/i',$leftmenu)) $newmenu->add("/compta/charges/index.php?leftmenu=tax_social&amp;mainmenu=accountancy&amp;mode=sconly",$langs->trans("Payments"), 2, $user->rights->tax->charges->lire);
                // VAT
                if ($conf->compta->tva)
                {
                    if (preg_match('/^tax/i',$leftmenu)) $newmenu->add("/compta/tva/index.php?leftmenu=tax_vat&amp;mainmenu=accountancy",$langs->trans("VAT"),1,$user->rights->tax->charges->lire);
                    if (preg_match('/^tax/i',$leftmenu)) $newmenu->add("/compta/tva/fiche.php?leftmenu=tax_vat&action=create",$langs->trans("NewPayment"),2,$user->rights->tax->charges->creer);
                    if (preg_match('/^tax/i',$leftmenu)) $newmenu->add("/compta/tva/reglement.php?leftmenu=tax_vat",$langs->trans("Payments"),2,$user->rights->tax->charges->lire);
                    if (preg_match('/^tax/i',$leftmenu)) $newmenu->add("/compta/tva/clients.php?leftmenu=tax_vat", $langs->trans("ReportByCustomers"), 2, $user->rights->tax->charges->lire);
                    if (preg_match('/^tax/i',$leftmenu)) $newmenu->add("/compta/tva/quadri_detail.php?leftmenu=tax_vat", $langs->trans("ReportByQuarter"), 2, $user->rights->tax->charges->lire);
                }
            }

            // Compta simple
            if ($conf->compta->enabled && $conf->global->FACTURE_VENTILATION)
            {
                $newmenu->add("/compta/ventilation/index.php?leftmenu=ventil",$langs->trans("Dispatch"),0,$user->rights->compta->ventilation->lire);
                if ($leftmenu=="ventil") $newmenu->add("/compta/ventilation/liste.php",$langs->trans("ToDispatch"),1,$user->rights->compta->ventilation->lire);
                if ($leftmenu=="ventil") $newmenu->add("/compta/ventilation/lignes.php",$langs->trans("Dispatched"),1,$user->rights->compta->ventilation->lire);
                if ($leftmenu=="ventil") $newmenu->add("/compta/param/",$langs->trans("Setup"),1,$user->rights->compta->ventilation->parametrer);
                if ($leftmenu=="ventil") $newmenu->add("/compta/param/comptes/fiche.php?action=create",$langs->trans("New"),2,$user->rights->compta->ventilation->parametrer);
                if ($leftmenu=="ventil") $newmenu->add("/compta/param/comptes/liste.php",$langs->trans("List"),2,$user->rights->compta->ventilation->parametrer);
                if ($leftmenu=="ventil") $newmenu->add("/compta/export/",$langs->trans("Export"),1,$user->rights->compta->ventilation->lire);
                if ($leftmenu=="ventil") $newmenu->add("/compta/export/index.php?action=export",$langs->trans("New"),2,$user->rights->compta->ventilation->lire);
                if ($leftmenu=="ventil") $newmenu->add("/compta/export/liste.php",$langs->trans("List"),2,$user->rights->compta->ventilation->lire);
            }

            // Compta expert
            if ($conf->accounting->enabled)
            {

            }

            // Rapports
            if ($conf->compta->enabled || $conf->accounting->enabled)
            {
                $langs->load("compta");

                // Bilan, resultats
                $newmenu->add("/compta/resultat/index.php?leftmenu=ca&amp;mainmenu=accountancy",$langs->trans("Reportings"),0,$user->rights->compta->resultat->lire||$user->rights->accounting->comptarapport->lire);

                if ($leftmenu=="ca") $newmenu->add("/compta/resultat/index.php?leftmenu=ca",$langs->trans("ReportInOut"),1,$user->rights->compta->resultat->lire||$user->rights->accounting->comptarapport->lire);
                if ($leftmenu=="ca") $newmenu->add("/compta/resultat/clientfourn.php?leftmenu=ca",$langs->trans("ByCompanies"),2,$user->rights->compta->resultat->lire||$user->rights->accounting->comptarapport->lire);
                /* On verra ca avec module compabilite expert
                 if ($leftmenu=="ca") $newmenu->add("/compta/resultat/compteres.php?leftmenu=ca","Compte de resultat",2,$user->rights->compta->resultat->lire);
                 if ($leftmenu=="ca") $newmenu->add("/compta/resultat/bilan.php?leftmenu=ca","Bilan",2,$user->rights->compta->resultat->lire);
                 */
                if ($leftmenu=="ca") $newmenu->add("/compta/stats/index.php?leftmenu=ca",$langs->trans("ReportTurnover"),1,$user->rights->compta->resultat->lire||$user->rights->accounting->comptarapport->lire);

                /*
                 if ($leftmenu=="ca") $newmenu->add("/compta/stats/cumul.php?leftmenu=ca","Cumule",2,$user->rights->compta->resultat->lire);
                 if ($conf->propal->enabled) {
                 if ($leftmenu=="ca") $newmenu->add("/compta/stats/prev.php?leftmenu=ca","Previsionnel",2,$user->rights->compta->resultat->lire);
                 if ($leftmenu=="ca") $newmenu->add("/compta/stats/comp.php?leftmenu=ca","Transforme",2,$user->rights->compta->resultat->lire);
                 }
                 */
                if ($leftmenu=="ca") $newmenu->add("/compta/stats/casoc.php?leftmenu=ca",$langs->trans("ByCompanies"),2,$user->rights->compta->resultat->lire||$user->rights->accounting->comptarapport->lire);
                if ($leftmenu=="ca") $newmenu->add("/compta/stats/cabyuser.php?leftmenu=ca",$langs->trans("ByUsers"),2,$user->rights->compta->resultat->lire||$user->rights->accounting->comptarapport->lire);

                // Journaux
 				//if ($leftmenu=="ca") $newmenu->add("/compta/journaux/index.php?leftmenu=ca",$langs->trans("Journaux"),1,$user->rights->compta->resultat->lire||$user->rights->accounting->comptarapport->lire);
                //journaux
                if ($leftmenu=="ca") $newmenu->add("/compta/journal/sellsjournal.php?leftmenu=ca",$langs->trans("SellsJournal"),1,$user->rights->compta->resultat->lire||$user->rights->accounting->comptarapport->lire);
                if ($leftmenu=="ca") $newmenu->add("/compta/journal/purchasesjournal.php?leftmenu=ca",$langs->trans("PurchasesJournal"),1,$user->rights->compta->resultat->lire||$user->rights->accounting->comptarapport->lire);
            }
        }


        /*
         * Menu BANK
         */
        if ($mainmenu == 'bank')
        {
            $langs->load("withdrawals");
            $langs->load("banks");
            $langs->load("bills");

            // Bank-Caisse
            if ($conf->banque->enabled)
            {
                $langs->load("banks");
                $newmenu->add("/compta/bank/index.php?leftmenu=bank&amp;mainmenu=bank",$langs->trans("MenuBankCash"),0,$user->rights->banque->lire);

                $newmenu->add_submenu("/compta/bank/fiche.php?action=create",$langs->trans("MenuNewFinancialAccount"),1,$user->rights->banque->configurer);
                $newmenu->add_submenu("/compta/bank/categ.php",$langs->trans("Rubriques"),1,$user->rights->banque->configurer);

                $newmenu->add_submenu("/compta/bank/search.php",$langs->trans("ListTransactions"),1,$user->rights->banque->lire);
                $newmenu->add_submenu("/compta/bank/budget.php",$langs->trans("ListTransactionsByCategory"),1,$user->rights->banque->lire);

                $newmenu->add_submenu("/compta/bank/virement.php",$langs->trans("BankTransfers"),1,$user->rights->banque->transfer);
            }

            // Prelevements
            if ($conf->prelevement->enabled)
            {
                $newmenu->add("/compta/prelevement/index.php?leftmenu=withdraw&amp;mainmenu=bank",$langs->trans("StandingOrders"),0,$user->rights->prelevement->bons->lire);

                if ($leftmenu=="withdraw") $newmenu->add("/compta/prelevement/create.php?mainmenu=bank",$langs->trans("NewStandingOrder"),1,$user->rights->prelevement->bons->creer);

                //if ($leftmenu=="withdraw") $newmenu->add("/compta/prelevement/demandes.php",$langs->trans("StandingOrder"),1,$user->rights->prelevement->bons->lire);
                if ($leftmenu=="withdraw") $newmenu->add("/compta/prelevement/demandes.php?status=0&amp;mainmenu=bank",$langs->trans("StandingOrderToProcess"),1,$user->rights->prelevement->bons->lire);
                //if ($leftmenu=="withdraw") $newmenu->add("/compta/prelevement/demandes.php?status=1",$langs->trans("StandingOrderProcessed"),2,$user->rights->prelevement->bons->lire);

                if ($leftmenu=="withdraw") $newmenu->add("/compta/prelevement/bons.php?mainmenu=bank",$langs->trans("WithdrawalsReceipts"),1,$user->rights->prelevement->bons->lire);
                if ($leftmenu=="withdraw") $newmenu->add("/compta/prelevement/liste.php?mainmenu=bank",$langs->trans("WithdrawalsLines"),1,$user->rights->prelevement->bons->lire);
                if ($leftmenu=="withdraw") $newmenu->add("/compta/prelevement/rejets.php?mainmenu=bank",$langs->trans("Rejects"),1,$user->rights->prelevement->bons->lire);
                if ($leftmenu=="withdraw") $newmenu->add("/compta/prelevement/stats.php?mainmenu=bank",$langs->trans("Statistics"),1,$user->rights->prelevement->bons->lire);

                //if ($leftmenu=="withdraw") $newmenu->add("/compta/prelevement/config.php",$langs->trans("Setup"),1,$user->rights->prelevement->bons->configurer);
            }

            // Gestion cheques
            if ($conf->banque->enabled)
            {
                $newmenu->add("/compta/paiement/cheque/index.php?leftmenu=checks&amp;mainmenu=bank",$langs->trans("MenuChequeDeposits"),0,$user->rights->banque->cheque);
                $newmenu->add("/compta/paiement/cheque/fiche.php?leftmenu=checks&amp;action=new&amp;mainmenu=bank",$langs->trans("NewChequeDeposit"),1,$user->rights->banque->cheque);
                $newmenu->add("/compta/paiement/cheque/liste.php?leftmenu=checks&amp;mainmenu=bank",$langs->trans("List"),1,$user->rights->banque->cheque);
            }

       }

        /*
         * Menu PRODUITS-SERVICES
         */
        if ($mainmenu == 'products')
        {
            // Products
            if ($conf->product->enabled)
            {
                $newmenu->add("/product/index.php?leftmenu=product&amp;type=0", $langs->trans("Products"), 0, $user->rights->produit->lire);
                if ($user->societe_id == 0)
                {
                    $newmenu->add("/product/fiche.php?leftmenu=product&amp;action=create&amp;type=0", $langs->trans("NewProduct"), 1, $user->rights->produit->creer);
                    $newmenu->add("/product/liste.php?leftmenu=product&amp;type=0", $langs->trans("List"), 1, $user->rights->produit->lire);
                }
                if ($conf->propal->enabled)
                {
                    $newmenu->add("/product/popuprop.php?leftmenu=stats&amp;type=0", $langs->trans("Popularity"), 1, $user->rights->produit->lire && $user->rights->propale->lire);
                }
                if ($conf->stock->enabled)
                {
                    $newmenu->add("/product/reassort.php?type=0", $langs->trans("Stocks"), 1, $user->rights->produit->lire && $user->rights->stock->lire);
                }
            }

            // Services
            if ($conf->service->enabled)
            {
                $newmenu->add("/product/index.php?leftmenu=service&amp;type=1", $langs->trans("Services"), 0, $user->rights->service->lire);
                if ($user->societe_id == 0)
                {
                    $newmenu->add("/product/fiche.php?leftmenu=service&amp;action=create&amp;type=1", $langs->trans("NewService"), 1, $user->rights->service->creer);
                }
                $newmenu->add("/product/liste.php?leftmenu=service&amp;type=1", $langs->trans("List"), 1, $user->rights->service->lire);
                if ($conf->propal->enabled)
                {
                    $newmenu->add("/product/popuprop.php?leftmenu=stats&amp;type=1", $langs->trans("Popularity"), 1, $user->rights->service->lire && $user->rights->propale->lire);
                }
            }

            // Categories
            if ($conf->categorie->enabled)
            {
                $langs->load("categories");
                $newmenu->add("/categories/index.php?leftmenu=cat&amp;type=0", $langs->trans("Categories"), 0, $user->rights->categorie->lire);
                if ($user->societe_id == 0)
                {
                    $newmenu->add("/categories/fiche.php?action=create&amp;type=0", $langs->trans("NewCategory"), 1, $user->rights->categorie->creer);
                }
                //if ($leftmenu=="cat") $newmenu->add("/categories/liste.php", $langs->trans("List"), 1, $user->rights->categorie->lire);
            }

            // Stocks
            if ($conf->stock->enabled)
            {
                $langs->load("stocks");
                $newmenu->add("/product/stock/index.php?leftmenu=stock", $langs->trans("Stocks"), 0, $user->rights->stock->lire);
                if ($leftmenu=="stock") $newmenu->add("/product/stock/fiche.php?action=create", $langs->trans("MenuNewWarehouse"), 1, $user->rights->stock->creer);
                if ($leftmenu=="stock") $newmenu->add("/product/stock/liste.php", $langs->trans("List"), 1, $user->rights->stock->lire);
                if ($leftmenu=="stock") $newmenu->add("/product/stock/valo.php", $langs->trans("EnhancedValue"), 1, $user->rights->stock->lire);
                if ($leftmenu=="stock") $newmenu->add("/product/stock/mouvement.php", $langs->trans("Movements"), 1, $user->rights->stock->mouvement->lire);
            }

            // Expeditions
            if ($conf->expedition->enabled)
            {
                $langs->load("sendings");
                $newmenu->add("/expedition/index.php?leftmenu=sendings", $langs->trans("Shipments"), 0, $user->rights->expedition->lire);
                if ($leftmenu=="sendings") $newmenu->add("/expedition/liste.php?leftmenu=sendings", $langs->trans("List"), 1 ,$user->rights->expedition->lire);
                if ($leftmenu=="sendings") $newmenu->add("/expedition/stats/index.php?leftmenu=sendings", $langs->trans("Statistics"), 1 ,$user->rights->expedition->lire);
            }

        }


        /*
         * Menu FOURNISSEURS
         */
        if ($mainmenu == 'suppliers')
        {
            $langs->load("suppliers");

            if ($conf->societe->enabled && $conf->fournisseur->enabled)
            {
                $newmenu->add("/fourn/index.php?leftmenu=suppliers", $langs->trans("Suppliers"), 0, $user->rights->societe->lire && $user->rights->fournisseur->lire);

                // Security check
                if ($user->societe_id == 0)
                {
                    $newmenu->add("/societe/soc.php?leftmenu=suppliers&amp;action=create&amp;type=f",$langs->trans("NewSupplier"), 1, $user->rights->societe->creer && $user->rights->fournisseur->lire);
                }
                $newmenu->add("/fourn/liste.php",$langs->trans("List"), 1, $user->rights->societe->lire && $user->rights->fournisseur->lire);
                $newmenu->add("/contact/index.php?leftmenu=suppliers&amp;type=f",$langs->trans("Contacts"), 1, $user->rights->societe->contact->lire && $user->rights->fournisseur->lire);
                $newmenu->add("/fourn/stats.php",$langs->trans("Statistics"), 1, $user->rights->societe->lire && $user->rights->fournisseur->lire);
            }

            if ($conf->facture->enabled)
            {
                $langs->load("bills");
                $newmenu->add("/fourn/facture/index.php", $langs->trans("Bills"), 0, $user->rights->fournisseur->facture->lire);

                if ($user->societe_id == 0)
                {
                    $newmenu->add("/fourn/facture/fiche.php?action=create",$langs->trans("NewBill"), 1, $user->rights->fournisseur->facture->creer);
                }

                $newmenu->add("/fourn/facture/paiement.php", $langs->trans("Payments"), 1, $user->rights->fournisseur->facture->lire);
            }

            if ($conf->fournisseur->enabled)
            {
                $langs->load("orders");
                $newmenu->add("/fourn/commande/index.php?leftmenu=suppliers",$langs->trans("Orders"), 0, $user->rights->fournisseur->commande->lire);
                $newmenu->add("/societe/societe.php?leftmenu=supplier", $langs->trans("NewOrder"), 1, $user->rights->fournisseur->commande->creer);
                $newmenu->add("/fourn/commande/liste.php?leftmenu=suppliers", $langs->trans("List"), 1, $user->rights->fournisseur->commande->lire);
            }

            if ($conf->categorie->enabled)
            {
                $langs->load("categories");
                $newmenu->add("/categories/index.php?leftmenu=cat&amp;type=1", $langs->trans("Categories"), 0, $user->rights->categorie->lire);
                if ($user->societe_id == 0)
                {
                    $newmenu->add("/categories/fiche.php?action=create&amp;type=1", $langs->trans("NewCategory"), 1, $user->rights->categorie->creer);
                }
                //if ($leftmenu=="cat") $newmenu->add("/categories/liste.php", $langs->trans("List"), 1, $user->rights->categorie->lire);
            }

        }

        /*
         * Menu PROJECTS
         */
        if ($mainmenu == 'project')
        {
            if ($conf->projet->enabled)
            {
                $langs->load("projects");

                // Project affected to user
                $newmenu->add("/projet/index.php?leftmenu=projects&mode=mine", $langs->trans("MyProjects"), 0, $user->rights->projet->lire);
                $newmenu->add("/projet/fiche.php?leftmenu=projects&action=create&mode=mine", $langs->trans("NewProject"), 1, $user->rights->projet->creer);
                $newmenu->add("/projet/liste.php?leftmenu=projects&mode=mine", $langs->trans("List"), 1, $user->rights->projet->lire);

                // All project i have permission on
                $newmenu->add("/projet/index.php?leftmenu=projects", $langs->trans("Projects"), 0, $user->rights->projet->lire && $user->rights->projet->lire);
                $newmenu->add("/projet/fiche.php?leftmenu=projects&action=create", $langs->trans("NewProject"), 1, $user->rights->projet->creer && $user->rights->projet->creer);
                $newmenu->add("/projet/liste.php?leftmenu=projects", $langs->trans("List"), 1, $user->rights->projet->lire && $user->rights->projet->lire);

                // Project affected to user
                $newmenu->add("/projet/activity/index.php?mode=mine", $langs->trans("MyActivities"), 0, $user->rights->projet->lire);
                $newmenu->add("/projet/tasks.php?action=create&mode=mine", $langs->trans("NewTask"), 1, $user->rights->projet->creer);
                $newmenu->add("/projet/tasks/index.php?mode=mine", $langs->trans("List"), 1, $user->rights->projet->lire);
                $newmenu->add("/projet/activity/list.php?mode=mine", $langs->trans("NewTimeSpent"), 1, $user->rights->projet->creer);

                // All project i have permission on
                $newmenu->add("/projet/activity/index.php", $langs->trans("Activities"), 0, $user->rights->projet->lire && $user->rights->projet->lire);
                $newmenu->add("/projet/tasks.php?action=create", $langs->trans("NewTask"), 1, $user->rights->projet->creer && $user->rights->projet->creer);
                $newmenu->add("/projet/tasks/index.php", $langs->trans("List"), 1, $user->rights->projet->lire && $user->rights->projet->lire);
                $newmenu->add("/projet/activity/list.php", $langs->trans("NewTimeSpent"), 1, $user->rights->projet->creer && $user->rights->projet->creer);
            }
        }


        /*
         * Menu OUTILS
         */
        if ($mainmenu == 'tools')
        {

            if (! empty($conf->mailing->enabled))
            {
                $langs->load("mails");

                $newmenu->add("/comm/mailing/index.php?leftmenu=mailing", $langs->trans("EMailings"), 0, $user->rights->mailing->lire);
                $newmenu->add("/comm/mailing/fiche.php?leftmenu=mailing&amp;action=create", $langs->trans("NewMailing"), 1, $user->rights->mailing->creer);
                $newmenu->add("/comm/mailing/liste.php?leftmenu=mailing", $langs->trans("List"), 1, $user->rights->mailing->lire);
            }

            if (! empty($conf->export->enabled))
            {
                $langs->load("exports");
                $newmenu->add("/exports/index.php?leftmenu=export",$langs->trans("FormatedExport"),0, $user->rights->export->lire);
                $newmenu->add("/exports/export.php?leftmenu=export",$langs->trans("NewExport"),1, $user->rights->export->creer);
                //$newmenu->add("/exports/export.php?leftmenu=export",$langs->trans("List"),1, $user->rights->export->lire);
            }

            if (! empty($conf->import->enabled))
            {
                $langs->load("exports");
                $newmenu->add("/imports/index.php?leftmenu=import",$langs->trans("FormatedImport"),0, $user->rights->import->run);
                $newmenu->add("/imports/import.php?leftmenu=import",$langs->trans("NewImport"),1, $user->rights->import->run);
            }

            if (! empty($conf->domain->enabled))
            {
                $langs->load("domains");
                $newmenu->add("/domain/index.php?leftmenu=export",$langs->trans("DomainNames"),0, $user->rights->domain->read);
                $newmenu->add("/domain/fiche.php?action=create&leftmenu=export",$langs->trans("NewDomain"),1, $user->rights->domain->create);
                $newmenu->add("/domain/index.php?leftmenu=export",$langs->trans("List"),1, $user->rights->domain->read);
            }
        }

        /*
         * Menu MEMBERS
         */
        if ($mainmenu == 'members')
        {
            if ($conf->adherent->enabled)
            {
                $langs->load("members");
                $langs->load("compta");

                $newmenu->add("/adherents/index.php?leftmenu=members&amp;mainmenu=members",$langs->trans("Members"),0,$user->rights->adherent->lire);
                $newmenu->add("/adherents/fiche.php?leftmenu=members&amp;action=create",$langs->trans("NewMember"),1,$user->rights->adherent->creer);
                $newmenu->add("/adherents/liste.php?leftmenu=members",$langs->trans("List"),1,$user->rights->adherent->lire);
                $newmenu->add("/adherents/liste.php?leftmenu=members&amp;statut=-1",$langs->trans("MenuMembersToValidate"),2,$user->rights->adherent->lire);
                $newmenu->add("/adherents/liste.php?leftmenu=members&amp;statut=1",$langs->trans("MenuMembersValidated"),2,$user->rights->adherent->lire);
                $newmenu->add("/adherents/liste.php?leftmenu=members&amp;statut=1&amp;filter=uptodate",$langs->trans("MenuMembersUpToDate"),2,$user->rights->adherent->lire);
                $newmenu->add("/adherents/liste.php?leftmenu=members&amp;statut=1&amp;filter=outofdate",$langs->trans("MenuMembersNotUpToDate"),2,$user->rights->adherent->lire);
                $newmenu->add("/adherents/liste.php?leftmenu=members&amp;statut=0",$langs->trans("MenuMembersResiliated"),2,$user->rights->adherent->lire);
                $newmenu->add("/adherents/stats/index.php?leftmenu=members",$langs->trans("MenuMembersStats"),1,$user->rights->adherent->lire);

                $newmenu->add("/adherents/index.php?leftmenu=members&amp;mainmenu=members",$langs->trans("Subscriptions"),0,$user->rights->adherent->cotisation->lire);
                $newmenu->add("/adherents/liste.php?leftmenu=members&amp;statut=-1,1&amp;mainmenu=members",$langs->trans("NewSubscription"),1,$user->rights->adherent->cotisation->creer);
                $newmenu->add("/adherents/cotisations.php?leftmenu=members",$langs->trans("List"),1,$user->rights->adherent->cotisation->lire);


                if ($conf->categorie->enabled)
                {
                    $langs->load("categories");
                    $newmenu->add("/categories/index.php?leftmenu=cat&amp;type=3", $langs->trans("Categories"), 0, $user->rights->categorie->lire);
                    if ($user->societe_id == 0)
                    {
                        $newmenu->add("/categories/fiche.php?action=create&amp;type=3", $langs->trans("NewCategory"), 1, $user->rights->categorie->creer);
                    }
                    //if ($leftmenu=="cat") $newmenu->add("/categories/liste.php", $langs->trans("List"), 1, $user->rights->categorie->lire);
                }

                $newmenu->add("/adherents/index.php?leftmenu=export&amp;mainmenu=members",$langs->trans("Exports"),0,$user->rights->adherent->export);
                if ($conf->export->enabled && $leftmenu=="export") $newmenu->add("/exports/index.php?leftmenu=export",$langs->trans("Datas"),1,$user->rights->adherent->export);
                if ($leftmenu=="export") $newmenu->add("/adherents/htpasswd.php?leftmenu=export",$langs->trans("Filehtpasswd"),1,$user->rights->adherent->export);
                if ($leftmenu=="export") $newmenu->add("/adherents/cartes/carte.php?leftmenu=export",$langs->trans("MembersCards"),1,$user->rights->adherent->export);

                $newmenu->add("/adherents/public.php?leftmenu=member_public",$langs->trans("MemberPublicLinks"));

                $newmenu->add("/adherents/index.php?leftmenu=setup&amp;mainmenu=members",$langs->trans("Setup"),0,$user->rights->adherent->configurer);
                $newmenu->add("/adherents/type.php?leftmenu=setup&amp;",$langs->trans("MembersTypes"),1,$user->rights->adherent->configurer);
                $newmenu->add("/adherents/options.php?leftmenu=setup&amp;",$langs->trans("MembersAttributes"),1,$user->rights->adherent->configurer);


            }

        }

        // Affichage des menus personnalises
        require_once(DOL_DOCUMENT_ROOT."/core/class/menubase.class.php");

        $menuArbo = new Menubase($db,'cabinetmed','left');
        $newmenu = $menuArbo->menuLeftCharger($newmenu,$mainmenu,$leftmenu,($user->societe_id?1:0),'cabinetmed');
    }


    /**
     *  Si on est sur un cas gere de surcharge du menu, on ecrase celui par defaut
     */
    //var_dump($menu_array_before);exit;
    //var_dump($menu_array_after);exit;
    $menu_array=$newmenu->liste;
    if (is_array($menu_array_before)) $menu_array=array_merge($menu_array_before, $menu_array);
    if (is_array($menu_array_after))  $menu_array=array_merge($menu_array, $menu_array_after);

    // Show menu
    $alt=0;
    if (is_array($menu_array))
    {
        for ($i = 0 ; $i < sizeof($menu_array) ; $i++)
        {
            $alt++;
            if (empty($menu_array[$i]['level']))
            {
                if (($alt%2==0))
                {
                    print '<div class="blockvmenuimpair">'."\n";
                }
                else
                {
                    print '<div class="blockvmenupair">'."\n";
                }
            }

            // Place tabulation
            $tabstring='';
            $tabul=($menu_array[$i]['level'] - 1);
            if ($tabul > 0)
            {
                for ($j=0; $j < $tabul; $j++)
                {
                    $tabstring.='&nbsp; &nbsp;';
                }
            }

            // For external modules
            $url = dol_buildpath($menu_array[$i]['url'], 1);

            // Menu niveau 0
            if ($menu_array[$i]['level'] == 0)
            {
                if ($menu_array[$i]['enabled'])
                {
                    print '<div class="menu_titre">'.$tabstring.'<a class="vmenu" href="'.$url.'"'.($menu_array[$i]['target']?' target="'.$menu_array[$i]['target'].'"':'').'>'.$menu_array[$i]['titre'].'</a></div>'."\n";
                }
                else if (empty($conf->global->MAIN_MENU_HIDE_UNAUTHORIZED))
                {
                    print '<div class="menu_titre">'.$tabstring.'<font class="vmenudisabled">'.$menu_array[$i]['titre'].'</font></div>'."\n";
                }
                print '<div class="menu_top"></div>'."\n";
            }
            // Menu niveau > 0
            if ($menu_array[$i]['level'] > 0)
            {
                if ($menu_array[$i]['enabled'])
                {
                	print '<div class="menu_contenu">'.$tabstring;
                    if ($menu_array[$i]['url']) print '<a class="vsmenu" href="'.$url.'"'.($menu_array[$i]['target']?' target="'.$menu_array[$i]['target'].'"':'').'>';
                    print $menu_array[$i]['titre'];
                    if ($menu_array[$i]['url']) print '</a>';
                    // If title is not pure text and contains a table, no carriage return added
                    if (! strstr($menu_array[$i]['titre'],'<table')) print '<br>';
                    print '</div>'."\n";
                }
                else if (empty($conf->global->MAIN_MENU_HIDE_UNAUTHORIZED))
                {
                	print '<div class="menu_contenu">'.$tabstring.'<font class="vsmenudisabled">'.$menu_array[$i]['titre'].'</font><br></div>'."\n";
                }
            }

            // If next is a new block or end
            if (empty($menu_array[$i+1]['level']))
            {
                print '<div class="menu_end"></div>'."\n";
                print "</div>\n";
            }
        }
    }

    return sizeof($menu_array);
}


?>

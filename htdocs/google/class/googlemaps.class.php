<?php
/* Copyright (C) 2007-2011 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) ---Put here your own copyright and developer email---
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
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 *      \file       htdocs/google/class/googlemaps.class.php
 *      \ingroup    google
 *      \brief      This file is CRUD class file (Create/Read/Update/Delete)
 */

// Put here all includes required by your class file
//require_once(DOL_DOCUMENT_ROOT."/core/class/commonobject.class.php");
//require_once(DOL_DOCUMENT_ROOT."/societe/class/societe.class.php");
//require_once(DOL_DOCUMENT_ROOT."/product/class/product.class.php");


/**
 *	Googlemaps
 */
class Googlemaps // extends CommonObject
{
	var $db;							//!< To store db handler
	var $error;							//!< To return error code (or message)
	var $errors=array();				//!< To return several error codes (or messages)
	//var $element='googlemaps';			//!< Id that identify managed objects
	//var $table_element='googlemaps';	//!< Name of table without prefix where object is stored

    var $id;
    
	var $fk_object;
	var $latitude;
	var $longitude;

    


    /**
     *      Constructor
     *      
     *      @param      DB      Database handler
     */
    function Googlemaps($DB)
    {
        $this->db = $DB;
        return 1;
    }


    /**
     *      Create object into database
     *      
     *      @param      user        	User that create
     *      @param      notrigger	    0=launch triggers after, 1=disable triggers
     *      @return     int         	<0 if KO, Id of created object if OK
     */
    function create($user, $notrigger=0)
    {
    	global $conf, $langs;
		$error=0;

		// Clean parameters
        
		if (isset($this->fk_object)) $this->fk_object=trim($this->fk_object);
		if (isset($this->latitude)) $this->latitude=trim($this->latitude);
		if (isset($this->longitude)) $this->longitude=trim($this->longitude);

        

		// Check parameters
		// Put here code to add control on parameters values

        // Insert request
		$sql = "INSERT INTO ".MAIN_DB_PREFIX."google_maps(";
		
		$sql.= "fk_object,";
		$sql.= "latitude,";
		$sql.= "longitude";

		
        $sql.= ") VALUES (";
        
		$sql.= " ".(! isset($this->fk_object)?'NULL':"'".$this->fk_object."'").",";
		$sql.= " ".(! isset($this->latitude)?'NULL':"'".$this->latitude."'").",";
		$sql.= " ".(! isset($this->longitude)?'NULL':"'".$this->longitude."'")."";

        
		$sql.= ")";

		$this->db->begin();

	   	dol_syslog(get_class($this)."::create sql=".$sql, LOG_DEBUG);
        $resql=$this->db->query($sql);
    	if (! $resql) { $error++; $this->errors[]="Error ".$this->db->lasterror(); }

		if (! $error)
        {
            $this->id = $this->db->last_insert_id(MAIN_DB_PREFIX."google_maps");

			if (! $notrigger)
			{
	            // Uncomment this and change MYOBJECT to your own tag if you
	            // want this action call a trigger.

	            //// Call triggers
	            //include_once(DOL_DOCUMENT_ROOT . "/core/class/interfaces.class.php");
	            //$interface=new Interfaces($this->db);
	            //$result=$interface->run_triggers('MYOBJECT_CREATE',$this,$user,$langs,$conf);
	            //if ($result < 0) { $error++; $this->errors=$interface->errors; }
	            //// End call triggers
			}
        }

        // Commit or rollback
        if ($error)
		{
			foreach($this->errors as $errmsg)
			{
	            dol_syslog(get_class($this)."::create ".$errmsg, LOG_ERR);
	            $this->error.=($this->error?', '.$errmsg:$errmsg);
			}
			$this->db->rollback();
			return -1*$error;
		}
		else
		{
			$this->db->commit();
            return $this->id;
		}
    }


    /**
     *    Load object in memory from database
     *    
     *    @param      id          id object
     *    @return     int         <0 if KO, >0 if OK
     */
    function fetch($id)
    {
    	global $langs;
        $sql = "SELECT";
		$sql.= " t.rowid,";
		
		$sql.= " t.fk_object,";
		$sql.= " t.latitude,";
		$sql.= " t.longitude";

		
        $sql.= " FROM ".MAIN_DB_PREFIX."google_maps as t";
        $sql.= " WHERE t.fk_object = ".$id;

    	dol_syslog(get_class($this)."::fetch sql=".$sql, LOG_DEBUG);
        $resql=$this->db->query($sql);
        if ($resql)
        {
            if ($this->db->num_rows($resql))
            {
                $obj = $this->db->fetch_object($resql);

                $this->id    = $obj->rowid;
                
				$this->fk_object = $obj->fk_object;
				$this->latitude = $obj->latitude;
				$this->longitude = $obj->longitude;

                
            }
            $this->db->free($resql);

            return 1;
        }
        else
        {
      	    $this->error="Error ".$this->db->lasterror();
            dol_syslog(get_class($this)."::fetch ".$this->error, LOG_ERR);
            return -1;
        }
    }


    /**
     *      Update object into database
     *      
     *      @param      user        	User that modify
     *      @param      notrigger	    0=launch triggers after, 1=disable triggers
     *      @return     int         	<0 if KO, >0 if OK
     */
    function update($user=0, $notrigger=0)
    {
    	global $conf, $langs;
		$error=0;

		// Clean parameters
        
		if (isset($this->fk_object)) $this->fk_object=trim($this->fk_object);
		if (isset($this->latitude)) $this->latitude=trim($this->latitude);
		if (isset($this->longitude)) $this->longitude=trim($this->longitude);

        

		// Check parameters
		// Put here code to add control on parameters values

        // Update request
        $sql = "UPDATE ".MAIN_DB_PREFIX."google_maps SET";
        
		$sql.= " fk_object=".(isset($this->fk_object)?$this->fk_object:"null").",";
		$sql.= " latitude=".(isset($this->latitude)?$this->latitude:"null").",";
		$sql.= " longitude=".(isset($this->longitude)?$this->longitude:"null")."";

        
        $sql.= " WHERE rowid=".$this->id;

		$this->db->begin();

		dol_syslog(get_class($this)."::update sql=".$sql, LOG_DEBUG);
        $resql = $this->db->query($sql);
    	if (! $resql) { $error++; $this->errors[]="Error ".$this->db->lasterror(); }

		if (! $error)
		{
			if (! $notrigger)
			{
	            // Uncomment this and change MYOBJECT to your own tag if you
	            // want this action call a trigger.

	            //// Call triggers
	            //include_once(DOL_DOCUMENT_ROOT . "/core/class/interfaces.class.php");
	            //$interface=new Interfaces($this->db);
	            //$result=$interface->run_triggers('MYOBJECT_MODIFY',$this,$user,$langs,$conf);
	            //if ($result < 0) { $error++; $this->errors=$interface->errors; }
	            //// End call triggers
	    	}
		}

        // Commit or rollback
		if ($error)
		{
			foreach($this->errors as $errmsg)
			{
	            dol_syslog(get_class($this)."::update ".$errmsg, LOG_ERR);
	            $this->error.=($this->error?', '.$errmsg:$errmsg);
			}
			$this->db->rollback();
			return -1*$error;
		}
		else
		{
			$this->db->commit();
			return 1;
		}
    }


 	/**
	 *   Delete object in database
	 *   
     *	 @param     user        	User that delete
     *   @param     notrigger	    0=launch triggers after, 1=disable triggers
	 *   @return	int				<0 if KO, >0 if OK
	 */
	function delete($user, $notrigger=0)
	{
		global $conf, $langs;
		$error=0;

		$sql = "DELETE FROM ".MAIN_DB_PREFIX."google_maps";
		$sql.= " WHERE rowid=".$this->id;

		$this->db->begin();

		dol_syslog(get_class($this)."::delete sql=".$sql);
		$resql = $this->db->query($sql);
    	if (! $resql) { $error++; $this->errors[]="Error ".$this->db->lasterror(); }

		if (! $error)
		{
			if (! $notrigger)
			{
				// Uncomment this and change MYOBJECT to your own tag if you
		        // want this action call a trigger.

		        //// Call triggers
		        //include_once(DOL_DOCUMENT_ROOT . "/core/class/interfaces.class.php");
		        //$interface=new Interfaces($this->db);
		        //$result=$interface->run_triggers('MYOBJECT_DELETE',$this,$user,$langs,$conf);
		        //if ($result < 0) { $error++; $this->errors=$interface->errors; }
		        //// End call triggers
			}
		}

        // Commit or rollback
		if ($error)
		{
			foreach($this->errors as $errmsg)
			{
	            dol_syslog(get_class($this)."::delete ".$errmsg, LOG_ERR);
	            $this->error.=($this->error?', '.$errmsg:$errmsg);
			}
			$this->db->rollback();
			return -1*$error;
		}
		else
		{
			$this->db->commit();
			return 1;
		}
	}



	/**
	 *		Load an object from its id and create a new one in database
	 *
	 *		@param      fromid     		Id of object to clone
	 * 	 	@return		int				New id of clone
	 */
	function createFromClone($fromid)
	{
		global $user,$langs;

		$error=0;

		$object=new Googlemaps($this->db);

		$this->db->begin();

		// Load source object
		$object->fetch($fromid);
		$object->id=0;
		$object->statut=0;

		// Clear fields
		// ...

		// Create clone
		$result=$object->create($user);

		// Other options
		if ($result < 0)
		{
			$this->error=$object->error;
			$error++;
		}

		if (! $error)
		{



		}

		// End
		if (! $error)
		{
			$this->db->commit();
			return $object->id;
		}
		else
		{
			$this->db->rollback();
			return -1;
		}
	}


	/**
	 *		Initialisz object with example values
	 *		Id must be 0 if object instance is a specimen.
	 */
	function initAsSpecimen()
	{
		$this->id=0;
		
		$this->fk_object='';
		$this->latitude='';
		$this->longitude='';
	}

}
?>

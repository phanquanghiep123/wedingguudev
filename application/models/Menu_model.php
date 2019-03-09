<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    // Begin: =======================================================
    function get_list_menu($table)
    {
    	$sql = "SELECT * FROM $table ORDER BY Parent_ID,Sort, ID, Name"; 
		$query = $this->db->query($sql);
		
		// Create a multidimensional array to conatin a list of items and parents
		$menu = array(
		    'items' => array(),
		    'parents' => array()
		);
		// Builds the array lists with data from the menu table
		foreach($query->result_array() as $items)
		{
		    // Creates entry into items array with current menu item id ie. $menu['items'][1]
		    $menu['items'][$items['ID']] = $items;
		    // Creates entry into parents array. Parents array contains a list of all items with children
		    $menu['parents'][$items['Parent_ID']][] = $items['ID'];
		}
		
		return $menu;
    }


    function get_list_menu_group($table,$group_id)
    {
    	$sql = "SELECT * FROM $table WHERE Group_ID=$group_id  ORDER BY `ORDER`, ID, Name"; 
		$query = $this->db->query($sql);
		
		// Create a multidimensional array to conatin a list of items and parents
		$menu = array(
		    'items' => array(),
		    'parents' => array()
		);
		// Builds the array lists with data from the menu table
		foreach($query->result_array() as $items)
		{
		    // Creates entry into items array with current menu item id ie. $menu['items'][1]
		    $menu['items'][$items['ID']] = $items;
		    // Creates entry into parents array. Parents array contains a list of all items with children
		    $menu['parents'][$items['Parent_ID']][] = $items['ID'];
		}
		
		return $menu;
    }
    
    // Menu builder function, parentId 0 is the root
	function build_menu($parent, $menu,$class=""){
	   $html = "";
	   if (isset($menu['parents'][$parent]))
	   {
	   	  $cls='';
	   	  if($parent==0){$cls=$class;}
	      $html .= "<ul class='".$cls."'>\n";
	       foreach ($menu['parents'][$parent] as $itemId)
	       {
	       	  $target = '';
	       	  if (isset($menu['items'][$itemId]['Type']) && $menu['items'][$itemId]['Type'] == 'blank') {
          	 		$target = 'target="_blank"';
          	  }
	          if(!isset($menu['parents'][$itemId]))
	          {
	             $html .= "<li class='".$menu['items'][$itemId]['Class']."'><a class='nav-link' ".$target."  href='".$menu['items'][$itemId]['Url']."'>".urldecode($menu['items'][$itemId]['Name'])."</a>\n</li> \n";
	          }
	          if(isset($menu['parents'][$itemId]))
	          {
	          	 $href = '';
	          	 if (isset($menu['items'][$itemId]['Url']) && $menu['items'][$itemId]['Url']!=null && $menu['items'][$itemId]['Url']!='') {
	          	 	$href = "href='".$menu['items'][$itemId]['Url']."'";
	          	 }
	             $html .= "<li class='".$menu['items'][$itemId]['Class']."'><a class='nav-link' ".$target."  ".$href.">".urldecode($menu['items'][$itemId]['Name'])."</a> \n";
	             $html .= $this->build_menu($itemId, $menu);
	             $html .= "</li> \n";
	          }
	       }
	       $html .= "</ul> \n";
	   }
	   return $html;
	}

	function build_menu_admin($parent, $menu,$id=""){
	   $html = "";
	   if (isset($menu['parents'][$parent]))
	   {
	   	  $cls='';
	   	  if($parent==0){$cls=$id;}
	      $html .= "<ul id='".$cls."'>\n";
	       foreach ($menu['parents'][$parent] as $itemId)
	       {
	          if(!isset($menu['parents'][$itemId]))
	          {
	             $html .= "<li id='menu-".$menu['items'][$itemId]['ID']."' class='sortable'>\n  
	          			      <div class='ns-row'>
					            <div class='ns-title'>".$menu['items'][$itemId]['Name']."</div>
					            <div class='ns-url'>".$menu['items'][$itemId]['Url']."</div>
					            <div class='ns-class'>".@$menu['items'][$itemId]['Class']."</div>
					            <div class='ns-actions'>
					               <a href='#' class='edit-menu'>Chỉnh sửa</a> | 
                                   <a href='#' class='delete-menu'>Xóa</a>
					               <input type='hidden' id='menu_id' name='menu_id' value='".$menu['items'][$itemId]['ID']."'>
					            </div>
					         </div>
	                       </li> \n";
	          }
	          if(isset($menu['parents'][$itemId]))
	          {
	          	 $href='';
	          	 if(isset($menu['items'][$itemId]['Url']) && $menu['items'][$itemId]['Url']!=null && $menu['items'][$itemId]['Url']!=''){
	          	 	$href="href='".$menu['items'][$itemId]['Url']."'";
	          	 }
	             $html .= "<li id='menu-".$menu['items'][$itemId]['ID']."' class='sortable'>\n
	             			<div class='ns-row'>
					            <div class='ns-title'>".$menu['items'][$itemId]['Name']."</div>
					            <div class='ns-url'>".$menu['items'][$itemId]['Url']."</div>
					            <div class='ns-class'>".@$menu['items'][$itemId]['Class']."</div>
					            <div class='ns-actions'>
					               <a href='#' class='edit-menu'>Chỉnh sửa</a> | 
                                   <a href='#' class='delete-menu'>Xóa</a>
					               <input type='hidden' id='menu_id' name='menu_id' value='".$menu['items'][$itemId]['ID']."'>
					            </div>
					         </div>";
	             $html .= $this->build_menu_admin($itemId, $menu);
	             $html .= "</li> \n";
	          }
	       }
	       $html .= "</ul> \n";
	   }
	   return $html;
	}
	
	function show_menu($parent, $menu, $level, $class_name = '') {
		$html = "";
	   	if (isset($menu['parents'][$parent])){
	   		if ($level === 0) {
	   			$html .= "<ul class=\"" . @$class_name . "\">";
	   		} 
	   		else {
	   			$html .= "<ul>";
	   		}
	      	
	       	foreach ($menu['parents'][$parent] as $itemId){
	          	$class = '';
	          	$target = '';
	          	if(@$menu['items'][$itemId]['Class'] != null){
	          		$class = "class='".$menu['items'][$itemId]['Class']."'";
	          	}
	          	if(@$menu['items'][$itemId]['Type'] == '_blank'){
	          		$target = "target='".$menu['items'][$itemId]['Type']."'";
	          	}
	          	if(!isset($menu['parents'][$itemId])){
	             	$html .= "<li $class ><a class='nav-link' $target href='{$menu['items'][$itemId]['Url']}'>" .$menu['items'][$itemId]['Name']."</a></li>";
	          	}
	          	if(isset($menu['parents'][$itemId])){
	             	$html .= "<li $class ><a class='nav-link' $target href='{$menu['items'][$itemId]['Url']}'>" .$menu['items'][$itemId]['Name']."</a>";
	             	$html .= $this->show_menu($itemId, $menu, ($level + 1), $class_name);
	             	$html .= "</li>";
	          	}
	       	}
	   		$html .= "</ul>";
	   	}
	   	return $html;
	}
	// End: =======================================================
}
<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2012 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

$dictionary['xVendor'] = array('table' => 'xvendors', 'audited'=>true, 'unified_search' => true, 'full_text_search' => true, 'unified_search_default_enabled' => true, 'duplicate_merge'=>true,
  'comment' => 'xVendors are organizations or entities that are the target of selling, support, and marketing activities, or have already purchased products or services',
  'fields' => array (

  'salutation' =>
  array (
  	'name' => 'salutation',
  	'vname' => 'LBL_SALUTATION',
  	'type' => 'enum',
  	'options' => 'salutation_dom',
  	'massupdate' => false,
  	'len' => '255',
  	'comment' => 'Contact salutation (e.g., Mr, Ms)'            
  ),
  'full_name' =>
  array (
  	'name' => 'full_name',
  	'vname' => 'LBL_FULL_NAME',
  	'type' => 'varchar',
  	'len' => '100',
  	'unified_search' => true,
  	'full_text_search' => array('boost' => 3),
  	'comment' => 'Full name of the contact',
      'merge_filter' => 'selected',     
  ),
  'phone_mobile' =>
  array (
    'name' => 'phone_mobile',
    'vname' => 'LBL_PHONE_MOBILE',
    'type' => 'phone',
    'dbType' => 'varchar',
    'len' => 100,
    'unified_search' => true,
    'full_text_search' => array('boost' => 1),
    'comment' => 'Mobile phone number of the contact',
    'merge_filter' => 'enabled',
  ),
  'qq' =>
  array (
    'name' => 'qq',
    'vname' => 'LBL_QQ',
    'type' => 'varchar',
    'len' => 50,
  ),

  'xvendor_type' => 
  array (
    'name' => 'xvendor_type',
    'vname' => 'LBL_TYPE',
    'type' => 'enum',
    'options' => 'account_type_dom',
    'len'=>50,
    'comment' => 'The company is of this type',
  ),  

   'parent_id' =>
  array (
    'name' => 'parent_id',
    'vname' => 'LBL_PARENT_XVENDOR_ID',
    'type' => 'id',
    'required'=>false,
    'reportable'=>false,
    'audited'=>true,
    'comment' => 'xVendor ID of the parent of this xvendor',
  ),

  'sic_code' =>
  array (
    'name' => 'sic_code',
    'vname' => 'LBL_SIC_CODE',
    'type' => 'varchar',
    'len' => 10,
    'comment' => 'SIC code of the xvendor',
  ),


  'parent_name' =>
  array (
    'name' => 'parent_name',
    'rname' => 'name',
    'id_name' => 'parent_id',
    'vname' => 'LBL_MEMBER_OF',
    'type' => 'relate',
    'isnull' => 'true',
    'module' => 'xVendors',
    'table' => 'xvendors',
    'massupdate' => false,
    'source'=>'non-db',
    'len' => 36,
    'link'=>'member_of',
    'unified_search' => true,
    'importable' => 'true',
  ),


  'members' =>
  array (
    'name' => 'members',
    'type' => 'link',
    'relationship' => 'member_xvendors',
    'module'=>'xVendors',
    'bean_name'=>'xVendor',
    'source'=>'non-db',
    'vname'=>'LBL_MEMBERS',
  ),
  'member_of' =>
  array (
    'name' => 'member_of',
    'type' => 'link',
    'relationship' => 'member_xvendors',
    'module'=>'xVendors',
    'bean_name'=>'xVendor',
    'link_type'=>'one',
    'source'=>'non-db',
    'vname'=>'LBL_MEMBER_OF',
    'side'=>'right',
  ),
  'email_opt_out' =>
		array(
			'name'		=> 'email_opt_out',
			'vname'     => 'LBL_EMAIL_OPT_OUT',
			'source'	=> 'non-db',
			'type'		=> 'bool',
		    'massupdate' => false,
			'studio'=>'false',
		),
  'invalid_email' =>
		array(
			'name'		=> 'invalid_email',
			'vname'     => 'LBL_INVALID_EMAIL',
			'source'	=> 'non-db',
			'type'		=> 'bool',
		    'massupdate' => false,
			'studio'=>'false',
		),
  'cases' =>
  array (
    'name' => 'cases',
    'type' => 'link',
    'relationship' => 'xvendor_cases',
    'module'=>'Cases',
    'bean_name'=>'aCase',
    'source'=>'non-db',
        'vname'=>'LBL_CASES',
  ),
  //bug 42902
  'email'=> array(
			'name' => 'email',
  			'type' => 'email',
			'query_type' => 'default',
			'source' => 'non-db',
			'operator' => 'subquery',
			'subquery' => 'SELECT eabr.bean_id FROM email_addr_bean_rel eabr JOIN email_addresses ea ON (ea.id = eabr.email_address_id) WHERE eabr.deleted=0 AND ea.email_address LIKE',
			'db_field' => array(
				'id',
			),
			'vname' =>'LBL_ANY_EMAIL',
			'studio' => array('visible'=>false, 'searchview'=>true),
		),	
  'tasks' =>
  array (
    'name' => 'tasks',
    'type' => 'link',
    'relationship' => 'xvendor_tasks',
    'module'=>'Tasks',
    'bean_name'=>'Task',
    'source'=>'non-db',
        'vname'=>'LBL_TASKS',
  ),
  'notes' =>
  array (
    'name' => 'notes',
    'type' => 'link',
    'relationship' => 'xvendor_notes',
    'module'=>'Notes',
    'bean_name'=>'Note',
    'source'=>'non-db',
        'vname'=>'LBL_NOTES',
  ),
  'meetings' =>
  array (
    'name' => 'meetings',
    'type' => 'link',
    'relationship' => 'xvendor_meetings',
    'module'=>'Meetings',
    'bean_name'=>'Meeting',
    'source'=>'non-db',
        'vname'=>'LBL_MEETINGS',
  ),
  'calls' =>
  array (
    'name' => 'calls',
    'type' => 'link',
    'relationship' => 'xvendor_calls',
    'module'=>'Calls',
    'bean_name'=>'Call',
    'source'=>'non-db',
        'vname'=>'LBL_CALLS',
  ),

  'emails' =>
  array (
    'name' => 'emails',
    'type' => 'link',
    'relationship' => 'emails_xvendors_rel', /* reldef in emails */
    'module'=>'Emails',
    'bean_name'=>'Email',
    'source'=>'non-db',
    'vname'=>'LBL_EMAILS',
    'studio' => array("formula" => false),
  ),
  'documents'=>
  array (
      'name' => 'documents',
      'type' => 'link',
      'relationship' => 'documents_xvendors',
      'source' => 'non-db',
      'vname' => 'LBL_DOCUMENTS_SUBPANEL_TITLE',
  ),
  'bugs' =>
  array (
    'name' => 'bugs',
    'type' => 'link',
    'relationship' => 'xvendors_bugs',
    'module'=>'Bugs',
    'bean_name'=>'Bug',
    'source'=>'non-db',
        'vname'=>'LBL_BUGS',
  ),
  'contacts' =>
  array (
    'name' => 'contacts',
    'type' => 'link',
    'relationship' => 'xvendors_contacts',
    'module'=>'Contacts',
    'bean_name'=>'Contact',
    'source'=>'non-db',
        'vname'=>'LBL_CONTACTS',
  ),
	'email_addresses' =>
	array (
		'name' => 'email_addresses',
        'type' => 'link',
		'relationship' => 'xvendors_email_addresses',
        'source' => 'non-db',
		'vname' => 'LBL_EMAIL_ADDRESSES',
	    'reportable'=>false,
	    'unified_search' => true,
	    'rel_fields' => array('primary_address' => array('type'=>'bool')),
        'studio' => array("formula" => false),
	),
  	'email_addresses_primary' =>
	array (
		'name' => 'email_addresses_primary',
        'type' => 'link',
		'relationship' => 'xvendors_email_addresses_primary',
        'source' => 'non-db',
		'vname' => 'LBL_EMAIL_ADDRESS_PRIMARY',
		'duplicate_merge'=> 'disabled',
        'studio' => array("formula" => false),
	),
  'opportunities' =>
  array (
    'name' => 'opportunities',
    'type' => 'link',
    'relationship' => 'xvendors_opportunities',
    'module'=>'Opportunities',
    'bean_name'=>'Opportunity',
    'source'=>'non-db',
        'vname'=>'LBL_OPPORTUNITY',
  ),


  'project' =>
  array (
    'name' => 'project',
    'type' => 'link',
    'relationship' => 'projects_xvendors',
    'module'=>'Project',
    'bean_name'=>'Project',
    'source'=>'non-db',
        'vname'=>'LBL_PROJECTS',
  ),
  'leads' =>
  array (
    'name' => 'leads',
    'type' => 'link',
    'relationship' => 'xvendor_leads',
    'module'=>'Leads',
    'bean_name'=>'Lead',
    'source'=>'non-db',
        'vname'=>'LBL_LEADS',
  ),
  'campaigns' =>
	array (
  		'name' => 'campaigns',
    	'type' => 'link',
    	'relationship' => 'xvendor_campaign_log',
    	'module'=>'CampaignLog',
    	'bean_name'=>'CampaignLog',
    	'source'=>'non-db',
		'vname'=>'LBL_CAMPAIGNLOG',
        'studio' => array("formula" => false),
  ),  
  'campaign_xvendors' =>
    array (
      'name' => 'campaign_xvendors',
      'type' => 'link',
      'vname' => 'LBL_CAMPAIGNS',
      'relationship' => 'campaign_xvendors',
      'source' => 'non-db',
  ),  
  
  'created_by_link' =>
  array (
    'name' => 'created_by_link',
    'type' => 'link',
    'relationship' => 'xvendors_created_by',
    'vname' => 'LBL_CREATED_BY_USER',
    'link_type' => 'one',
    'module'=>'Users',
    'bean_name'=>'User',
    'source'=>'non-db',
  ),
  'modified_user_link' =>
  array (
    'name' => 'modified_user_link',
    'type' => 'link',
    'relationship' => 'xvendors_modified_user',
    'vname' => 'LBL_MODIFIED_BY_USER',
    'link_type' => 'one',
    'module'=>'Users',
    'bean_name'=>'User',
    'source'=>'non-db',
  ),
  'assigned_user_link' =>
  array (
    'name' => 'assigned_user_link',
    'type' => 'link',
    'relationship' => 'xvendors_assigned_user',
    'vname' => 'LBL_ASSIGNED_TO_USER',
    'link_type' => 'one',
    'module'=>'Users',
    'bean_name'=>'User',
    'source'=>'non-db',
    'duplicate_merge'=>'enabled',
    'rname' => 'user_name',
    'id_name' => 'assigned_user_id',
    'table' => 'users',
  ),


 'campaign_id' =>
  array (
    'name' => 'campaign_id',
    'comment' => 'Campaign that generated xVendor',
    'vname'=>'LBL_CAMPAIGN_ID',
    'rname' => 'id',
    'id_name' => 'campaign_id',
    'type' => 'id',
    'table' => 'campaigns',
    'isnull' => 'true',
    'module' => 'Campaigns',
    'reportable'=>false,
    'massupdate' => false,
        'duplicate_merge'=> 'disabled',
  ),

 'campaign_name' =>
 array (
        'name'=>'campaign_name',
        'rname'=>'name',
        'vname' => 'LBL_CAMPAIGN',
        'type' => 'relate',
        'reportable'=>false,
        'source'=>'non-db',
        'table' => 'campaigns',
        'id_name' => 'campaign_id',
        'link' => 'campaign_xvendors', 
        'module'=>'Campaigns',
        'duplicate_merge'=>'disabled',
        'comment' => 'The first campaign name for xVendor (Meta-data only)',
 ),
 
      'prospect_lists' =>
      array (
        'name' => 'prospect_lists',
        'type' => 'link',
        'relationship' => 'prospect_list_xvendors',
        'module'=>'ProspectLists',
        'source'=>'non-db',
        'vname'=>'LBL_PROSPECT_LIST',
      ), 

        'xinventories'=>
        array(
            'name' => 'xinventories',
            'type' => 'link',
            'relationship' => 'xinventories_xvendors',
            'module'=>'xInventories',
            'bean_name'=>'xInventory',
            'source'=>'non-db',
            'vname'=>'LBL_INVENTORIES',
        ),
)
, 'indices' => array (
        array('name' =>'idx_accnt_id_del', 'type' =>'index', 'fields'=>array('id', 'deleted')),
        array('name' =>'idx_accnt_name_del', 'type' => 'index', 'fields'=>array('name', 'deleted')),//bug #5530
       array('name' =>'idx_accnt_assigned_del', 'type' =>'index', 'fields'=>array( 'deleted', 'assigned_user_id')),
        array('name' =>'idx_accnt_parent_id', 'type' =>'index', 'fields'=>array( 'parent_id')),
  )

, 'relationships' => array (
    'member_xvendors' => array('lhs_module'=> 'xVendors', 'lhs_table'=> 'xvendors', 'lhs_key' => 'id',
                              'rhs_module'=> 'xVendors', 'rhs_table'=> 'xvendors', 'rhs_key' => 'parent_id',
                              'relationship_type'=>'one-to-many')

    ,'xvendor_cases' => array('lhs_module'=> 'xVendors', 'lhs_table'=> 'xvendors', 'lhs_key' => 'id',
                              'rhs_module'=> 'Cases', 'rhs_table'=> 'cases', 'rhs_key' => 'xvendor_id',
                              'relationship_type'=>'one-to-many')

    ,'xvendor_tasks' => array('lhs_module'=> 'xVendors', 'lhs_table'=> 'xvendors', 'lhs_key' => 'id',
                              'rhs_module'=> 'Tasks', 'rhs_table'=> 'tasks', 'rhs_key' => 'parent_id',
                              'relationship_type'=>'one-to-many', 'relationship_role_column'=>'parent_type',
                              'relationship_role_column_value'=>'xVendors')

    ,'xvendor_notes' => array('lhs_module'=> 'xVendors', 'lhs_table'=> 'xvendors', 'lhs_key' => 'id',
                              'rhs_module'=> 'Notes', 'rhs_table'=> 'notes', 'rhs_key' => 'parent_id',
                              'relationship_type'=>'one-to-many', 'relationship_role_column'=>'parent_type',
                              'relationship_role_column_value'=>'xVendors')

    ,'xvendor_meetings' => array('lhs_module'=> 'xVendors', 'lhs_table'=> 'xvendors', 'lhs_key' => 'id',
                              'rhs_module'=> 'Meetings', 'rhs_table'=> 'meetings', 'rhs_key' => 'parent_id',
                              'relationship_type'=>'one-to-many', 'relationship_role_column'=>'parent_type',
                              'relationship_role_column_value'=>'xVendors')

    ,'xvendor_calls' => array('lhs_module'=> 'xVendors', 'lhs_table'=> 'xvendors', 'lhs_key' => 'id',
                              'rhs_module'=> 'Calls', 'rhs_table'=> 'calls', 'rhs_key' => 'parent_id',
                              'relationship_type'=>'one-to-many', 'relationship_role_column'=>'parent_type',
                              'relationship_role_column_value'=>'xVendors')

/*,'xvendors_emails' => array(
    'rhs_module'        => 'Emails',
    'rhs_table'         => 'emails',
    'rhs_key'           => 'id',
    'lhs_module'        => 'xVendors',
    'lhs_table'         => 'xvendors',
    'lhs_key'           => 'id',
    'relationship_type' => 'many-to-many',
    'join_table'        => 'emails_xvendors',
    'join_key_rhs'      => 'email_id',
    'join_key_lhs'      => 'xvendor_id'
)
*/
    ,'xvendor_emails' => array('lhs_module'=> 'xVendors', 'lhs_table'=> 'xvendors', 'lhs_key' => 'id',
                              'rhs_module'=> 'Emails', 'rhs_table'=> 'emails', 'rhs_key' => 'parent_id',
                              'relationship_type'=>'one-to-many', 'relationship_role_column'=>'parent_type',
                              'relationship_role_column_value'=>'xVendors')

    ,'xvendor_leads' => array('lhs_module'=> 'xVendors', 'lhs_table'=> 'xvendors', 'lhs_key' => 'id',
                              'rhs_module'=> 'Leads', 'rhs_table'=> 'leads', 'rhs_key' => 'xvendor_id',
                              'relationship_type'=>'one-to-many')
    ,

  'xvendors_assigned_user' =>
  array('lhs_module'=> 'Users', 'lhs_table'=> 'users', 'lhs_key' => 'id',
  'rhs_module'=> 'xVendors', 'rhs_table'=> 'xvendors', 'rhs_key' => 'assigned_user_id',
  'relationship_type'=>'one-to-many'),

  'xvendors_modified_user' =>
  array('lhs_module'=> 'Users', 'lhs_table'=> 'users', 'lhs_key' => 'id',
  'rhs_module'=> 'xVendors', 'rhs_table'=> 'xvendors', 'rhs_key' => 'modified_user_id',
  'relationship_type'=>'one-to-many'),

  'xvendors_created_by' =>
  array('lhs_module'=> 'Users', 'lhs_table'=> 'users', 'lhs_key' => 'id',
  'rhs_module'=> 'xVendors', 'rhs_table'=> 'xvendors', 'rhs_key' => 'created_by',
  'relationship_type'=>'one-to-many'),
  
  'xvendor_campaign_log' => array('lhs_module' => 'xVendors', 'lhs_table'=> 'xvendors', 'lhs_key'=> 'id',
  'rhs_module'=> 'CampaignLog','rhs_table'=>'campaign_log', 'rhs_key'=> 'target_id',
  'relationship_type'	=>'one-to-many'),
  
  ),
  //This enables optimistic locking for Saves From EditView
  'optimistic_locking'=>true,
);

VardefManager::createVardef('xVendors','xVendor', array('default', 'assignable',
'company',
));

//jc - adding for refactor for import to not use the required_fields array
//defined in the field_arrays.php file
$dictionary['xVendor']['fields']['name']['importable'] = 'required';

?>

<?php
namespace Quaff\Site;

class ModelAdmin extends \Modular\Admin\ModelAdmin {
	private static $managed_models = [ 'SiteJob' ];
	private static $url_segment = 'site';
	private static $menu_title = 'Site';
	
	
}
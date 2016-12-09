<?php
namespace Quaff\Site\Relationships;

use Modular\Relationships\HasMany;

class HasWebSites extends HasMany {
	const RelationshipName = 'WebSites';
	const RelatedClassName = 'WebSite';
	
	private static $show_as = self::ShowAsGridField;
}
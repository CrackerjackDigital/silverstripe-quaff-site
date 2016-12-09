<?php
namespace Quaff\Site\Relationships;

use Modular\Relationships\HasMany;

/**
 * Add many DynamicEndpoint models to a model.
 * @package Quaff\Site\Relationships
 */
class HasEndpoints extends HasMany {
	const RelationshipName = 'Endpoints';
	const RelatedClassName = 'Quaff\Site\Models\DynamicEndpoint';
	
	private static $show_as = self::ShowAsTagsField;
}
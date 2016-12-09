<?php
namespace Quaff\Site\Relationships;

use Modular\Relationships\HasOne;

class HasWebSite extends HasOne {
	const RelationshipName = 'WebSite';
	const RelatedClassName = 'WebSite';
}

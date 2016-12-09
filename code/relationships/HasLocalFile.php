<?php

namespace Quaff\Site\Relationships;

use Modular\Relationships\HasOne;
use Quaff\Site\Models\LocalFile;

class HasLocalFile extends HasOne {
	const RelationshipName = 'LocalFile';
	const RelatedClassName = 'Quaff\Site\Models\LocalFile';
	
	public function cmsFields()
	{
		return [
			static::relationship_name() => new \FileField(
				static::field_name()
			)
		];
	}
	
	public function addRelated(LocalFile $file) {
		$file->write();
		$this()->{static::field_name()} = $file->ID;
	}
}
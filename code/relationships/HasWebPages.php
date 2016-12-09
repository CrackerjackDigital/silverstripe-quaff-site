<?php
namespace Quaff\Site\Relationships;

use Modular\md5;
use Modular\Model;
use Modular\owned;
use Modular\Relationships\HasManyMany;
use Quaff\Responses\HTML\Response;

class HasWebPages extends HasManyMany
{
	use md5 {
		md5 as hash;
	}
	use owned;
	
	const RelationshipName = 'WebPages';
	const RelatedClassName = 'Quaff\Site\Models\WebPage';
	
	public function extraStatics($class = null, $extension = null)
	{
		return array_merge_recursive(
			parent::extraStatics($class, $extension),
			[
				'many_many_extraFields' => [
					static::RelationshipName => [
						'LastChecked'      => 'SS_DateTime',
						'LastResponseCode' => 'Int',
						'LastHash'         => 'Varchar(' . static::hash_length() . ')',
					],
				],
			]
		);
	}
	
	/**
	 * Add related model and set extra fields from a response.
	 *
	 * @param \Modular\Model                 $model
	 * @param \Quaff\Responses\HTML\Response $response
	 */
	public function addRelated(Model $model, Response $response)
	{
		/** @var \ManyManyList $related */
		$related = $this()->{static::relationship_name()}();
		$related->add(
			$model,
			[
				'LastChecked'    => \SS_Datetime::now()->getValue(),
				'LastResultCode' => $response->getResultCode(),
				'LastHash'       => static::hash((string)$response->getRawData()),
			]
		);
	}
}
<?php
namespace Quaff\Site\Models;

use Modular\Model;
use Psr\Http\Message\ResponseInterface;
use Quaff\Interfaces\Endpoint;
use Quaff\Interfaces\Quaffable;
use Quaff\Responses\Response;

/**
 * DynamicEndpoint model is a way to save dynamic data for a statically configured Endpoint, using the 'name' as key.
 * Provides mapping between config convention snake_case and model convention CamelCase for field names on the 'info'.
 * field which defines the endpoint. This is a 'flat' record so stores resolved information after parent endpoint
 * information has been incorporated. If a class uses a Model directory then these records will be used to retrieve the
 * endpoint configuration.
 *
 * @package Quaff\Models
 */
class DynamicEndpoint extends Model
{
	use \Modular\json;
	
	private static $db = [
		'Title'       => 'Varchar(255)',
		'Name'        => 'Varchar(32)',
		'Description' => 'Text',
		'Data'        => 'Text',
	];
	
	private static $info_to_field_map = [
		'name' => 'Name',
	];
	
	/**
	 * Before we write we sync the json encoded data with the model values where there is a concordance in the map.
	 */
	public function onBeforeWrite()
	{
		parent::onBeforeWrite();
		$this->Data = $this->toInfo();
	}
	
	/**
	 * Given an array of data extract and set any mapped fields from config.info_to_field_map and update
	 * the json representation of the data stored in the Data field.
	 *
	 * @param array $info
	 * @return $this
	 */
	public function fromInfo(array $info)
	{
		foreach ($this->config()->get('info_to_field_map') as $infoName => $modelField) {
			if (array_key_exists($infoName, $info)) {
				$this->$modelField = $info[ $infoName ];
			}
		}
		$this->Data = static::encode($info);
		
		return $this;
	}
	
	/**
	 * Get the data from the json_encoded Data field and return a copy updated from the models fields in
	 * config.info_to_field_map.
	 *
	 * @return array
	 */
	public function toInfo()
	{
		/** @var array $data */
		$data = static::decode($this->Data);
		
		foreach ($this->config()->get('info_to_field_map') as $infoName => $modelField) {
			$data[ $infoName ] = $this->$modelField;
		}
		
		return $data;
	}

}
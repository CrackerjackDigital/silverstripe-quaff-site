<?php
namespace Quaff\Site\Tasks;

use Modular\debugging;
use Modular\Fields\ExternalLink;
use Modular\Interfaces\Debugger;
use Quaff\Endpoints\Endpoint;
use Quaff\Site\Fields\JobStatus;
use Quaff\Site\Models\Job;
use Quaff\Site\Relationships\HasEndpoints;
use Quaff\Site\Relationships\HasWebSite;

class JobRunner extends \Quaff\Tasks\SyncTask
{
	use debugging;
	
	const ServiceName = 'site';
	
	/**
	 * @param \SS_HTTPRequest $request
	 */
	public function run($request)
	{
		$this->debugger()
			->toScreen()
			->toFile('../logs/site.log');
		
		$job = Job::get()->filter([
			JobStatus::field_name() => JobStatus::StatusQueued,
		])->first();
		
		if ($job) {
			if ($webSite = $job->{HasWebSite::relationship_name()}()) {
				if ($endpoints = $job->{HasEndpoints::relationship_name()}()) {
					/** @var Endpoint $endpoint */
					foreach ($endpoints as $endpoint) {
						$endpoint->{ExternalLink::field_name()} = $webSite->{ExternalLink::field_name()};
						$endpoint->sync();
					}
				}
			}
		}
	}
}
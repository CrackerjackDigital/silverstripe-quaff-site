<?php
namespace Quaff\Site\Services;

use Quaff\Api;
use Quaff\Site\Models\Job;
use Quaff\Site\Models\WebSite;

class Site extends Api implements \Quaff\Interfaces\Api
{
	private static $default_endpoints = [
			
	];
	/**
	 * Creates a SiteJob from WebSite and params and schedules it immediately or at the requested time.
	 *
	 *
	 * @param WebSite $webSite
	 * @param array   $params
	 */
	public function site(WebSite $webSite, array $params = [ ])
	{
		$job = $this->create_job($webSite, $params);
		
	}
	
	/**
	 * @param WebSite $webSite
	 * @param array   $params
	 * @return Job
	 */
	public static function create_job(WebSite $webSite, array $params)
	{
		if (isset($params['Endpoints'])) {
			$endpoints = is_array($params['Endpoints']) ? $params['Endpoints'] : explode(',', $params['Endpoints']);
		}
		
		$job = new Job(
			array_merge(
				$webSite->toMap(),
				$params,
				[
					'QueuedByID'    => \Member::currentUserID(),
					'QueuedDate'    => date('Y-m-d H:i:s'),
					'RequestedDate' => $params['RequestedDate'],
					'Status'        => \JobStatus::StatusQueued,
					'WebSiteID'     => $webSite->ID,
					'Endpoints'     => $endpoints,
				]
			)
		);
		$job->write();
		return $job;
	}
	
	
}
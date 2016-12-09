<?php
namespace Quaff\Site\Fields;

use Modular\Fields\StateEngineField;

class JobStatus extends StateEngineField
{
	const SingleFieldName = 'JobStatus';
	
	const StatusQueued    = 'Queued';
	const StatusRunning   = 'Running';
	const StatusComplete  = 'Complete';
	const StatusFailed    = 'Failed';
	const StatusPaused    = 'Paused';
	const StatusCancelled = 'Cancelled';
	const StatusHeld      = 'Held';
	
	private static $options = [
		self::StatusQueued,
		self::StatusRunning,
		self::StatusComplete,
		self::StatusFailed,
		self::StatusPaused,
		self::StatusCancelled,
		self::StatusHeld,
	];
	
	private static $states = [
		self::StatusQueued    => [
			self::StatusRunning,
			self::StatusHeld,
			self::StatusPaused,
			self::StatusComplete,
			self::StatusFailed,
			self::StatusCancelled,
		],
		self::StatusRunning   => [
			self::StatusComplete,
			self::StatusFailed,
			self::StatusPaused,
			self::StatusCancelled,
		],
		self::StatusComplete  => [
		],
		self::StatusFailed    => [
			self::StatusQueued,
		],
		self::StatusPaused    => [
			self::StatusQueued,
			self::StatusCancelled,
		],
		self::StatusHeld      => [
			self::StatusQueued,
		],
		self::StatusCancelled => [
		],
	];
	
	private static $notify_on_state_events = [
		self::StatusFailed => self::NotifyEmailAdmin,
		self::StatusComplete => self::NotifyEmailAdmin
	];
}
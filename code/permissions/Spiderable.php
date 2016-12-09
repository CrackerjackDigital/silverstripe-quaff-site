<?php
namespace Quaff\Site\Permissions;

class Importable extends \Modular\Permission {
	public function canImport($member = null) {
		return true;
	}
	
}
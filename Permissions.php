Php artisan create:permission (Press Enter Without permission name, Permission Name will be written after enter)

//AppServiceProvider.php (Under Boot Function)
$this->registerHasAccessDirective();  //make directive

private function regusterHasAccessDirective() {
	if(Blade::('hasAccess', function($permission)) {
	    if(Auth::check()){
	    	//Check the current user hasAccess
	    	return Auth::User()->hasAccess($permission);
	    }
	return false;
	}
}


//Modal
public function hasAccess($permission){
     if($this->isSuperAdmin){
	return true;
     }
     $can =$this->usertype()->permissoins()->where('PermissionName',$permission);
     return $can ? true:false;
}



<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
class User extends Eloquent implements UserInterface, RemindableInterface {
		protected $fillable = array(
		'first_name', 
		'last_name', 
		'email', 
		'phone',
		'elevator',
		'about',
		'pic', 
		'video',
		'location', 
		'activated',
		'map',
		'last_map',
		'views',
		'votes',
		'notes',
		'status',
		'public'
		);

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function profiles() //tim
    {
        return $this->hasMany('Profile');
    }

	public function getName()
	{
		return $this->first_name . ' ' . $this->last_name;
	}
	public function getNameLink()
	{
		return link_to_route('devs.show', $this->getName(), $this->id);
	}
	public static function getEditLink($record, $model){
		if(Sentry::check()):

			$creator = $record->creator ? $record->creator : $record->organizer; //For eventts
			$creator = $model == 'devs' ? $record->id : $creator; //For devs

			if($creator == Sentry::getUser()->id || Sentry::getUser()->hasAccess('admin')):
				return link_to_route($model.'.edit', 'Edit', array($record->id), array('class' => 'btn btn-info'));
			endif;
			// return var_dump($record);

		endif;

	}
}
<?php

use MrJuliuss\Syntara\Controllers\UserController;
use MrJuliuss\Syntara\Services\Validators\User as UserValidator;


class CustomUserController extends UserController {


    /**
    * Display a list of all users
    *
    * @return Response
    */
    public function getIndex()
    {
        // get alls users
     $emptyUsers =  Sentry::getUserProvider()->getEmptyUser();

        // users search
     $userId = Input::get('userIdSearch');
     if(!empty($userId))
     {
      $emptyUsers = $emptyUsers->where('users.id', $userId);
    }


    $email = Input::get('emailSearch');
    if(!empty($email))
    {
      $emptyUsers = $emptyUsers->where('email', 'LIKE', '%'.$email.'%');
    }

    $bannedUsers = Input::get('bannedSearch');
    if(isset($bannedUsers) && $bannedUsers !== "")
    {
      $emptyUsers = $emptyUsers->join('throttle', 'throttle.user_id', '=', 'users.id')
      ->where('throttle.banned', '=', $bannedUsers)
      ->select('users.id', 'users.email', 'users.permissions', 'users.activated');
    }

    $emptyUsers->distinct();

    $users = $emptyUsers->paginate(Config::get('syntara::config.item-perge-page'));
    $datas['links'] = $users->links();
    $datas['users'] = $users;

        // ajax request : reload only content container
    if(Request::ajax())
    {
      $html = View::make(Config::get('syntara::views.users-list'), array('datas' => $datas))->render();

      return Response::json(array('html' => $html));
    }

    $this->layout = View::make(Config::get('syntara::views.users-index'), array('datas' => $datas));
    $this->layout->title = trans('syntara::users.titles.list');
    $this->layout->breadcrumb = Config::get('syntara::breadcrumbs.users');
  }

    /**
    * Create new user
    */
    public function postCreate()
    {     
    	try
    	{
    		$validator = new UserValidator(Input::all(), 'create');

    		$permissionsValues = Input::get('permission');
    		$permissions = $this->_formatPermissions($permissionsValues);

    		if(!$validator->passes())
    		{
    			return Response::json(array('userCreated' => false, 'errorMessages' => $validator->getErrors()));
    		}

            // create user
    		$user = Sentry::getUserProvider()->create(array(
    			'email'    => Input::get('email'),
    			'password' => Input::get('pass'),
    			'permissions' => $permissions,
          'synchroCode' => Str::random(8),
          ));

            // activate user
    		$activationCode = $user->getActivationCode();
    		if(Config::get('syntara::config.user-activation') === 'auto')
    		{
    			$user->attemptActivation($activationCode);
    		}
    		elseif(Config::get('syntara::config.user-activation') === 'email')
    		{
    			$datas = array(
    				'code' => $activationCode,
    				'username' => $user->username
    				);

                // send email
    			Mail::queue(Config::get('syntara::mails.user-activation-view'), $datas, function($message) use ($user)
    			{
    				$message->from(Config::get('syntara::mails.email'), Config::get('syntara::mails.contact'))
    				->subject(Config::get('syntara::mails.user-activation-object'));
    				$message->to($user->getLogin());
    			});
    		}

    		$groups = Input::get('groups');
    		if(isset($groups) && is_array($groups))
    		{
    			foreach($groups as $groupId)
    			{
    				$group = Sentry::getGroupProvider()->findById($groupId);
    				$user->addGroup($group);
    			}
    		}
    	}
        catch (\Cartalyst\Sentry\Users\LoginRequiredException $e){} // already catch by validators
        catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e){} // already catch by validators
        catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e){}
        catch (\Cartalyst\Sentry\Users\UserExistsException $e)
        {
        	return json_encode(array('userCreated' => false, 'message' => trans('syntara::users.messages.user-email-exists'), 'messageType' => 'danger'));
        }
        catch(\Exception $e)
        {
        	return Response::json(array('userCreated' => false, 'message' => trans('syntara::users.messages.user-name-exists'), 'messageType' => 'danger'));
        }

        return json_encode(array('userCreated' => true, 'redirectUrl' => URL::route('listUsers')));
      }


     /**
    * Update user account
    * @param int $userId
    * @return Response
    */
     public function putShow($userId)
     {
     	try
     	{
     		$validator = new UserValidator(Input::all(), 'update');

     		if(!$validator->passes())
     		{
     			return Response::json(array('userUpdated' => false, 'errorMessages' => $validator->getErrors()));
     		}

     		$permissionsValues = Input::get('permission');
     		$permissions = $this->_formatPermissions($permissionsValues);

            // Find the user using the user id
     		$user = Sentry::getUserProvider()->findById($userId);
     		$user->email = Input::get('email');
     		$user->permissions = $permissions;

     		$currentUser = Sentry::getUser();
     		$permissions = (empty($permissions)) ? '' : json_encode($permissions);
     		$hasPermissionManagement = $currentUser->hasAccess(Config::get('syntara::permissions.addUserPermission')) || $currentUser->hasAccess('superuser');
     		if($hasPermissionManagement === true)
     		{
     			DB::table('users')
     			->where('id', $userId)
     			->update(array('permissions' => $permissions));
     		}

     		$pass = Input::get('pass');
     		if(!empty($pass))
     		{
     			$user->password = $pass;
     		}

            // Update the user
     		if($user->save())
     		{
                // if the user has permission to update
     			$banned = Input::get('banned');
     			if(isset($banned) && Sentry::getUser()->getId() !== $user->getId())
     			{
     				$this->_banUser($userId, $banned);
     			}

     			if($currentUser->hasAccess(Config::get('syntara::permissions.addUserGroup')))
     			{
     				$groups = (Input::get('groups') === null) ? array() : Input::get('groups');
     				$userGroups = $user->getGroups()->toArray();

     				foreach($userGroups as $group)
     				{
     					if(!in_array($group['id'], $groups))
     					{
     						$group = Sentry::getGroupProvider()->findById($group['id']);
     						$user->removeGroup($group);
     					}
     				}
     				if(isset($groups) && is_array($groups))
     				{
     					foreach($groups as $groupId)
     					{
     						$group = Sentry::getGroupProvider()->findById($groupId);
     						$user->addGroup($group);
     					}
     				}
     			}

     			return Response::json(array('userUpdated' => true, 'message' => trans('syntara::users.messages.update-success'), 'messageType' => 'success'));
     		}
     		else 
     		{
     			return Response::json(array('userUpdated' => false, 'message' => trans('syntara::users.messages.update-fail'), 'messageType' => 'danger'));
     		}
     	}
     	catch(\Cartalyst\Sentry\Users\UserExistsException $e)
     	{
     		return Response::json(array('userUpdated' => false, 'message' => trans('syntara::users.messages.user-email-exists'), 'messageType' => 'danger'));
     	}
     	catch(\Exception $e)
     	{
     		return Response::json(array('userUpdated' => false, 'message' => trans('syntara::users.messages.user-name-exists'), 'messageType' => 'danger'));
     	}
     }
   }
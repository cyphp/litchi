<?php

namespace Lychee\Dock\Http;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

use Lychee\Modules\Config;
use Lychee\Modules\Response;
use Lychee\Modules\Settings;
use Lychee\Modules\Validator;

use Lychee\Access\Installation;
use Lychee\Access\Admin;
use Lychee\Access\Guest;

require(LYCHEE_SRC . 'autoload.php');

class Dock
{
    public function landing(Request $request, Application $app)
    {
        $fn = $request->request->get('function');
            
        // Start the session and set the default timezone

        date_default_timezone_set('UTC');
        
        // Validate parameters
        if (isset($_POST['albumIDs'])&&Validator::isAlbumIDs($_POST['albumIDs'])===false) Response::error('Wrong parameter type for albumIDs!');
        if (isset($_POST['photoIDs'])&&Validator::isPhotoIDs($_POST['photoIDs'])===false) Response::error('Wrong parameter type for photoIDs!');
        if (isset($_POST['albumID'])&&Validator::isAlbumID($_POST['albumID'])==false)     Response::error('Wrong parameter type for albumID!');
        if (isset($_POST['photoID'])&&Validator::isPhotoID($_POST['photoID'])==false)     Response::error('Wrong parameter type for photoID!');

        // Check if a configuration exists
        if (Config::exists()===false) {
            
            /**
            * Installation Access
            * Limited access to configure Lychee. Only available when the config.php file is missing.
            */
            
            Installation::init($fn);
            exit();
            
        }
        
        // Check if user is logged
        if ($app['session']->get('login') &&
            $app['session']->get('identifier') === Settings::get()['identifier']
        ) {
            /**
            * Admin Access
            * Full access to Lychee. Only with correct password/session.
            */
            
            Admin::init($fn);
            exit();
            
        } else {
            
            /**
            * Guest Access
            * Access to view all public folders and photos in Lychee.
            */
            $subRequest = Request::create('/auth/', 'POST', $request->request->all());

            return $app->handle($subRequest, HttpKernelInterface::SUB_REQUEST);            
        }
    }
}

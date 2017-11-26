<?php

namespace Lychee\Dock\Http;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

use Lychee\Modules\Config;
use Lychee\Modules\Response;
use Lychee\Modules\Settings;
use Lychee\Modules\Validator;

use Lychee\Access\Admin;
use Lychee\Access\Guest;

class Dock
{
    public function landing(Request $request, Application $app)
    {
        $fn = $request->request->get('function');
        
        // Validate parameters
        if (isset($_POST['albumIDs'])&&Validator::isAlbumIDs($_POST['albumIDs'])===false) Response::error('Wrong parameter type for albumIDs!');
        if (isset($_POST['photoIDs'])&&Validator::isPhotoIDs($_POST['photoIDs'])===false) Response::error('Wrong parameter type for photoIDs!');
        if (isset($_POST['albumID'])&&Validator::isAlbumID($_POST['albumID'])==false)     Response::error('Wrong parameter type for albumID!');
        if (isset($_POST['photoID'])&&Validator::isPhotoID($_POST['photoID'])==false)     Response::error('Wrong parameter type for photoID!');
        

        /**
        * Admin Access
        * Full access to Lychee. Only with correct password/session.
        */
        
        Admin::init($fn);
        exit();
    }
}

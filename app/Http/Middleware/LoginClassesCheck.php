<?php namespace App\Http\Middleware;
/**
 * Created by PhpStorm.
 * User: Silence
 * Date: 2016/10/13
 * Time: 10:31
 */

use Closure;
use App\Base\BaseFunc;
use Illuminate\Support\Facades\Request;

class LoginClassesCheck {

    public function __construct(BaseFunc $baseFunc)
    {
        $this->baseFunc = $baseFunc;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(session("classes")==true)
        {

            return $next($request);
        }
        else
        {

            if (Request::isMethod('post'))
            {
                return $this->baseFunc->setRedirectMessage(false, "本操作需要登录", NULL,"/start");
            }
            else
            {
                $redirectData["status"] = true;
                $redirectData["url"] = Request::url();
                session(["redirect"=>$redirectData]);
                return $this->baseFunc->setRedirectMessage(false, "本操作需要登录", NULL,"/start");
            }


        }

    }

}

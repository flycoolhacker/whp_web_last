<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|


Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

/*
 * store字样为添加
 * delete字样为删除
 * search字样为查找
 * news以及log为日志
 * person为员工
 * classes为科室
 */
Route::group(['middleware' => ['web']], function () {


    //顶级登录
    Route::get("/adminTopLogin","AdminTop\AdminTopLoginController@login");
    Route::post("/_adminTopLogin","AdminTop\AdminTopLoginController@_login");
//    Route::any("/",function(){
//        return view('Home.AdminSeconds.warn');
//    });
    Route::get("/restart","adminSecond\StartController@Start");//主界面
        //二级
        Route::get("/start","adminSecond\StartController@Start");//主界面
        Route::post("/start","adminSecond\StartController@Start");//主界面
        Route::post("/SecondAdminLogin","adminSecond\StartController@SecondAdminLogin");//二级登录
        Route::post("/ClassesAdminLogin","adminClasses\AdminClassesLoginController@login");//三级登录

        //顶级
        Route::group(['middleware' => ['LoginUserCheck']], function () {

            Route::resource('/company', "AdminTop\AdminTopCompanyController");
            Route::get('delete/{company_id}',"AdminTop\AdminTopCompanyController@destroy");
            Route::resource('/secondAdmin', "AdminTop\AdminTopAdminController");
        });

        //二级
        Route::group(['middleware' => ['LoginAdminCheck']], function () {
            Route::resource('/admin',"adminSecond\AdminController");
  //        Route::resource('/Dadmin',"adminSecond\DangerController");
            Route::resource('/person',"adminSecond\PersonController");
            Route::resource('/classes',"adminSecond\ClassesController");
            Route::resource('/secondAdmins',"adminSecond\SecondAdminController");
            Route::get("/secondAdmins","adminSecond\SecondAdminController@searchClassesAdmin");

            Route::get("/person","adminSecond\PersonController@searchPerson");
            Route::post("/person","adminSecond\PersonController@store");

            Route::get("/dangernews","adminSecond\NewsController@dangerNews");
            Route::post("/dangernews","adminSecond\NewsController@dangerNews");

            Route::get("/normalnews","adminSecond\NewsController@normalNews");
            Route::post("/normalnews","adminSecond\NewsController@normalNews");

            Route::resource('/admin',"adminSecond\AdminController");
            Route::get('/Seek',"adminSecond\AdminController@SeekName");
            Route::post('/DeleteAll',"adminSecond\AdminController@DeleteAll");
            Route::get('/TimeShow',"adminSecond\ExcleController@show");
            Route::post('/ExcleShow',"adminSecond\ExcleController@OutExcle");
            Route::post('/ExcleShow1',"adminSecond\ExcleController@OutExcle1");
            Route::post('/NomalExcleShow',"adminSecond\ExcleController@NomalExcleShow");
            Route::post('/NomalExcleShow1',"adminSecond\ExcleController@NomalExcleShow1");
            Route::any("/logout","adminSecond\SecondLogout@logout");
            Route::get('/SeclogTimeShow',"adminSecond\LogExcleController@show");
            Route::post('/SeclogExcleShow',"adminSecond\LogExcleController@OutExcle");
            Route::post('/SeclogNomalExcleShow',"adminSecond\LogExcleController@NomalExcleShow");
            Route::any('/PeoExcleShow',"adminSecond\LogExcleController@PeoExcleShow");

            Route::post('/changepassword',"adminSecond\ChangePassword@change");
			Route::any('/judgeId',"adminSecond\SecondAdminController@judgeId");
        });

        //三级
        Route::group(['middleware' => ['LoginClassesCheck']], function () {

            Route::resource('/classesperson',"adminClasses\ClassesPersonController");
            Route::get("/classesperson","adminClasses\ClassesPersonController@searchClassesPerson");
            Route::post("/classesperson","adminClasses\ClassesPersonController@store");
            Route::any("/classesdangernews","adminClasses\ClassesNewsController@classesdangerNews");
            Route::any("/classesnormalnews","adminClasses\ClassesNewsController@classesnormalNews");
            Route::resource('/classesadmin', "adminClasses\ClassesAdmin");
            Route::get('/adminSeek',"adminClasses\ClassesAdmin@SeekName");
            Route::post('/adminDeleteAll',"adminClasses\ClassesAdmin@DeleteAll");
            Route::get('/adminTimeShow',"adminClasses\ExcleController@show");
            Route::post('/adminExcleShow',"adminClasses\ExcleController@OutExcle");
            Route::any('/adminExcleShow1',"adminClasses\ExcleController@OutExcle1");
            Route::post('/adminNomalExcleShow',"adminClasses\ExcleController@NomalExcleShow");
            Route::post('/adminNomalExcleShow1',"adminClasses\ExcleController@NomalExcleShow1");
            Route::get('/logTimeShow',"adminClasses\LogExcleController@show");
            Route::post('/logExcleShow',"adminClasses\LogExcleController@OutExcle");
            Route::post('/logNomalExcleShow',"adminClasses\LogExcleController@NomalExcleShow");
            Route::any("/Classeslogout","adminClasses\ClassesLogout@logout");
            Route::get('/searchClassesnormalPerson',"adminClasses\ClassesNewsController@searchClassesnormalPerson");
            Route::get('/searchClassesdangerPerson',"adminClasses\ClassesNewsController@searchClassesdangerPerson");
            Route::any('/adminPeoExcleShow',"adminClasses\ExcleController@adminPeoExcleShow");

        });

});



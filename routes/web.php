<?php

use App\Http\Livewire\Profile;
use App\Http\Livewire\Students;
use App\Http\Livewire\MembersReport;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\City1Controller;
use App\Http\Controllers\City2Controller;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\City3Controller;
use App\Http\Controllers\City4Controller;
use App\Http\Controllers\City5Controller;
use App\Http\Controllers\City6Controller;
use App\Http\Controllers\City7Controller;
use App\Http\Controllers\City8Controller;
use App\Http\Controllers\City9Controller;
use App\Http\Controllers\Zone1Controller;
use App\Http\Controllers\Zone2Controller;
use App\Http\Controllers\Zone3Controller;
use App\Http\Controllers\Zone4Controller;
use App\Http\Controllers\Zone5Controller;
use App\Http\Controllers\Zone6Controller;
use App\Http\Controllers\Zone7Controller;
use App\Http\Controllers\Zone8Controller;
use App\Http\Controllers\Zone9Controller;
use App\Http\Controllers\AbroadController;
use App\Http\Controllers\City10Controller;
use App\Http\Controllers\City11Controller;
use App\Http\Controllers\City12Controller;
use App\Http\Controllers\City13Controller;
use App\Http\Controllers\City14Controller;
use App\Http\Controllers\City15Controller;
use App\Http\Controllers\City16Controller;
use App\Http\Controllers\City17Controller;
use App\Http\Controllers\City18Controller;
use App\Http\Controllers\City19Controller;
use App\Http\Controllers\CityMemberReport;
use App\Http\Controllers\Zone10Controller;
use App\Http\Controllers\Zone11Controller;
use App\Http\Controllers\Zone12Controller;
use App\Http\Controllers\Zone13Controller;
use App\Http\Controllers\Zone14Controller;
use App\Http\Controllers\Zone15Controller;
use App\Http\Controllers\Zone16Controller;
use App\Http\Controllers\Zone17Controller;
use App\Http\Controllers\Zone18Controller;
use App\Http\Controllers\Zone19Controller;
use App\Http\Controllers\Zone20Controller;
use App\Http\Controllers\Zone21Controller;
use App\Http\Controllers\ZoneMemberReport;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegionalController;
use App\Http\Controllers\RegionMemberReport;
use App\Http\Controllers\CityMemberFeeReport;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HonorableController;
use App\Http\Controllers\ZoneMemberFeeReport;
use App\Http\Controllers\RegionMemberFeeReport;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Front\DetailController;
use App\Http\Controllers\CityMemberPayController;
use App\Http\Controllers\ZoneMemberPayController;
use App\Http\Controllers\AbroadMemberPayController;
use App\Http\Controllers\RegionMemberPayController;
use App\Http\Controllers\HonorableMemberPayController;
use App\Http\Controllers\Front\NewsController as FrontNewsController;
use App\Http\Controllers\Front\AnnouncementController as FrontAnnouncementController;
use App\Http\Controllers\Organization\ArsiiController;
use App\Http\Controllers\Organization\ArsiiLixaaController;
use App\Http\Controllers\Organization\BaaleeController;
use App\Http\Controllers\Organization\BaaleeBahaaController;
use App\Http\Controllers\Organization\BooranaaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', FrontNewsController::class)->name('front.news');
Route::get('/front-announcement', FrontAnnouncementController::class)->name('front.announcement');
Route::get('/detail/{id}/{model}', DetailController::class);


// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
Route::middleware([
    'auth:web',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/admin', DashboardController::class)->name('dashboard');
    Route::get('students', Students::class)->name('students');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::get('profile', Profile::class)->name('profile');
    Route::get('logout', [ProfileController::class, 'logout'])->name('logout');
    Route::resource('news', NewsController::class);
    Route::resource('announcement', AnnouncementController::class);
    // zones
    Route::resource('zone1', Zone1Controller::class);
    Route::resource('zone2', Zone2Controller::class);
    Route::resource('zone3', Zone3Controller::class);
    Route::resource('zone4', Zone4Controller::class);
    Route::resource('zone5', Zone5Controller::class);
    Route::resource('zone6', Zone6Controller::class);
    Route::resource('zone7', Zone7Controller::class);
    Route::resource('zone8', Zone8Controller::class);
    Route::resource('zone9', Zone9Controller::class);
    Route::resource('zone10', Zone10Controller::class);
    Route::resource('zone11', Zone11Controller::class);
    Route::resource('zone12', Zone12Controller::class);
    Route::resource('zone13', Zone13Controller::class);
    Route::resource('zone14', Zone14Controller::class);
    Route::resource('zone15', Zone15Controller::class);
    Route::resource('zone16', Zone16Controller::class);
    Route::resource('zone17', Zone17Controller::class);
    Route::resource('zone18', Zone18Controller::class);
    Route::resource('zone19', Zone19Controller::class);
    Route::resource('zone20', Zone20Controller::class);
    Route::resource('zone21', Zone21Controller::class);

    //
    Route::resource('arsii',ArsiiController::class);
    Route::resource('arsii_lixaa',ArsiiLixaaController::class);
    Route::resource('baalee', BaaleeController::class);
    Route::resource('baalee_bahaa', BaaleeBahaaController::class);
    Route::resource('booranaa', BooranaaController::class);
    //
    Route::Post('arsii/import', [ArsiiController::class, 'import'])->name('arsii.import');
    Route::Post('arsii_lixaa/import', [ArsiiLixaaController::class, 'import'])->name('arsii_lixaa.import');
    Route::Post('baalee/import', [BaaleeController::class, 'import'])->name('baalee.import');
    Route::Post('baalee_bahaa/import', [BaaleeBahaaController::class, 'import'])->name('baalee_bahaa.import');
    Route::Post('booranaa/import', [BooranaaController::class, 'import'])->name('booranaa.import');
    
    // import
    Route::post('zone1/import', [Zone1Controller::class, 'import'])->name('zone1.import');
    Route::post('zone2/import', [Zone2Controller::class, 'import'])->name('zone2.import');
    Route::post('zone3/import', [Zone3Controller::class, 'import'])->name('zone3.import');
    Route::post('zone4/import', [Zone4Controller::class, 'import'])->name('zone4.import');
    Route::post('zone5/import', [Zone5Controller::class, 'import'])->name('zone5.import');
    Route::post('zone6/import', [Zone6Controller::class, 'import'])->name('zone6.import');
    Route::post('zone7/import', [Zone7Controller::class, 'import'])->name('zone7.import');
    Route::post('zone8/import', [Zone8Controller::class, 'import'])->name('zone8.import');
    Route::post('zone9/import', [Zone9Controller::class, 'import'])->name('zone9.import');
    Route::post('zone10/import', [Zone10Controller::class, 'import'])->name('zone10.import');
    Route::post('zone11/import', [Zone11Controller::class, 'import'])->name('zone11.import');
    Route::post('zone12/import', [Zone12Controller::class, 'import'])->name('zone12.import');
    Route::post('zone13/import', [Zone13Controller::class, 'import'])->name('zone13.import');
    Route::post('zone14/import', [Zone14Controller::class, 'import'])->name('zone14.import');
    Route::post('zone15/import', [Zone15Controller::class, 'import'])->name('zone15.import');
    Route::post('zone16/import', [Zone16Controller::class, 'import'])->name('zone16.import');
    Route::post('zone17/import', [Zone17Controller::class, 'import'])->name('zone17.import');
    Route::post('zone18/import', [Zone18Controller::class, 'import'])->name('zone18.import');
    Route::post('zone19/import', [Zone19Controller::class, 'import'])->name('zone19.import');
    Route::post('zone20/import', [Zone20Controller::class, 'import'])->name('zone20.import');
    Route::post('zone21/import', [Zone21Controller::class, 'import'])->name('zone21.import');
    //City
    Route::resource('city1', City1Controller::class);
    Route::resource('city2', City2Controller::class);
    Route::resource('city3', City3Controller::class);
    Route::resource('city4', City4Controller::class);
    Route::resource('city5', City5Controller::class);
    Route::resource('city6', City6Controller::class);
    Route::resource('city7', City7Controller::class);
    Route::resource('city8', City8Controller::class);
    Route::resource('city9', City9Controller::class);
    Route::resource('city10', City10Controller::class);
    Route::resource('city11', City11Controller::class);
    Route::resource('city12', City12Controller::class);
    Route::resource('city13', City13Controller::class);
    Route::resource('city14', City14Controller::class);
    Route::resource('city15', City15Controller::class);
    Route::resource('city16', City16Controller::class);
    Route::resource('city17', City17Controller::class);
    Route::resource('city18', City18Controller::class);
    Route::resource('city19', City19Controller::class);
    //City import
    Route::post('city1/import', [City1Controller::class, 'import'])->name('city1.import');
    Route::post('city2/import', [City2Controller::class, 'import'])->name('city2.import');
    Route::post('city3/import', [City3Controller::class, 'import'])->name('city3.import');
    Route::post('city4/import', [City4Controller::class, 'import'])->name('city4.import');
    Route::post('city5/import', [City5Controller::class, 'import'])->name('city5.import');
    Route::post('city6/import', [City6Controller::class, 'import'])->name('city6.import');
    Route::post('city7/import', [City7Controller::class, 'import'])->name('city7.import');
    Route::post('city8/import', [City8Controller::class, 'import'])->name('city8.import');
    Route::post('city9/import', [City9Controller::class, 'import'])->name('city9.import');
    Route::post('city10/import', [City10Controller::class, 'import'])->name('city10.import');
    Route::post('city11/import', [City11Controller::class, 'import'])->name('city11.import');
    Route::post('city12/import', [City12Controller::class, 'import'])->name('city12.import');
    Route::post('city13/import', [City13Controller::class, 'import'])->name('city13.import');
    Route::post('city14/import', [City14Controller::class, 'import'])->name('city14.import');
    Route::post('city15/import', [City15Controller::class, 'import'])->name('city15.import');
    Route::post('city16/import', [City16Controller::class, 'import'])->name('city16.import');
    Route::post('city17/import', [City17Controller::class, 'import'])->name('city17.import');
    Route::post('city18/import', [City18Controller::class, 'import'])->name('city18.import');
    Route::post('city19/import', [City19Controller::class, 'import'])->name('city19.import');
    //honorables
    Route::resource('abroad', AbroadController::class);
    //import
    Route::post('abroad/import', [AbroadController::class, 'import'])->name('abroad.import');
    //region
    Route::resource('regional', RegionalController::class);
    //regional import
    Route::post('regional/import', [RegionalController::class, 'import'])->name('regional.import');
    //honorable
    Route::resource('honorable', HonorableController::class);
    //honorable import
    Route::post('honorable/import', [HonorableController::class, 'import'])->name('honorable.import');
    // Route::get('/profile/change_password', [ProfileController::class, 'changePass'])->name('change.password');
    Route::post('/profile/update_password', [ProfileController::class, 'passwordUpdate'])->name('password.update');
    // report
    // Route::get('member-report', MembersReport::class)->name('member.report');
    Route::post('zoneMember-report', [ZoneMemberReport::class, 'index'])->name('zoneMember.report');
    Route::get('fetchZone/{zone}', [ZoneMemberReport::class, 'fetch'])->name('fetchZone');
    Route::get('zoneMember-index', [ZoneMemberReport::class, 'first'])->name('zoneMember.index');
    Route::get('zoneMember-export/{zone}/{woreda}', [ZoneMemberReport::class, 'export'])->name('zoneMember.export');
    //report for city
    Route::post('cityMember-report', [CityMemberReport::class, 'index'])->name('cityMember.report');
    Route::get('cityMember-index', [CityMemberReport::class, 'first'])->name('cityMember.index');
    Route::get('cityMember-export/{city}', [CityMemberReport::class, 'export'])->name('cityMember.export');
    // report for region
    Route::post('regionMember-report', [RegionMemberReport::class, 'index'])->name('regionMember.report');
    Route::get('regionMember-index', [RegionMemberReport::class, 'first'])->name('regionMember.index');
    Route::get('regionMember-export/{region}', [RegionMemberReport::class, 'export'])->name('regionMember.export');
    // Zone Member Pay
    Route::resource('zoneMemberPay', ZoneMemberPayController::class);
    Route::resource('cityMemberPay', CityMemberPayController::class);
    Route::resource('regionMemberPay', RegionMemberPayController::class);
    Route::resource('abroadMemberPay', AbroadMemberPayController::class);
    Route::resource('honorableMemberPay', HonorableMemberPayController::class);
    Route::post('abroadMember-pay', [AbroadMemberPayController::class, 'get'])->name('abroadMember.pay');
    Route::post('cityMember-pay', [CityMemberPayController::class, 'get'])->name('cityMember.pay');
    Route::post('regionMember-pay', [RegionMemberPayController::class, 'get'])->name('regionMember.pay');
    Route::post('honorableMember-pay', [HonorableMemberPayController::class, 'get'])->name('honorableMember.pay');


    Route::get('fetchWoreda/{zone}', [ZoneMemberPayController::class, 'fetch'])->name('fetchWoreda');
    Route::post('zoneMember-pay', [ZoneMemberPayController::class, 'get'])->name('zoneMember.pay');
    Route::get('zone1-pay/{zone1}', [Zone1Controller::class, 'pay'])->name('zone1.pay');
    Route::get('zone2-pay/{zone2}', [Zone2Controller::class, 'pay'])->name('zone2.pay');
    Route::get('zone3-pay/{zone3}', [Zone3Controller::class, 'pay'])->name('zone3.pay');
    Route::get('zone4-pay/{zone4}', [Zone4Controller::class, 'pay'])->name('zone4.pay');
    Route::get('zone5-pay/{zone5}', [Zone5Controller::class, 'pay'])->name('zone5.pay');
    Route::get('zone6-pay/{zone6}', [Zone6Controller::class, 'pay'])->name('zone6.pay');
    Route::get('zone7-pay/{zone7}', [Zone7Controller::class, 'pay'])->name('zone7.pay');
    Route::get('zone8-pay/{zone8}', [Zone8Controller::class, 'pay'])->name('zone8.pay');
    Route::get('zone9-pay/{zone9}', [Zone9Controller::class, 'pay'])->name('zone9.pay');
    Route::get('zone10-pay/{zone10}', [Zone10Controller::class, 'pay'])->name('zone10.pay');
    Route::get('zone11-pay/{zone11}', [Zone11Controller::class, 'pay'])->name('zone11.pay');
    Route::get('zone12-pay/{zone12}', [Zone12Controller::class, 'pay'])->name('zone12.pay');
    Route::get('zone13-pay/{zone13}', [Zone13Controller::class, 'pay'])->name('zone13.pay');
    Route::get('zone14-pay/{zone14}', [Zone14Controller::class, 'pay'])->name('zone14.pay');
    Route::get('zone15-pay/{zone15}', [Zone15Controller::class, 'pay'])->name('zone15.pay');
    Route::get('zone16-pay/{zone16}', [Zone16Controller::class, 'pay'])->name('zone16.pay');
    Route::get('zone17-pay/{zone17}', [Zone17Controller::class, 'pay'])->name('zone17.pay');
    Route::get('zone18-pay/{zone18}', [Zone18Controller::class, 'pay'])->name('zone18.pay');
    Route::get('zone19-pay/{zone19}', [Zone19Controller::class, 'pay'])->name('zone19.pay');
    Route::get('zone20-pay/{zone20}', [Zone20Controller::class, 'pay'])->name('zone20.pay');
    Route::get('zone21-pay/{zone21}', [Zone21Controller::class, 'pay'])->name('zone21.pay');
    // City Member Pay
    Route::get('city1-pay/{city1}', [City1Controller::class, 'pay'])->name('city1.pay');
    Route::get('city2-pay/{city2}', [City2Controller::class, 'pay'])->name('city2.pay');
    Route::get('city3-pay/{city3}', [City3Controller::class, 'pay'])->name('city3.pay');
    Route::get('city4-pay/{city4}', [City4Controller::class, 'pay'])->name('city4.pay');
    Route::get('city5-pay/{city5}', [City5Controller::class, 'pay'])->name('city5.pay');
    Route::get('city6-pay/{city6}', [City6Controller::class, 'pay'])->name('city6.pay');
    Route::get('city7-pay/{city7}', [City7Controller::class, 'pay'])->name('city7.pay');
    Route::get('city8-pay/{city8}', [City8Controller::class, 'pay'])->name('city8.pay');
    Route::get('city9-pay/{city9}', [City9Controller::class, 'pay'])->name('city9.pay');
    Route::get('city10-pay/{city10}', [City10Controller::class, 'pay'])->name('city10.pay');
    Route::get('city11-pay/{city11}', [City11Controller::class, 'pay'])->name('city11.pay');
    Route::get('city12-pay/{city12}', [City12Controller::class, 'pay'])->name('city12.pay');
    Route::get('city13-pay/{city13}', [City13Controller::class, 'pay'])->name('city13.pay');
    Route::get('city14-pay/{city14}', [City14Controller::class, 'pay'])->name('city14.pay');
    Route::get('city15-pay/{city15}', [City15Controller::class, 'pay'])->name('city15.pay');
    Route::get('city16-pay/{city16}', [City16Controller::class, 'pay'])->name('city16.pay');
    Route::get('city17-pay/{city17}', [City17Controller::class, 'pay'])->name('city17.pay');
    Route::get('city18-pay/{city18}', [City18Controller::class, 'pay'])->name('city18.pay');
    Route::get('city19-pay/{city19}', [City19Controller::class, 'pay'])->name('city19.pay');
    Route::get('honorable-pay/{honorable}', [HonorableController::class, 'pay'])->name('honorable.pay');
    Route::get('abroad-pay/{abroad}', [AbroadController::class, 'pay'])->name('abroad.pay');
    Route::get('regional-pay/{regional}', [RegionalController::class, 'pay'])->name('regional.pay');
    Route::get('arsii-pay/{arsii}', [RegionalController::class, 'pay'])->name('arsii.pay');
    Route::get('arsii_lixaa-pay/{arsii_lixaa}', [RegionalController::class, 'pay'])->name('arsii_lixaa.pay');
    Route::get('baalee-pay/{baalee}', [RegionalController::class, 'pay'])->name('baalee.pay');
    Route::get('booranaa-pay/{booranaa}', [RegionalController::class, 'pay'])->name('booranaa.pay');

    //Zone Member Pay Report
    Route::post('zoneMemberFee-report', [ZoneMemberFeeReport::class, 'index'])->name('zoneMemberFee.report');
    Route::get('zoneMemberFee-index', [ZoneMemberFeeReport::class, 'first'])->name('zoneMemberFee.index');
    Route::get('zoneMemberFee-export/{zone}/{woreda}/{month}/{year}', [ZoneMemberFeeReport::class, 'export'])->name('zoneMemberFee.export');
    // City Member Pay Report
    Route::post('cityMemberFee-report', [CityMemberFeeReport::class, 'index'])->name('cityMemberFee.report');
    Route::get('cityMemberFee-index', [CityMemberFeeReport::class, 'first'])->name('cityMemberFee.index');
    Route::get('cityMemberFee-export/{city}/{month}/{year}', [CityMemberFeeReport::class, 'export'])->name('cityMemberFee.export');
    //Region Member Pay Report
    Route::post('regionMemberFee-report', [RegionMemberFeeReport::class, 'index'])->name('regionMemberFee.report');
    Route::get('regionMemberFee-index', [RegionMemberFeeReport::class, 'first'])->name('regionMemberFee.index');
    Route::get('regionMemberFee-export/{region}/{month}/{year}', [RegionMemberFeeReport::class, 'export'])->name('regionMemberFee.export');
    //
});

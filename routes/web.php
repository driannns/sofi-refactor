<?php

use App\Models\User;
use App\Models\Sidang;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

if(env('APP_ENV') == 'production'){
    URL::forceScheme('https');
}

Route::get('/', function () {
	return view('welcome');
});

Route::get('/login', function () {
	return view('auth.login');
});
Auth::routes(['verify' => true, 'register' => false]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::get('/loginSSO', 'Auth\LoginController@loginSSOTelU')->name('loginSSO');
Route::post('/checkloginSSO', 'Auth\LoginController@checkloginSSOTelU')->name('checkloginSSO');

Route::middleware('auth')->group(function () {

	//All
	Route::get('/notification', function () {
		return view('notif');
	});
	Route::resource('teams', 'TeamController')->middleware('checkRole:RLADM,RLMHS');
	Route::post('teams/individu', 'TeamController@individuSidang')->name('teams. ');
	Route::resource('dokumenLogs', 'DokumenLogController');
	Route::get('sidangs/pembimbing', 'SidangController@indexPembimbing')->name('sidangs.pembimbing');
	Route::get('sidangs/pic', 'SidangController@indexPIC')->name('sidangs.pic');
	Route::post('sidangs/{id}/feedback', 'SidangController@feedbackSidang')->name('sidangs.feedback');
	Route::post('sidangs/{id}/approve', 'SidangController@approveSidang')->name('sidangs.approve');
	Route::post('sidangs/{id}/terimaPengajuan', 'SidangController@terimaPengajuan')->name('sidangs.terimaPengajuan');
	Route::post('sidangs/{id}/tolakPengajuan', 'SidangController@tolakPengajuan')->name('sidangs.tolakPengajuan');
	Route::get('sidangs/all', 'SidangController@indexAll')->name('sidangs.indexAll');
    Route::get('sidangs/surat-tugas', 'SidangController@indexSuratTugasPenguji')->name('sidangs.indexSuratTugasPenguji');
    Route::post('sidangs/{id}/storeSk', 'SidangController@storeSkPenguji')->name('sidangs.storeSkPenguji');
    Route::get('sidangs/{id}/storeSkForm', 'SidangController@uploadSkForm')->name('sidangs.SkPengujiForm');
    Route::get('sidangs/{id}/updateData', 'SidangController@updateData')->name('sidangs.updateData');
	Route::resource('sidangs', 'SidangController');

	//RLMHS
	Route::get('/create-member', 'TeamController@createMember')->middleware('checkRole:RLMHS');
	Route::post('/store-member', 'TeamController@storeMember')->middleware('checkRole:RLMHS');
	Route::get('/slides', 'DokumenLogController@slide')->name('slides.index')->middleware('checkRole:RLMHS');
	Route::post('/slides/upload', 'DokumenLogController@slide_upload')->name('slides.upload')->middleware('checkRole:RLMHS');
	Route::post('/sidangs/sidang-ulang/{id}/update', 'SidangController@updateSidangUlang')->name('sidang-ulang.update');

	//RLADMIN
	Route::resource('roles', 'RoleController')->middleware('checkRole:RLADM');
	// Route::resource('userHasRoles', 'User_has_roleController')->middleware('checkRole:RLADM');
	Route::get('users/syncLecturer', 'UserController@syncLecturer')->name('users.syncLecturer')->middleware('checkRole:RLADM');
	Route::get('users/syncStudents', 'UserController@syncStudents')->name('users.syncStudents')->middleware('checkRole:RLADM');
	Route::resource('users', 'UserController')->middleware('checkRole:RLADM');
	Route::post('/users/addAdmin', 'UserController@addAdmin')->name('users.addAdmin');
	Route::post('/lecturer/delete', 'LecturerController@destroy')->middleware('checkRole:RLADM');
	Route::resource('lecturers', 'LecturerController')->middleware('checkRole:RLADM');
	Route::resource('periods', 'PeriodController')->middleware('checkRole:RLADM,RLPPM');
	Route::resource('cLOS', 'CLOController')->middleware('checkRole:RLADM');
	Route::resource('components', 'ComponentController')->middleware('checkRole:RLADM');
	Route::resource('intervals', 'IntervalController')->middleware('checkRole:RLADM');
	Route::get('components/create/{id}', 'ComponentController@create')->name('components.create')->middleware('checkRole:RLADM');
	Route::get('intervals/create/{id}', 'IntervalController@create')->name('intervals.create')->middleware('checkRole:RLADM');
	Route::get('clo/preview/{period_id}/{study_program_id}/{role}', 'CLOController@preview')->name('clo.preview')->middleware('checkRole:RLADM');
	Route::get('clo/clone', 'CLOController@clone')->name('clo.clone')->middleware('checkRole:RLADM');
	Route::post('clo/clone/proses', 'CLOController@clone_proses')->name('clo.clone.proses')->middleware('checkRole:RLADM');
	Route::get('/score/export/{period}', 'ScoreController@export')->name('exports.score')->middleware('checkRole:RLADM');
	Route::get('/schedule/status_revisi', 'ScheduleController@show_status_revisi')->name('schedule.status_revisi')->middleware('checkRole:RLADM');
	Route::get('/exports', 'DocumentController@exportIndex')->name('export.index');
	Route::post('/exports/process', 'DocumentController@exportDocument')->name('export.proses');
	Route::resource('parameters', 'ParameterController');
    Route::get('schedule/admin-before', 'ScheduleController@indexAdmin')->name('schedule.admin-before')->middleware('checkRole:RLADM');


    //RLPIC
	Route::get('schedule/listEmbed/{sidang_id}', 'ScheduleController@show_schedule_list')->name('schedules.listEmbed');
	Route::resource('schedules', 'ScheduleController');
	Route::get('schedules/delete/{id}', ['as' => 'schedules.delete', 'uses' => 'ScheduleController@destroy']);

	Route::get('schedule/mahasiswa', 'ScheduleController@indexMahasiswa')->name('schedule.mahasiswa')->middleware('checkRole:RLMHS');
	Route::get('schedule/pembimbing', 'ScheduleController@indexPembimbing')->name('schedule.pembimbing')->middleware('checkRole:RLPBB,RLPGJ');
	Route::get('schedule/penguji', 'ScheduleController@indexPenguji')->name('schedule.penguji')->middleware('checkRole:RLPGJ,RLPGJ');
	Route::get('schedule/admin', 'ScheduleController@indexAdmin')->name('schedule.admin')->middleware('checkRole:RLADM');
	Route::get('schedule/bukaAkses', 'ScheduleController@indexPIC')->name('schedule.bukaAkses')->middleware('checkRole:RLDSN');
	Route::get('schedule/bermasalah', 'ScheduleController@indexAdminBermasalah')->name('schedule.adminBermasalah')->middleware('checkRole:RLADM');
	Route::get('schedule/bermasalahSuperAdmin', 'ScheduleController@indexAdminBermasalah')->name('schedule.adminBermasalahSuperAdmin')->middleware('checkRole:RLSPR');
	Route::get('schedule/superadmin', 'ScheduleController@indexAdmin')->name('schedule.superadmin');
	Route::get('schedule/flag/{id}', 'ScheduleController@addFlag')->name('schedule.addFlag')->middleware('checkRole:RLADM');
	Route::get('schedules/create/{id}', 'ScheduleController@create')->name('schedules.create')->middleware('checkRole:RLPIC');
	Route::get('schedule/get_jadwal_dosen_penguji', 'ScheduleController@get_jadwal_dosen_penguji')->name('schedule.get_jadwal_dosen_penguji');
	Route::get('schedule/get_select_jadwal_dosen_penguji', 'ScheduleController@get_select_jadwal_dosen_penguji')->name('schedule.get_select_jadwal_dosen_penguji');
	Route::get('schedule/{id}', 'ScheduleController@popupView');
	Route::post('schedules/berita_acara/{id}', 'ScheduleController@berita_acara')->name('schedules.berita_acara');
	Route::get('berita_acara/{schedule_id}', 'ScheduleController@show_berita_acara')->name('schedules.berita_acara.show');

	Route::resource('attendances', 'AttendanceController');
	Route::post('attendances/{id}/hadir', 'AttendanceController@hadir')->name('attendances.hadir');

	Route::resource('peminatans', 'PeminatanController');

	Route::resource('statusLogs', 'StatusLogController');

	//cetak dokumen
	Route::get('cetak/nilai_sidang/{schedule_id}', 'DocumentController@nilai_sidang')->name('cetak.nilai_sidang');
	Route::get('cetak/berita_acara/{schedule_id}', 'DocumentController@berita_acara')->name('cetak.berita_acara');

	Route::get('download/berita_acara/{schedule_id}', 'DocumentController@berita_acara_unduh')->name('download.berita_acara_unduh');

	Route::get('cetak/form_nilai_penguji/{period_id}/{schedule_id}/{penguji}', 'DocumentController@form_nilai_penguji')->name('cetak.form_nilai_penguji');
	Route::get('cetak/form_nilai_pembimbing/{period_id}/{schedule_id}/{pembimbing}', 'DocumentController@form_nilai_pembimbing')->name('cetak.form_nilai_pembimbing');
	Route::get('cetak/daftar_hadir/{schedule_id}', 'DocumentController@daftar_hadir')->name('cetak.daftar_hadir');
	Route::get('cetak/revisi/{schedule_id}', 'DocumentController@revisi')->name('cetak.revisi');
	Route::get('cetak/all/{schedule_id}/{period_id}', 'DocumentController@cetak_semua')->name('cetak.all');
	Route::get('cetak/index', 'DocumentController@index')->name('cetak.index')->middleware('checkRole:RLADM');

	Route::resource('scores', 'ScoreController');
	Route::get('scores/create/pembimbing/{schedule_id}', 'ScoreController@create')->name('scores.pembimbing.create');
	Route::get('scores/create/penguji/{schedule_id}', 'ScoreController@create')->name('scores.penguji.create');
	Route::get('scores/edit/pembimbing/{schedule_id}', 'ScoreController@edit')->name('scores.pembimbing.edit');
	Route::get('scores/edit/penguji/{schedule_id}', 'ScoreController@edit')->name('scores.penguji.edit');
	Route::get('scores/show/penguji/{schedule_id}', 'ScoreController@show')->name('scores.penguji.show');
	Route::get('/simpulan/{id}', 'ScoreController@show_simpulan')->name('scores.simpulan');
	Route::post('/simpulan/{id}/proses', 'ScoreController@process_simpulan')->name('scores.simpulan.proses');

	Route::get('revisions/syncAll', 'RevisionController@getLastDoc');
	Route::resource('revisions', 'RevisionController');
	Route::get('revisions/delete/{id}', ['as' => 'revisions.delete', 'uses' => 'RevisionController@destroy']);

	Route::get('revisions/create/{schedule_id}', 'RevisionController@create')->name('revisions.create');
	Route::get('revision/mahasiswa', 'RevisionController@indexMahasiswa')->name('revisions.index.mahasiswa');
	Route::get('revision/dosen', 'RevisionController@indexDosen')->name('revisions.index.dosen');
	Route::post('revision/mahasiswa/update', 'RevisionController@ajukanRevisi')->name('revisions.mahasiswa.update');
	// Route::post('revision/dosen/{revision_id}/approve', 'RevisionController@approve')->name('revisions.dosen.approve');
	Route::get('revision/dosen/approve/{revision_id}', 'RevisionController@approve')->name('revisions.dosen.approve');
    Route::get('revision/export/{period}', 'RevisionController@export')->name('exports.revisions')->middleware('checkRole:RLADM,RLPPM');

    Route::post('revision/dosen/{revision_id}/tolak', 'RevisionController@tolak')->name('revisions.dosen.tolak');
	Route::get('revision/log/{revision_id}', 'RevisionController@showRevisionLog')->name('revisions.logsEmbed');
	Route::resource('verifyDocuments', 'Verify_documentController');


	//tambahan
	Route::get('search/schedule/getpenguji1', 'ScheduleController@search');
	Route::get('search/schedule/getpenguji2', 'ScheduleController@search2');
	//===================== tambah guide ==================//
	Route::get('guide-book-student','GBController@student')->name('guide_book_student');
	Route::get('guide-book-admin','GBController@admin')->name('guide_book_admin');
	Route::get('guide-book-PIC','GBController@PIC')->name('guide_book_PIC');
	Route::get('guide-book-pembimbing','GBController@pembimbing')->name('guide_book_pembimbing');
	//===================== tambah guide ==================//

});

//clear cache for cpanel
Route::get('/clear-cache', function () {
	$exitCode = Artisan::call('config:cache');
	return "success";
});
Route::get('doc_verify/{sn_document}', 'Verify_documentController@verify');
Route::get('/fix-extension', 'DokumenLogController@updateExtension');


Route::resource('studyPrograms', 'StudyProgramController');


Route::resource('scorePortions', 'ScorePortionController');

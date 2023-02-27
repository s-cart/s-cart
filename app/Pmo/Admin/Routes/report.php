<?php
if (file_exists(app_path('Admin/Controllers/AdminReportController.php'))) {
    $nameSpaceAdminReport = 'App\Admin\Controllers';
} else {
    $nameSpaceAdminReport = 'App\Pmo\Admin\Controllers';
}
Route::group(['prefix' => 'report'], function () use ($nameSpaceAdminReport) {
    Route::get('/product', $nameSpaceAdminReport.'\AdminReportController@product')->name('admin_report.product');
});
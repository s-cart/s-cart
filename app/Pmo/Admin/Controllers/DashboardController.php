<?php

namespace App\Pmo\Admin\Controllers;

use App\Pmo\Admin\Controllers\RootAdminController;
use App\Pmo\Admin\Models\AdminNews;
use App\Pmo\Admin\Models\AdminProduct;
use App\Pmo\Admin\Models\AdminCustomer;
use App\Pmo\Admin\Models\AdminOrder;
use Illuminate\Http\Request;

class DashboardController extends RootAdminController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index(Request $request)
    {
        //Check user allow view dasdboard
        if (!\Admin::user()->checkUrlAllowAccess(route('admin.home'))) {
            $data['title'] = sc_language_render('admin.dashboard');
            return view($this->templatePathAdmin.'default', $data);
        }

        $data                   = [];
        $data['title']          = sc_language_render('admin.dashboard');
        $data['totalOrder']     = AdminOrder::getTotalOrder();
        $data['totalProduct']   = AdminProduct::getTotalProduct();
        $data['totalNews']      = AdminNews::getTotalNews();
        $data['totalCustomer']  = AdminCustomer::getTotalCustomer();
        $data['topCustomer']    = AdminCustomer::getTopCustomer();
        $data['topOrder']       = AdminOrder::getTopOrder();
        $data['mapStyleStatus'] = AdminOrder::$mapStyleStatus;

        if (config('admin.admin_dashboard.pie_chart_type') == 'country') {
            //Country statistics
            $dataCountries = AdminOrder::getCountryInYear();
            $arrCountryMap   = [];
            $ctTotal = 0;
            $ctTop = 0;
            foreach ($dataCountries as $key => $country) {
                $ctTotal +=$country->count;
                if($key <= 3) {
                    $ctTop +=$country->count;
                    $countryName = $country->country ?? $key ;
                    if($key == 0) {
                        $arrCountryMap[] =  [
                            'name' => $countryName,
                            'y' => $country->count,
                            'sliced' => true,
                            'selected' => true,
                        ];
                    } else {
                        $arrCountryMap[] =  [$countryName, $country->count];
                    }
                }
            }
            $arrCountryMap[] = ['Other', ($ctTotal - $ctTop)];
            $arrDataPie = $arrCountryMap;
            $pieChartTitle = sc_language_render('admin.chart.static_country');
            //End countries
        }

        if (config('admin.admin_dashboard.pie_chart_type') == 'device') {
            //Device statistics
            $dataDevices = AdminOrder::getDeviceInYear();
            $arrDevice   = [];
            foreach ($dataDevices as $key => $row) {
                $arrDevice[] =  [
                    'name' => ucfirst($row->device_type),
                    'y' => $row->count,
                    'sliced' => true,
                    'selected' => ($key == 0) ? true : false,
                ];
            }
            $arrDataPie = $arrDevice;
            $pieChartTitle = sc_language_render('admin.chart.static_device');
            //End Device statistics
        }

        if (config('admin.admin_dashboard.pie_chart_type') == 'order') {
            //Count order in 12 months
            $totalCountMonth = AdminOrder::getCountOrderTotalInYear()
                ->pluck('count', 'ym')->toArray();
            $arrCountOrder = [];
            for ($i = 12; $i >= 0; $i--) {
                $date = date("Y-m", strtotime(date('Y-m-01') . " -$i months"));
                $arrCountOrder[] =  [
                    'name' => '('.$date.')',
                    'y' => $totalCountMonth[$date] ?? 0,
                    'sliced' => true,
                    'selected' => ($i == 0) ? true : false,
                ];
            }
            $arrDataPie = $arrCountOrder;
            $pieChartTitle = sc_language_render('admin.chart.static_count_order');
            //End count order in 12 months
        }

        $data['pieChartTitle'] = $pieChartTitle;
        $data['dataPie'] = json_encode($arrDataPie);



        //Order in 30 days
        $totalsInMonth = AdminOrder::getSumOrderTotalInMonth()->keyBy('md')->toArray();
        $rangDays = new \DatePeriod(
            new \DateTime('-1 month'),
            new \DateInterval('P1D'),
            new \DateTime('+1 day')
        );
        $orderInMonth  = [];
        $amountInMonth  = [];
        foreach ($rangDays as $i => $day) {
            $date = $day->format('m-d');
            $orderInMonth[$date] = $totalsInMonth[$date]['total_order'] ?? '';
            $amountInMonth[$date] = ($totalsInMonth[$date]['total_amount'] ?? 0);
        }
        $data['orderInMonth'] = $orderInMonth;
        $data['amountInMonth'] = $amountInMonth;

        //End order in 30 days
        
        //Order in 12 months
        $totalMonth = AdminOrder::getSumOrderTotalInYear()
            ->pluck('total_amount', 'ym')->toArray();
        $dataInYear = [];
        for ($i = 12; $i >= 0; $i--) {
            $date = date("Y-m", strtotime(date('Y-m-01') . " -$i months"));
            $dataInYear[$date] = $totalMonth[$date] ?? 0;
        }
        $data['dataInYear'] = $dataInYear;
        //End order in 12 months

        return view($this->templatePathAdmin.'dashboard', $data);
    }

    /**
     * Page not found
     *
     * @return  [type]  [return description]
     */
    public function dataNotFound()
    {
        $data = [
            'title' => sc_language_render('admin.data_not_found'),
            'icon' => '',
            'url' => session('url'),
        ];
        return view($this->templatePathAdmin.'data_not_found', $data);
    }


    /**
     * Page deny
     *
     * @return  [type]  [return description]
     */
    public function deny()
    {
        $data = [
            'title' => sc_language_render('admin.deny'),
            'icon' => '',
            'method' => session('method'),
            'url' => session('url'),
        ];
        return view($this->templatePathAdmin.'deny', $data);
    }

    /**
     * [denySingle description]
     *
     * @return  [type]  [return description]
     */
    public function denySingle()
    {
        $data = [
            'method' => session('method'),
            'url' => session('url'),
        ];
        return view($this->templatePathAdmin.'deny_single', $data);
    }
}

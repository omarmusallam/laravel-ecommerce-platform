<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Notification as ModelsNotification;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class DashboardController extends Controller
{
    public function __construct()
    {
        //$this->middleware(['auth'])->only('index');
    }

    // Actions
    public function index()
    {
        // $this->authorize('admin.dashboard', Product::class);
        $title = 'Store';
        $user = Auth::user();

        $todayDate = Carbon::now()->format('Y-m-d');
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');

        $totalProduct = Product::count();
        $totalCategory = Category::count();

        $totalUser = User::count();
        $totalAdmin = Admin::count();

        $totalOrder = Order::count();
        $todayOrder = Order::whereDate('created_at', $todayDate)->count();
        $thisMonthOrder = Order::whereMonth('created_at', $thisMonth)->count();
        $thisYearOrder = Order::whereYear('created_at', $thisYear)->count();

        $chart_options = [
            'chart_title' => 'User by Day',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\User',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'chart_type' => 'bar',
        ];
        $chart1 = new LaravelChart($chart_options);

        return view('dashboard.index', [
            'user' => $user?->name,
            'title' => $title,
            'totalProduct' => $totalProduct,
            'totalCategory' => $totalCategory,
            'totalUser' => $totalUser,
            'totalAdmin' => $totalAdmin,
            'totalOrder' => $totalOrder,
            'todayOrder' => $todayOrder,
            'thisMonthOrder' => $thisMonthOrder,
            'thisYearOrder' => $thisYearOrder,
            'chart1' => $chart1,
        ]);
    }

    public function orderChart(Request $request)
    {
        $group = $request->query('group', 'month');

        $query = Order::select([
            DB::raw('SUM(total) as total'),
            DB::raw('COUNT(*) as count'),
        ])->groupBy(['lable'])->orderBy('lable');

        switch ($group) {
            case 'day':
                $query->addSelect(DB::raw('DATE(created_at) as lable'));
                $query->whereDate('created_at', '>=', Carbon::now()->startOfMonth());
                $query->whereDate('created_at', '<=', Carbon::now()->endOfMonth());

                break;
            case 'week':
                $query->addSelect(DB::raw('DATE(created_at) as lable'));
                $query->whereDate('created_at', '>=', Carbon::now()->startOfWeek());
                $query->whereDate('created_at', '<=', Carbon::now()->endOfWeek());
                break;
            case 'year':
                $query->addSelect(DB::raw('YEAR(created_at) as lable'));
                $query->whereYear('created_at', '>=', Carbon::now()->subYear(5)->year);
                $query->whereYear('created_at', '<=', Carbon::now()->addYear(4)->year);
                break;
            case 'month':
                $query->addSelect(DB::raw('MONTH(created_at) as lable'));
                $query->whereDate('created_at', '>=', Carbon::now()->startOfYear());
                $query->whereDate('created_at', '<=', Carbon::now()->endOfYear());
                // $lables = [
                //     1 => 'Jan',
                //     'Feb',
                //     'Mar',
                //     'Apr',
                //     'May',
                //     'Jun',
                //     'Jul',
                //     'Aug',
                //     'Sep',
                //     'Oct',
                //     'Nov',
                //     'Dec',
                // ];
                break;
            default:
        }

        $entries = $query->get();

        $lables = $total = $count = [];

        foreach ($entries as $entry) {
            $lables[] = $entry->lable;
            $total[$entry->lable] = $entry->total;
            $count[$entry->lable] = $entry->count;
        }

        // foreach ($lables as $month => $name) {
        //     if (!array_key_exists($month, $total)) {
        //         $total[$month] = 0;
        //     }
        //     if (!array_key_exists($month, $count)) {
        //         $count[$month] = 0;
        //     }
        // }

        // ksort($total);
        // ksort($count);

        return [
            'group' => $group,
            'labels' => array_values($lables),
            'datasets' => [
                [
                    'label' => 'Total Sales',
                    'boraderColor' => 'blue',
                    'backgroundColor' => 'blue',
                    'data' => array_values($total),
                ],
                [
                    'label' => 'Orders Number',
                    'boraderColor' => 'darkgreen',
                    'backgroundColor' => 'darkgreen',
                    'data' => array_values($count),
                ],
            ],
        ];
    }
    public function notify()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(15);
        $newCount = $user->unreadNotifications()->count();

        return view('dashboard.notification', compact('notifications', 'newCount'));
    }
    public function markAsRead()
    {
        $user = Auth::user();
        $user = Admin::find($user->id);
        foreach ($user->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        return redirect()->back();
    }
}

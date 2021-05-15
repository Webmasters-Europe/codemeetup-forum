<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostReply;
use App\Models\User;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdminAreaDashboard extends Component
{
    private $numberOfEntitiesOverallChart;
    private $postsCreatedByDateChart;
    private $topFiveUsersPostsChart;
    private $topFiveUsersRepliesChart;
    private $lastSixMonthChart;
    private $monthChart;

    public function mount()
    {
        $this->prepareNumberOfEntitiesOverallChart();
        $this->prepareNumberOfEntitiesCurrentMonthChart();
        $this->preparePostsGroupedByCreationDateChart();
        $this->prepareTopFiveUsersPostsChart();
        $this->prepareTopFiveUsersRepliesChart();
        $this->prepareLastSixMonthChart();
    }

    public function render()
    {
        return view('livewire.admin-area-dashboard', [
            'numberOfEntitiesChart' => $this->numberOfEntitiesOverallChart,
            'postsCreatedByDateChart' => $this->postsCreatedByDateChart,
            'topFiveUsersPostsChart' => $this->topFiveUsersPostsChart,
            'topFiveUsersRepliesChart' => $this->topFiveUsersRepliesChart,
            'lastSixMonthChart' => $this->lastSixMonthChart,
            'monthChart' => $this->monthChart,
        ]);
    }

    private function prepareNumberOfEntitiesOverallChart()
    {
        $this->numberOfEntitiesOverallChart =
            (new ColumnChartModel())
<<<<<<< HEAD
                ->setTitle(__('Number of entities'))
                ->addColumn(__('User'), User::all()->count(), '#90cdf4')
                ->addColumn(__('Categories'), Category::all()->count(), '#f6ad55')
                ->addColumn(__('Posts'), Post::all()->count(), '#fc8181')
                ->addColumn(__('Replies'), PostReply::all()->count(), '#62de76')
                ->withoutLegend()
                ->setDataLabelsEnabled(true);
=======
            ->setTitle('Number of entities overall')
            ->addColumn('Users', User::count(), '#90cdf4')
            ->addColumn('Categories', Category::count(), '#f6ad55')
            ->addColumn('Posts', Post::count(), '#fc8181')
            ->addColumn('Replies', PostReply::count(), '#62de76')
            ->withoutLegend()
            ->setDataLabelsEnabled(true);
    }

    private function prepareNumberOfEntitiesCurrentMonthChart()
    {
        $usersCreatedInCurrentMonth = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        $categoriesCreatedInCurrentMonth = Category::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        $postsCreatedInCurrentMonth = Post::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        $postRepliesCreatedInCurrentMonth = PostReply::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        $this->monthChart =
            (new ColumnChartModel())
            ->setTitle('Entities created this month')
            ->addColumn('Users', $usersCreatedInCurrentMonth, '#90cdf4')
            ->addColumn('Categories', $categoriesCreatedInCurrentMonth, '#f6ad55')
            ->addColumn('Posts', $postsCreatedInCurrentMonth, '#fc8181')
            ->addColumn('Replies', $postRepliesCreatedInCurrentMonth, '#62de76')
            ->withoutLegend()
            ->setDataLabelsEnabled(true);
>>>>>>> 5441d8625062419c62cfb8ef79618dcec417fd3c
    }

    private function preparePostsGroupedByCreationDateChart()
    {
        $dateThreeMonthsAgo = Carbon::now()->subMonths(3);

        $postsGroupedCounted = Post::where('created_at', '>=', Carbon::now()->subMonths(3))
            ->groupBy('created_at')
            ->get([
                DB::raw('DATE( created_at ) as date'),
                DB::raw('COUNT( * ) as "count"'),
            ])
            ->pluck('count', 'date')->toArray();

        $fromDate = $dateThreeMonthsAgo;
        $toDate = Carbon::now();
        $period = CarbonPeriod::create($fromDate, '1 day', $toDate);

        $resultData = [];
        foreach ($period as $dt) {
            $loopDate = $dt->format('Y-m-d');
            if (array_key_exists($loopDate, $postsGroupedCounted)) {
                $resultData[$loopDate] = $postsGroupedCounted[$loopDate];
            } else {
                $resultData[$loopDate] = 0;
            }
        }

        $this->postsCreatedByDateChart =
            (new LineChartModel())
<<<<<<< HEAD
                ->setTitle(__('Number of created Posts (last three months)'))
                ->setGridVisible(true)
                ->setSmoothCurve();
=======
            ->setTitle('Number of created Posts (last three months)')
            ->setGridVisible(true)
            ->setSmoothCurve();
>>>>>>> 5441d8625062419c62cfb8ef79618dcec417fd3c

        foreach ($resultData as $date => $numberOfPosts) {
            $this->postsCreatedByDateChart->addPoint($date, $numberOfPosts);
        }
    }

    private function prepareTopFiveUsersPostsChart()
    {
<<<<<<< HEAD
        $users = User::with('posts')->withCount('posts')
                    ->has('posts')
                    ->orderByDesc('posts_count')
                    ->limit(5)
                    ->get();
        $users->toArray();

        $this->topFiveUsersPostsChart =
            (new PieChartModel())
                ->setTitle(__('Top 5 Users - Most Posts'))
                ->addSlice($users[0]->name, $users[0]->posts_count, '#90cdf4')
                ->addSlice($users[1]->name, $users[1]->posts_count, '#f6ad55')
                ->addSlice($users[2]->name, $users[2]->posts_count, '#fc8181')
                ->addSlice($users[3]->name, $users[3]->posts_count, '#62de76')
                ->addSlice($users[4]->name, $users[4]->posts_count, '#f1f2de')
                ->withoutLegend()
                ->setDataLabelsEnabled(true);
=======
        $users = User::withCount('posts')->orderBy('posts_count', 'DESC')->limit(5)->get();

        $macro = (new PieChartModel())->setTitle('Top 5 Users - Most Posts')->withoutLegend()
            ->setDataLabelsEnabled(true);

        $colors = ['#90cdf4', '#f6ad55', '#fc8181', '#62de76', '#f1f2de'];

        foreach ($users as $key => $user) {
            $macro->addSlice($user->name, (float) $user->posts_count, $colors[$key]);
        }

        $this->topFiveUsersPostsChart = $macro;
>>>>>>> 5441d8625062419c62cfb8ef79618dcec417fd3c
    }

    private function prepareTopFiveUsersRepliesChart()
    {
<<<<<<< HEAD
        $replies = DB::table('post_replies')
            ->selectRaw('user_id, COUNT(*) AS number_replies')
            ->groupBy('user_id')
            ->orderBy('number_replies', 'DESC')
            ->get()
            ->toArray();

        $this->topFiveUsersRepliesChart =
            (new PieChartModel())
                ->setTitle(__('Top 5 Users - Most Replies'))
                ->addSlice(User::find($replies[0]->user_id)->name, $replies[0]->number_replies, '#90cdf4')
                ->addSlice(User::find($replies[1]->user_id)->name, $replies[1]->number_replies, '#f6ad55')
                ->addSlice(User::find($replies[2]->user_id)->name, $replies[2]->number_replies, '#fc8181')
                ->addSlice(User::find($replies[3]->user_id)->name, $replies[3]->number_replies, '#62de76')
                ->addSlice(User::find($replies[4]->user_id)->name, $replies[4]->number_replies, '#f1f2de')
                ->withoutLegend()
                ->setDataLabelsEnabled(true);
=======
        $users = User::withCount('postReplies')->orderBy('post_replies_count', 'DESC')->limit(5)->get();

        $macro = (new PieChartModel())->setTitle('Top 5 Users - Most Replies')->withoutLegend()
            ->setDataLabelsEnabled(true);

        $colors = ['#90cdf4', '#f6ad55', '#fc8181', '#62de76', '#f1f2de'];

        foreach ($users as $key =>  $user) {
            $macro->addSlice($user->name, (float) $user->post_replies_count, $colors[$key]);
        }

        $this->topFiveUsersRepliesChart = $macro;
>>>>>>> 5441d8625062419c62cfb8ef79618dcec417fd3c
    }

    private function prepareLastSixMonthChart()
    {
        $this->lastSixMonthChart =
            (new LineChartModel())
<<<<<<< HEAD
                ->setTitle(__('Last Six Month'))
                ->multiLine()
                ->withoutLegend()
                ->setDataLabelsEnabled(true);
=======
            ->setTitle('Last Six Month')
            ->multiLine()
            ->withoutLegend()
            ->setDataLabelsEnabled(true);
>>>>>>> 5441d8625062419c62cfb8ef79618dcec417fd3c

        $j = 5;
        for ($i = 0; $i <= 5; $i++) {
<<<<<<< HEAD
            $this->lastSixMonthChart->addSeriesPoint(__('Posts'), date('M', mktime(null, null, null, $i)), Post::whereMonth('created_at', '=', $i)->count());
            $this->lastSixMonthChart->addSeriesPoint(__('Replies'), date('M', mktime(null, null, null, $i)), PostReply::whereMonth('created_at', '=', $i)->count());
            $this->lastSixMonthChart->addSeriesPoint(__('User Registrations'), date('M', mktime(null, null, null, $i)), User::whereMonth('created_at', '=', $i)->count());
        }
    }

    private function prepareMonthChart()
    {
        $this->monthChart =
            (new ColumnChartModel())
                ->setTitle(__('This month'))
                ->addColumn(__('User'), User::whereMonth('created_at', '=', now()->month)->count(), '#90cdf4')
                ->addColumn(__('Categories'), Category::whereMonth('created_at', '=', now()->month)->count(), '#f6ad55')
                ->addColumn(__('Posts'), Post::whereMonth('created_at', '=', now()->month)->count(), '#fc8181')
                ->addColumn(__('Replies'), PostReply::whereMonth('created_at', '=', now()->month)->count(), '#62de76')
                ->withoutLegend()
                ->setDataLabelsEnabled(true);
=======
            $month = Carbon::now()->subMonths($j);

            $postsInMonth = Post::whereDate('created_at', '>=', $month)->count();

            $postRepliesInMonth = PostReply::whereDate('created_at', '>=', $month)->count();

            $usersInMonth = User::whereDate('created_at', '>=', $month)->count();

            $this->lastSixMonthChart->addSeriesPoint('Posts', date('M', mktime(null, null, null, $i)), $postsInMonth);
            $this->lastSixMonthChart->addSeriesPoint('Replies', date('M', mktime(null, null, null, $i)), $postRepliesInMonth);
            $this->lastSixMonthChart->addSeriesPoint('User Registrations', date('M', mktime(null, null, null, $i)), $usersInMonth);

            $j--;
        }
>>>>>>> 5441d8625062419c62cfb8ef79618dcec417fd3c
    }
}

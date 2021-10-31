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
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AdminAreaDashboard extends Component
{
    private $numberOfEntitiesOverallChart;
    private $postsCreatedByDateChart;
    private $topFiveUsersPostsChart;
    private $topFiveUsersRepliesChart;
    private $lastSixMonthChart;
    private $monthChart;

    public function mount(): void
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

    private function prepareNumberOfEntitiesOverallChart(): void
    {
        $this->numberOfEntitiesOverallChart =
            (new ColumnChartModel())
            ->setTitle(__('Number of entities'))
            ->addColumn(__('Users'), User::count(), '#90cdf4')
            ->addColumn(__('Categories'), Category::count(), '#f6ad55')
            ->addColumn(__('Posts'), Post::count(), '#fc8181')
            ->addColumn(__('Replies'), PostReply::count(), '#62de76')
            ->withoutLegend()
            ->setDataLabelsEnabled(true);
    }

    private function prepareNumberOfEntitiesCurrentMonthChart(): void
    {
        $usersCreatedInCurrentMonth = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        $categoriesCreatedInCurrentMonth = Category::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        $postsCreatedInCurrentMonth = Post::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        $postRepliesCreatedInCurrentMonth = PostReply::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();

        $this->monthChart =
            (new ColumnChartModel())
            ->setTitle(__('Entities created this month'))
            ->addColumn(__('Users'), $usersCreatedInCurrentMonth, '#90cdf4')
            ->addColumn(__('Categories'), $categoriesCreatedInCurrentMonth, '#f6ad55')
            ->addColumn(__('Posts'), $postsCreatedInCurrentMonth, '#fc8181')
            ->addColumn(__('Replies'), $postRepliesCreatedInCurrentMonth, '#62de76')
            ->withoutLegend()
            ->setDataLabelsEnabled(true);
    }

    private function preparePostsGroupedByCreationDateChart(): void
    {
        $dateThreeMonthsAgo = Carbon::now()->subMonths(3);

        $postsGroupedCounted = Post::where('created_at', '>=', Carbon::now()->subMonths(3))
            ->groupBy('created_at')
            ->select([
                DB::raw('DATE( created_at ) as date'),
                DB::raw('COUNT( * ) as "count"'),
            ])
            ->get()
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
            ->setTitle(__('Number of created Posts (last three months)'))
            ->setGridVisible(true)
            ->setSmoothCurve();

        foreach ($resultData as $date => $numberOfPosts) {
            $this->postsCreatedByDateChart->addPoint($date, $numberOfPosts);
        }
    }

    private function prepareTopFiveUsersPostsChart(): void
    {
        $users = User::withCount('posts')->orderBy('posts_count', 'DESC')->limit(5)->get();

        $macro = (new PieChartModel())->setTitle(__('Top 5 Users - Most Posts'))->withoutLegend()
            ->setDataLabelsEnabled(true);

        $colors = ['#90cdf4', '#f6ad55', '#fc8181', '#62de76', '#f1f2de'];

        foreach ($users as $key => $user) {
            $macro->addSlice($user->name, (float) $user->posts_count, $colors[$key]);
        }

        $this->topFiveUsersPostsChart = $macro;
    }

    private function prepareTopFiveUsersRepliesChart(): void
    {
        $users = User::withCount('postReplies')->orderBy('post_replies_count', 'DESC')->limit(5)->get();

        $macro = (new PieChartModel())->setTitle(__('Top 5 Users - Most Replies'))->withoutLegend()
            ->setDataLabelsEnabled(true);

        $colors = ['#90cdf4', '#f6ad55', '#fc8181', '#62de76', '#f1f2de'];

        foreach ($users as $key =>  $user) {
            $macro->addSlice($user->name, (float) $user->post_replies_count, $colors[$key]);
        }

        $this->topFiveUsersRepliesChart = $macro;
    }

    private function prepareLastSixMonthChart(): void
    {
        Carbon::setLocale(LaravelLocalization::getCurrentLocale());

        $this->lastSixMonthChart =
            (new LineChartModel())
            ->setTitle(__('Last Six Month'))
            ->multiLine()
            ->withoutLegend()
            ->setDataLabelsEnabled(true);

        $from = Carbon::now()->subMonths(5);
        $to = Carbon::now();
        $period = CarbonPeriod::create($from, '1 month', $to);

        foreach ($period as $dt) {
            $this->lastSixMonthChart->addSeriesPoint(__('Posts'), $dt->translatedFormat('F'),
                Post::whereBetween('created_at', [$dt->firstOfMonth()->format('Y-m-d'), $dt->lastOfMonth()->format('Y-m-d')])
                    ->count());

            $this->lastSixMonthChart->addSeriesPoint(__('Replies'), $dt->translatedFormat('F'),
                PostReply::whereBetween('created_at', [$dt->firstOfMonth()->format('Y-m-d'), $dt->lastOfMonth()->format('Y-m-d')])
                    ->count());

            $this->lastSixMonthChart->addSeriesPoint(__('User Registrations'), $dt->translatedFormat('F'),
                User::whereBetween('created_at', [$dt->firstOfMonth()->format('Y-m-d'), $dt->lastOfMonth()->format('Y-m-d')])
                    ->count());
        }
    }
}

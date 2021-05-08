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
use function Ramsey\Uuid\v1;

class AdminAreaDashboard extends Component
{
    private $numberOfEntitiesOverallChart;
    private $postsCreatedByDateChart;
    private $topFiveUsersPostsChart;
    private $topFiveUsersRepliesChart;
    private $lastSixMonthChart;
    private $monthChart;

    private $users;
    private $categories;
    private $posts;
    private $postReplies;

    public function mount()
    {
        $this->users = User::all();
        $this->categories = Category::all();
        $this->posts = Post::all();
        $this->postReplies = PostReply::all();

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
                ->setTitle('Number of entities overall')
                ->addColumn('Users', $this->users->count(), '#90cdf4')
                ->addColumn('Categories', $this->categories->count(), '#f6ad55')
                ->addColumn('Posts', $this->posts->count(), '#fc8181')
                ->addColumn('Replies', $this->postReplies->count(), '#62de76')
                ->withoutLegend()
                ->setDataLabelsEnabled(true);
    }

    private function prepareNumberOfEntitiesCurrentMonthChart()
    {
        $usersCreatedInCurrentMonth = $this->users->filter(function ($user) {
            return $user->created_at->isCurrentMonth();
        });
        $categoriesCreatedInCurrentMonth = $this->categories->filter(function ($category) {
            return $category->created_at->isCurrentMonth();
        });
        $postsCreatedInCurrentMonth = $this->posts->filter(function ($post) {
            return $post->created_at->isCurrentMonth();
        });
        $postRepliesCreatedInCurrentMonth = $this->postReplies->filter(function ($postReply) {
            return $postReply->created_at->isCurrentMonth();
        });

        $this->monthChart =
            (new ColumnChartModel())
                ->setTitle('Entities created this month')
                ->addColumn('Users', sizeof($usersCreatedInCurrentMonth), '#90cdf4')
                ->addColumn('Categories', sizeof($categoriesCreatedInCurrentMonth), '#f6ad55')
                ->addColumn('Posts', sizeof($postsCreatedInCurrentMonth), '#fc8181')
                ->addColumn('Replies', sizeof($postRepliesCreatedInCurrentMonth), '#62de76')
                ->withoutLegend()
                ->setDataLabelsEnabled(true);
    }

    private function preparePostsGroupedByCreationDateChart()
    {

//        $dateThreeMonthsAgo = Carbon::now()->subMonths(3);
//
//        $postsGroupedByDate = $this->posts->filter(function($post) use ($dateThreeMonthsAgo) {
//            return $post->created_at->gte($dateThreeMonthsAgo);
//        })
//        ->groupBy(function($date) {
//            return Carbon::parse($date->created_at)->format('Y-m-d');
//        })->toArray();
//
//        $postsGroupedCounted = [];
//        foreach ($postsGroupedByDate as $key => $posts) {
//            $postsGroupedCounted[$key] = count($posts);
//        }
//
//        $fromDate = $dateThreeMonthsAgo;
//        $toDate = Carbon::now();
//        $period = CarbonPeriod::create($fromDate, '1 day', $toDate);
//
//        $resultData = [];
//        foreach ($period as $dt) {
//            $loopDate = $dt->format("Y-m-d");
//            if (array_key_exists($loopDate, $postsGroupedCounted)) {
//                $resultData[$loopDate] = $postsGroupedCounted[$loopDate];
//            }
//            else {
//                $resultData[$loopDate] = 0;
//            }
//        }

        $postsGroupedByCreationDate = DB::table('posts')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") AS day')
            ->selectRaw('count(*) AS total')
            ->whereRaw('created_at >= DATE(NOW() - INTERVAL 3 MONTH)')
            ->groupBy('day')
            ->pluck('total', 'day')
            ->toArray();

        $this->postsCreatedByDateChart =
            (new LineChartModel())
                ->setTitle('Number of created Posts (last three months)')
                ->setGridVisible(true)
                ->setSmoothCurve();

        foreach ($postsGroupedByCreationDate as $date => $numberOfPosts) {
            $this->postsCreatedByDateChart->addPoint($date, $numberOfPosts);
        }
    }

    private function prepareTopFiveUsersPostsChart()
    {
        $users = User::with('posts')->withCount('posts')
            ->has('posts')
            ->orderByDesc('posts_count')
            ->limit(5)
            ->get();
        $users->toArray();

        $this->topFiveUsersPostsChart =
            (new PieChartModel())
                ->setTitle('Top 5 Users - Most Posts')
                ->addSlice($users[0]->name, $users[0]->posts_count, '#90cdf4')
                ->addSlice($users[1]->name, $users[1]->posts_count, '#f6ad55')
                ->addSlice($users[2]->name, $users[2]->posts_count, '#fc8181')
                ->addSlice($users[3]->name, $users[3]->posts_count, '#62de76')
                ->addSlice($users[4]->name, $users[4]->posts_count, '#f1f2de')
                ->withoutLegend()
                ->setDataLabelsEnabled(true);
    }

    private function prepareTopFiveUsersRepliesChart()
    {
        $replies = DB::table('post_replies')
            ->selectRaw('user_id, COUNT(*) AS number_replies')
            ->groupBy('user_id')
            ->orderBy('number_replies', 'DESC')
            ->get()
            ->toArray();

        $this->topFiveUsersRepliesChart =
            (new PieChartModel())
                ->setTitle('Top 5 Users - Most Replies')
                ->addSlice(User::find($replies[0]->user_id)->name, $replies[0]->number_replies, '#90cdf4')
                ->addSlice(User::find($replies[1]->user_id)->name, $replies[1]->number_replies, '#f6ad55')
                ->addSlice(User::find($replies[2]->user_id)->name, $replies[2]->number_replies, '#fc8181')
                ->addSlice(User::find($replies[3]->user_id)->name, $replies[3]->number_replies, '#62de76')
                ->addSlice(User::find($replies[4]->user_id)->name, $replies[4]->number_replies, '#f1f2de')
                ->withoutLegend()
                ->setDataLabelsEnabled(true);
    }

    private function prepareLastSixMonthChart()
    {
        $this->lastSixMonthChart =
            (new LineChartModel())
                ->setTitle('Last Six Month')
                ->multiLine()
                ->withoutLegend()
                ->setDataLabelsEnabled(true);

        $j = 5;
        for ($i = 0; $i <= 5; $i++) {

            $month = Carbon::now()->subMonths($j)->format('Y-m');

            $postsInMonth = $this->posts->filter(function ($post) use ($month) {
                return $post->created_at->format('Y-m') === $month;
            });

            $postRepliesInMonth = $this->postReplies->filter(function ($postReply) use ($month) {
                return $postReply->created_at->format('Y-m') === $month;
            });

            $usersInMonth = $this->users->filter(function ($user) use ($month) {
                return $user->created_at->format('Y-m') === $month;
            });

            $this->lastSixMonthChart->addSeriesPoint('Posts', date('M', mktime(null, null, null, $i)), $postsInMonth);
            $this->lastSixMonthChart->addSeriesPoint('Replies', date('M', mktime(null, null, null, $i)), $postRepliesInMonth);
            $this->lastSixMonthChart->addSeriesPoint('User Registrations', date('M', mktime(null, null, null, $i)), $usersInMonth);

            $j--;
        }
    }
}

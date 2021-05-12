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
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use function Ramsey\Uuid\v1;

class AdminAreaDashboard extends Component
{
    private $numberOfEntitiesChart;
    private $postsCreatedByDateChart;
    private $topFiveUsersPostsChart;
    private $topFiveUsersRepliesChart;
    private $lastSixMonthChart;
    private $monthChart;

    public function mount()
    {
        $this->prepareNumberOfEntitiesChart();
        $this->preparePostsGroupedByCreationDateChart();
        $this->prepareTopFiveUsersPostsChart();
        $this->prepareTopFiveUsersRepliesChart();
        $this->prepareLastSixMonthChart();
        $this->prepareMonthChart();
    }

    public function render()
    {
        return view('livewire.admin-area-dashboard', [
            'numberOfEntitiesChart' => $this->numberOfEntitiesChart,
            'postsCreatedByDateChart' => $this->postsCreatedByDateChart,
            'topFiveUsersPostsChart' => $this->topFiveUsersPostsChart,
            'topFiveUsersRepliesChart' => $this->topFiveUsersRepliesChart,
            'lastSixMonthChart' => $this->lastSixMonthChart,
            'monthChart' => $this->monthChart,
        ]);
    }

    private function prepareNumberOfEntitiesChart()
    {
        $this->numberOfEntitiesChart =
            (new ColumnChartModel())
                ->setTitle(__('Number of entities'))
                ->addColumn(__('User'), User::all()->count(), '#90cdf4')
                ->addColumn(__('Categories'), Category::all()->count(), '#f6ad55')
                ->addColumn(__('Posts'), Post::all()->count(), '#fc8181')
                ->addColumn(__('Replies'), PostReply::all()->count(), '#62de76')
                ->withoutLegend()
                ->setDataLabelsEnabled(true);
    }

    private function preparePostsGroupedByCreationDateChart()
    {
        $postsGroupedByCreationDate = DB::table('posts')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") AS day')
            ->selectRaw('count(*) AS total')
            ->whereRaw('created_at >= DATE(NOW() - INTERVAL 3 MONTH)')
            ->groupBy('day')
            ->pluck('total', 'day')
            ->toArray();

        $this->postsCreatedByDateChart =
            (new LineChartModel())
                ->setTitle(__('Number of created Posts (last three months)'))
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
                ->setTitle(__('Top 5 Users - Most Posts'))
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
                ->setTitle(__('Top 5 Users - Most Replies'))
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
                ->setTitle(__('Last Six Month'))
                ->multiLine()
                ->withoutLegend()
                ->setDataLabelsEnabled(true);

        for ($i = 0; $i <= 5; $i++) {
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
    }
}

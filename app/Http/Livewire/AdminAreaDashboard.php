<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostReply;
use App\Models\User;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdminAreaDashboard extends Component
{
    private $numberOfEntitiesChart;
    private $postsCreatedByDateChart;

    public function mount()
    {
        $this->prepareNumberOfEntitiesChart();
        $this->preparePostsGroupedByCreationDateChart();
    }

    public function render()
    {
        return view('livewire.admin-area-dashboard', [
            'numberOfEntitiesChart' => $this->numberOfEntitiesChart,
            'postsCreatedByDateChart' => $this->postsCreatedByDateChart
        ]);
    }

    private function prepareNumberOfEntitiesChart()
    {
        $this->numberOfEntitiesChart =
            (new ColumnChartModel())
                ->setTitle('Number of entities')
                ->addColumn('User', User::all()->count(), '#90cdf4')
                ->addColumn('Categories', Category::all()->count(), '#f6ad55')
                ->addColumn('Posts', Post::all()->count(), '#fc8181')
                ->addColumn('Replies', PostReply::all()->count(), '#62de76')
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
                ->setTitle('Number of created Posts (last three months)')
                ->setGridVisible(true)
                ->setSmoothCurve();

        foreach ($postsGroupedByCreationDate as $date => $numberOfPosts) {
            $this->postsCreatedByDateChart->addPoint($date, $numberOfPosts);
        }
    }
}

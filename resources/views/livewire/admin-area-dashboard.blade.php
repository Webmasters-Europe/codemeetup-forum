<div class="row">
    <div class="chart col-12 col-md-6">
        <livewire:livewire-column-chart
            :column-chart-model="$numberOfEntitiesChart"/>
    </div>

    <div class="chart col-12 col-md-6">
        <livewire:livewire-line-chart
            :line-chart-model="$postsCreatedByDateChart"/>
    </div>
</div>

<div class="row">
    <div class="chart col-12 col-md-6">
        <livewire:livewire-pie-chart
            :pie-chart-model="$topFiveUsersPostsChart"/>
    </div>

    <div class="chart col-12 col-md-6">
        <livewire:livewire-pie-chart
            :pie-chart-model="$topFiveUsersRepliesChart"/>
    </div>
</div>

<div class="row">
    <div class="chart col-12 col-md-6">
        <livewire:livewire-line-chart
            :line-chart-model="$lastSixMonthChart"/>
    </div>

    <div class="chart col-12 col-md-6">
        <livewire:livewire-column-chart
            :column-chart-model="$monthChart"/>
    </div>
</div>




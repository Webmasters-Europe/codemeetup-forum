<div class="row">
    <div class="col-md-6 w-50" style="height: 32rem">
        <livewire:livewire-column-chart
            :column-chart-model="$numberOfEntitiesChart"/>
    </div>

    <div class="col-md-6 w-50" style="height: 32rem">
        <livewire:livewire-line-chart
            :line-chart-model="$postsCreatedByDateChart"/>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('css/timeline.css') }}">
<div style="display:inline-block; width:100%; overflow-y:auto; margin-top: -100px">
    <ul class="timeline timeline-horizontal">
        @foreach ($timelineList as $inex => $timeline)
            <li class="timeline-item">
                <div class="timeline-badge bg-primary"><i class="glyphicon glyphicon-check"></i></div>
                <div class="card card-body timeline-panel border border-primary m-0">
                    <div class="timeline-heading">
                        <h6 class="timeline-title">{{ $timeline->description }}</h6>
                        <p>
                            <small class="text-muted"><i class="glyphicon glyphicon-time"></i>
                                {{ $timeline->created_at }}
                            </small>
                        </p>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>

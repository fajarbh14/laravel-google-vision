<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                {{ $breadcrumb_title ?? '' }}
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                        {{ $slot ?? ''}}
                    </ol>
                </div>            
        </div>
    </div>
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                &nbsp;
                <div class="page-title-right d-flex flex-row-reverse">
                    <ol class="breadcrumb">
                        {{ $action ?? ''}}
                    </ol>
                </div>            
        </div>
    </div>
</div>

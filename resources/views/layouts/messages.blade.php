            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        @if($path && count($path)>0)
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item active"><a href="/">Home</a></li>
                            @foreach($path as $url=>$value)
                            <li class="breadcrumb-item active"><a href="{{$url}}">{{$value}}</a></li>
                            @endforeach
                            
                        </ol>
                        @endif
                    </div>
                    <h4 class="page-title">{{$title}}</h4>
                </div>
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @elseif(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                @if($errors->any())
                <ul class="alert alert-danger">
                    @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
                @endif
            </div>

<div class="col-sm-12">
    <div class="starterpage_tabs">
        <a href="/setup" class="back-link"><i class="fa fa-arrow-left"></i>Back</a>
        <ul class="nav nav-tabs navtab-bg">
            @if(isset($tabList) && count($tabList)>0)
            @foreach($tabList['tab'] as $tab)
            <li class="nav-item">
                <a href="/{{$tab['link']}}"  aria-expanded="{{$tab['link']==$tabList['selected']?true:false}}" class="nav-link {{$tab['link']==$tabList['selected']?'active':''}}">{{$tab['name']}}</a>
            </li>
            @endforeach
            @endif
        </ul>
    </div>
</div>



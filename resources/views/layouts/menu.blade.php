<div class="col-sm-12">
    <div class="starterpage_tabs">
        <ul class="nav nav-tabs navtab-bg nav-justified">
            <li class="nav-item">
                <a href="history.back()" class="nav-link back-link"><i class="fa fa-arrow-left"></i>Back</a>
            </li>
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



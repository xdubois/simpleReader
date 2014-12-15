<hr />
<ul class="nav nav-list">
  <li><a href="{{ route('article.view', 'all') }}"><i class="glyphicon glyphicon-fire"></i>
    <strong> All items ({{ $counter['total_unread'] }})</strong>
  </a>
</li>
<li>
 <a href="{{ route('article.view', 'stared') }}"><i class="glyphicon glyphicon-star"></i> Starred items ({{ $counter['favorite'] }})</a>
</li>
</ul>
<hr />
<ul class="nav nav-list">  
  @foreach ($subscriptions as $folder => $feeds)
  <li class="nav-header">
  <a href="{{ route('article.view', $folder) }}">FOLDER 
     {{ $folder}} 
      @if(isset($counter[$folder]))
        ({{ $counter[$folder] }})
      @endif
   </a>
 </li>

 @foreach ($feeds as $feed)

 <li><a href="{{ route('article.view', $feed->id) }}">{{ $feed->name }} 
  @if(isset($counter['feeds'][$feed->id]))
 ({{ $counter['feeds'][$feed->id]}})
  @endif


 </a></li>
 @endforeach
 @endforeach
</ul>
<hr />
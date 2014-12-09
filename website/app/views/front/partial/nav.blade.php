<hr />
<ul class="nav nav-list">
  <li><a href="#"><i class="glyphicon glyphicon-fire"></i>
    <strong> All items ({{ $counter['total_unread'] }})</strong>
  </a>
</li>
<li>
 <a href="#"><i class="glyphicon glyphicon-star"></i> Starred items ({{ $counter['favorite'] }})</a>
</li>
</ul>
<hr />
<ul class="nav nav-list">  
@foreach ($subscriptions as $folder => $feeds)
  <li class="nav-header"> {{ $folder}} ({{ $counter[$folder] }})</li>

  @foreach ($feeds as $feed)

  <li><a href="#">{{ $feed->name }}  ({{ $counter['feeds'][$feed->id]}})</a></li>
  @endforeach
@endforeach
</ul>
<hr />
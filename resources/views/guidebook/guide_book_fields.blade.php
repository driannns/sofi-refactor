@if( auth()->user()->isAdmin())

@elseif (auth()->user()->isPembimbing())

@elseif ( auth()->user()->isPIC())

@elseif (auth()->user()->isPenguji())
<embed type="" src="{{ asset('guide_book/pengujipembimbingguide.pdf') }}" height="500px" width="100%">
@elseif (auth()->user()->isStudent())

@elseif (auth()->user()->isSuperadmin())
<embed type="" src="{{ asset('guide_book/adminguide.pdf') }}" height="500px" width="100%">
@endif

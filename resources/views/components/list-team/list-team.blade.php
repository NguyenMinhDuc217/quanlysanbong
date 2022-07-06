@foreach($teams as $team)
<div> Tên đội{{$team->team_name}}</div>
<div>Đội trưởng: {{$team->user_name}}</div>
<div>Thành viên: {{$team->team_member}}</div>
<div>Link: {{$team->link}}</div>
@endforeach
<div class="hompage_pagination">
    {{$teams->links('components.pagination.custom')}}
</div>
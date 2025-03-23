<form action="{{ route('schedules.update', $schedule->id) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="text" name="day" value="{{ $schedule->day }}" required>
    <input type="time" name="start_time" value="{{ $schedule->start_time }}" required>
    <input type="time" name="end_time" value="{{ $schedule->end_time }}" required>
    <input type="text" name="subject" value="{{ $schedule->subject }}" required>
    <button type="submit">Mettre à jour</button>
</form>
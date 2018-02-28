<div class="col-lg-6">

    <div class="profilepic"><img class="profilepicsize" src="../{{ $contact->avatar }}" /></div>
    <h1>{{ $contact->name }} </h1>
    <!--MAIL-->
    <p><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
        <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
    <!--Work Phone-->
    <p><span class="glyphicon glyphicon-headphones" aria-hidden="true"></span>
        <a href="tel:{{ $contact->work_number }}">{{ $contact->work_number }}</a></p>

    <!--Personal Phone-->
    <p><span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
        <a href="tel:{{ $contact->personal_number }}">{{ $contact->personal_number }}</a></p>

    <!--Address-->
    @if(\Auth::id() == $contact->id)
    <p><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        <a href="{{ route("users.edit", $contact->id) }}">Sửa</a></p>
    @endif
</div>
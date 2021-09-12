{!! Form::open(['method'=>'POST','url'=>'contact/send','class'=>'wpcf7-form','id'=>'myForm']) !!}
<label for="name"></label>
<p><i class="linearicon linearicon-man"></i>
    <span class="wpcf7-form-control-wrap">
        <input type="text" id="name" name="name" value="{{ old('name') }}" size="40" class="" required placeholder="Nume complet" />
    </span>
</p>
@if ($errors->has('name')) <span class="error_message">{{ $errors->first('name') }}</span> @endif

<label for="phone"></label>
<p><i class="linearicon linearicon-telephone"></i>
    <span class="wpcf7-form-control-wrap">
        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" size="40" class="" required placeholder="Telefon (doar cifre)" />
    </span>
</p>
@if ($errors->has('phone')) <span class="error_message">{{ $errors->first('phone') }}</span> @endif

<label for="email"></label>
<p><i class="linearicon linearicon-envelope"></i>
    <span class="wpcf7-form-control-wrap">
        <input type="email" name="email" id="email" value="{{ old('email') }}" size="40" class="" required  placeholder="Adresa de e-mail" />
    </span>
</p>
@if ($errors->has('email')) <span class="error_message">{{ $errors->first('email') }}</span> @endif

<label for="subject"></label>
<p><i class="linearicon linearicon-inbox"></i>
    <span class="wpcf7-form-control-wrap">
        <input type="text" name="subject" id="subject" value="{{ old('subject') }}" size="40" class="" required  placeholder="Subiect" />
    </span>
</p>
@if ($errors->has('subject')) <span class="error_message">{{ $errors->first('subject') }}</span> @endif

<label for="mesaj"></label>
<p><i class="linearicon linearicon-feather"></i>
    <span class="wpcf7-form-control-wrap">
        <textarea name="message" id="mesaj" cols="40" rows="10" class="" required placeholder="Mesajul dumneavoastra...">{{ old('message') }}</textarea>
    </span>
</p>
@if ($errors->has('message')) <span class="error_message">{{ $errors->first('message') }}</span> @endif
<input type="submit" value="Trimite" class="wpcf7-form-control wpcf7-submit">
<input type="reset" value="Reset" class="btn btn-default">
{!! Form::close() !!}
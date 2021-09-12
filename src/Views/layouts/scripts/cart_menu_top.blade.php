<ul>
    <li>
        <a href="{{ url('/cart') }}" id="cart" class=""><?=(Cart::count()>0)?'Aveți '.Cart::count().' produse in cos':'Cos de cumpărături'; ?></a>
    </li>
    @if(Auth::guard('customer')->check())
        <form action="{{ route('customer.logout') }}" method="POST" id="customer_logout"> @csrf @method('POST') </form>
        <li><a href="{{ route('customer.profile') }}" class="">Profil [ {{ Auth::guard('customer')->user()->email }} ]</a></li>
        <li>
            <button type="submit" form="customer_logout">Logout</button>
        </li>
    @else
        <li><a href="{{ route('customer.showLoginForm') }}" class="">Login</a></li>
        <li><a href="{{ route('customer.showRegistrationForm') }}" class="">Cont nou</a></li>
    @endif
</ul>

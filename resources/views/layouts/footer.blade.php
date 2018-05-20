<footer class="footer">
        <div class="container">
            <nav>
                <ul class="footer-menu">
                    @auth
                    @if (Auth::user()->isAdmin)
                        <li>
                            <a href="{{route('voyager.dashboard')}}">
                                Back-end
                            </a>
                        </li>
                    @endif
                    @endauth
                </ul>
                <p class="copyright text-center">
                    ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                    Produzido por <a href="http://brtech.tk">BRtech Sistemas</a>
                </p>
            </nav>
        </div>
    </footer>

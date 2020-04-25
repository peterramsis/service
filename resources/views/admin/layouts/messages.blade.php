<div class="message_site text-center">

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if (session("success"))
            <div class="alert alert-success" aria-hidden="true">
                <p class="text-center">{{session("success")}}</p>
            </div>
        @endif
        
        @if (session("error"))
            <div class="alert alert-danger" aria-hidden="true">
                <p class="text-center">
                    {{session("error")}}
                </p>
            </div>
        @endif

</div>
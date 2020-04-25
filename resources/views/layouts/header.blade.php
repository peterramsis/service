<!--Hey! This is the original version
    of Simple CSS Waves-->
    
    <div class="header">

            <nav class="navbar navbar-expand navbar-light">
                    <div class="container">
                            <a class="navbar-brand" href="{{route('home')}}">
                                <img src="{{asset('assets/images/white.png')}}" alt="" srcset="" style="width:140px">
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                  </button>
                                
                                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <ul class="navbar-nav ml-auto">
                                      <li>
                                        <i class="fas fa-shopping-cart icon-cart nav-link"></i>
                                      </li>
                                    
                          
                                      <li class="nav-item dropdown">
                                          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{ Sentinel::getUser()->username }}
                                          </a>
                                          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                                  <a class="dropdown-item" href="{{ url('/admin') }}">Admin Panel</a>
                                                  <a class="dropdown-item" href="{{ route("yourOrder") }}">Your order</a>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                                 onclick="event.preventDefault();
                                                                               document.getElementById('logout-form').submit();">
                                                                  {{ __('Logout') }}
                                                              </a>
                                  
                                                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                                  @csrf
                                                              </form>
                                          </div>
                                        </li>
                                    </ul>
                                  
                                  </div>
                        </div>
                  </nav>
    
    <!--Content before waves-->
    <div class="inner-header flex">
       {{$slot}}
    </div>
    
    <!--Waves Container-->
    <div>
    <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
    viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
    <defs>
    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
    </defs>
    <g class="parallax">
    <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
    <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
    <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
    <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
    </g>
    </svg>
    </div>
    <!--Waves end-->
    
    </div>
    <!--Header ends-->
    
<img src="{{asset('assets/images/boy.png')}}" alt="" class="img-anim">
<footer>
  
  
        <div class="container">
          <div class="row footer-body text-center">
            <div class="col-lg-4 col-md-4 col-12">
              <div class="logo-footer"><img class="img-fluid" src="{{asset('assets/images/white.png')}}"/></div>
            </div>
            <div class="col-lg-4 col-md-4 col-12">
                <section class="section_header text-center">
                    <h4>
                        <span>Tags</span>
                    </h4>
                </section>
              
                @foreach (App\tag::all() as $item_tag)
                   <span> <a class="link-footer" href="{{route('tag_game',$item_tag->tag_name)}}">{{$item_tag->tag_name}}</a></span>,
                @endforeach
              
            </div>
            <div class="col-lg-4 col-md-4 col-12">
                <section class="section_header text-center">
                    <h4>
                        <span>Cats</span>
                    </h4>
                </section>
              <ul class="list-unstyled">
                <li> <a class="link-footer" href="#">Cat-one</a></li>
                <li> <a class="link-footer" href="#">Cat-one</a></li>
                <li> <a class="link-footer" href="#">Cat-one</a></li>
                <li> <a class="link-footer" href="#">Cat-one</a></li>
                <li> <a class="link-footer" href="#">Cat-one</a></li>
                <li> <a class="link-footer" href="#">Cat-one</a></li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
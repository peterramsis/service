<template>
    <div class="Home">
      
      <div class="container">
          <div class="row">
              <div class="col-lg-4 offset-lg-3 col-sm-12">
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Register</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Login</a>
  </li>
 
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

  <form class="splash-container" method="POST" enctype="multipart/form-data">
      
        <div class="card">
            <div class="card-header">
                <h3 class="mb-1">Registrations Form</h3>
                <p>Please enter your user information.</p>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="first_name" placeholder="First Name" >
                </div>
                <div class="form-group">
                        <input class="form-control form-control-lg" type="text" name="last_name"  placeholder="Last Name" >
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" type="date" name="birthday"  placeholder="Your birthday" >
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" type="file" name="image" placeholder="Image profile" >
                    </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="username"  placeholder="Username" >
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="email" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" id="password" type="password"  placeholder="Password" name="password">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" placeholder="Confirm" name="password_confirmation" type="password">
                </div>
                <div class="form-group pt-2">
                    <button class="btn btn-block btn-primary" type="submit">Register My Account</button>
                </div>
            
            </div>
            
        </div>
    </form>


  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">


 <form method="post">
                  
                <div class="form-group">
                    <input class="form-control form-control-lg" id="email" type="text" placeholder="Username Or Email" name="email">
              
                                    <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                  
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" id="password" type="password" placeholder="Password" name="password">
                   
                    <span class="invalid-feedback" role="alert">
                      
                    </span>
                  
                </div>
                <div class="form-group">
                    <label class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" name="remember"><span class="custom-control-label">Remember Me</span>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
            </form>


  </div>
</div>
              </div>
          </div>
      </div>

    </div>
</template>


<script>

export default {
    name:"Home"
}
</script>
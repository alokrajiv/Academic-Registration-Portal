<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" arialabbelledby="loginModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">Login</h3>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-2 col-md-offset-2 col-lg-2 col-lg-offset-2 col-sm-2 col-sm-offset-2 col-xs-2 col-xs-offset-2 ">
                <h4 ><a href="#" class="modal-links" id="acc">Accounts</a></h4>
              </div>
              <div class="col-md-2 col-md-offset-4 col-lg-2 col-lg-offset-4 col-sm-2 col-sm-offset-4 col-xs-2 col-xs-offset-4">
                <h4><a href="#" class="modal-links" id="adm">Admin</a></h4>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2 col-md-offset-2 col-lg-2 col-lg-offset-2 col-sm-2 col-sm-offset-2 col-xs-2 col-xs-offset-2 ">
                <h4><a href="#" class="modal-links" id="par">Parents</a></h4>
              </div>
              <div class="col-md-2 col-md-offset-4 col-lg-2 col-lg-offset-4 col-sm-2 col-sm-offset-4 col-xs-2 col-xs-offset-4" >
                <h4><a href="/login/google-login-redirect/"class="modal-links" target="_blank" id="stud">Students</a></h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>
    attachRedirect("acc", "/login/google-login-redirect/");
    attachRedirect("adm", "/login/google-login-redirect/");
    attachRedirect("stud", "/login/google-login-redirect/");
    attachRedirect("par", "/login/google-login-redirect/");
    function attachRedirect(id, url){
      $('#'+id).click(function(){
        window.location(url);
      });
    }
  </script> 
function ingresar(){
  var usuario  = $('#usuario').val();
  var password = $('#password').val();
  if(usuario == null){
    msj('error', 'Ingrese un usuario');
    return;
  }
  if(password == null){
    msj('error', 'Ingrese un usuario');
    return;
  }
  $.ajax({
    data : {usuario : usuario,
            password : password},
    url  : 'login/ingresar',
    type : 'POST'
  }).done(function(data){
    try{
        data = JSON.parse(data);
        if(data.error == 0){
          location.href = 'admin';
          $('#usuario').val("");
          $('#password').val("");
        }else {
          msj('error', data.msj);
          return;
        }
      }catch(err){
        msj('error',err.message);
      }
  });
}
function cerrarCesion(){
  $.ajax({
    url  : 'admin/cerrarCesion',
    type : 'POST'
  }).done(function(data){
    try{
        data = JSON.parse(data);
        if(data.error == 0){
          location.href = 'Login';
        }else {
          return;
        }
      }catch(err){
        msj('error',err.message);
      }
  });
}
function verificarDatos(e){
  if(e.keyCode === 13){
    e.preventDefault();
    ingresar();
    }
}
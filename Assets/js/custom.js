// Aqui funciones generales

//Alertas de plugin sweetalert2
function alertaPersonalizada(type, mensaje) {
  Swal.fire({
    position: "center",
    icon: type,
    title: mensaje,
    showConfirmButton: false,
    timer: 1500,
  });
}

//Eliminar un registro
function eliminarRegistro(title, text, accion, url, table) {
  Swal.fire({
    title: title,
    text: text,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: accion,
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const http = new XMLHttpRequest();

      http.open("GET", url, true);

      http.send();

      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.response);
          alertaPersonalizada(res.tipo, res.mensaje);
          //si a podido eliminar usuario lo borra de la tabla
          if(res.tipo == 'success'){
            if(table = "ventana"){
              setTimeout(function() {window.location.reload()}, 1500); 
            }else{
              table.ajax.reload();
            }
            
          }
        }
      };
    }
  });
}

//Acorta la longitud de un string
function acortarString(str, tam) {
  if (str.length > tam) {
    return str.substring(0, 50) + "...";
  } else {
    return str;
  }
}